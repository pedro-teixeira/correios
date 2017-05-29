<?php

/**
 * This source file is subject to the MIT License.
 * It is also available through http://opensource.org/licenses/MIT
 *
 * @category  PedroTeixeira
 * @package   PedroTeixeira_Correios
 * @author    Pedro Teixeira <hello@pedroteixeira.io>
 * @copyright 2015 Pedro Teixeira (http://pedroteixeira.io)
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/pedro-teixeira/correios
 */
class PedroTeixeira_Correios_Model_Cache
    extends Varien_Object
{
    /**
     * Code property
     *
     * @var string
     */
    protected $_code = 'pedroteixeira_correios';

    /**
     * Core cache instance
     *
     * @var Zend_Cache_Core
     */
    private $_cache = null;

    /**
     * Retrieve cache instance.
     *
     * @return Zend_Cache_Core
     */
    private function getCache()
    {
        if ($this->_cache == null) {
            $this->_cache = Mage::app()->getCache();
        }
        return $this->_cache;
    }

    /**
     * Retrieve Zip Tags
     *
     * @return array
     */
    protected function getZipTags()
    {
        $padLength = $this->getConfigData('cache_accuracy/zip');
        $zipLength = $padLength - 1;
        $tags      = array();
        $tags[]    = "ZIP_" . str_pad(substr($this->getData('sCepDestino'), 0, $zipLength--), $padLength, '0');
        $tags[]    = "ZIP_" . str_pad(substr($this->getData('sCepDestino'), 0, $zipLength--), $padLength, '0');
        $tags[]    = "ZIP_" . str_pad(substr($this->getData('sCepDestino'), 0, $zipLength--), $padLength, '0');
        $tags[]    = "ZIP_" . str_pad(substr($this->getData('sCepDestino'), 0, $zipLength--), $padLength, '0');
        return $tags;
    }

    /**
     * Retrieve Weight Tags
     *
     * @return array
     */
    protected function getWeightTags()
    {
        $tags   = array();
        $tags[] = "WEIGHT_" . floor($this->getData('nVlPeso'));
        $tags[] = "WEIGHT_" . ceil($this->getData('nVlPeso'));
        return $tags;
    }

    /**
     * Retrieve Size Tags
     *
     * @return array
     */
    protected function getSizeTags()
    {
        $tags   = array();
        $type   = ($this->getData('nVlAltura') < 40) ? 'REAL' : 'UNDEFINED';
        $tags[] = "SIZE_{$type}";
        return $tags;
    }

    /**
     * Retrieve Post Methods Tags
     *
     * @return array
     */
    protected function getPostMethodsTags()
    {
        $tags = explode(',', $this->getData('nCdServico'));
        return $tags;
    }

    /**
     * When
     *      ZIP: 51038245
     *      WEIGHT: 1.3kg
     *      SIZE: 22cm
     *
     * Return example:
     *   array(
     *      41068,
     *      81019,
     *      ZIP_51038240,
     *      ZIP_51038200,
     *      ZIP_51038000,
     *      WEIGHT_1,
     *      WEIGHT_2,
     *      SIZE_REAL,
     *      PEDROTEIXEIRA_CORREIOS
     *   )
     *
     * @return array
     */
    protected function getCacheTags()
    {
        $tags   = array();
        $tags   = array_merge($tags, $this->getPostMethodsTags());
        $tags   = array_merge($tags, $this->getZipTags());
        $tags   = array_merge($tags, $this->getWeightTags());
        $tags   = array_merge($tags, $this->getSizeTags());
        $tags[] = 'PEDROTEIXEIRA_CORREIOS';
        return $tags;
    }

    /**
     * Return example:
     *        41068x40096x81019_10_16_51030240
     *
     * @return string
     */
    protected function _getId()
    {
        $weight  = round($this->getData('nVlPeso'), $this->getConfigData('cache_accuracy/weight'));
        $zip     = substr($this->getData('sCepDestino'), 0, $this->getConfigData('cache_accuracy/zip'));
        $size    = round($this->getData('nVlAltura'), $this->getConfigData('cache_accuracy/size'));
        $methods = str_replace(',', 'x', $this->getData('nCdServico'));
        $cacheId = "{$methods}_{$weight}_{$size}_{$zip}";
        $cacheId = preg_replace("/[^[:alnum:]^_]/", "", $cacheId);
        return $cacheId;
    }

    /**
     * Retrieve the cache content.
     *
     * @return string
     */
    public function load()
    {
        $data = $this->loadById();
        if (!$data) {
            $data = $this->loadByTags();
        }
        return $data;
    }

    /**
     * Retrieve the cache content by key.
     *
     * @return string
     */
    public function loadById()
    {
        $id   = $this->_getId();
        $data = $this->getCache()->load($id);
        if ($data) {
            Mage::log("{$this->_code} [cache]: mode={$this->getConfigData('cache_mode')} status=hit");
        }
        return $data;
    }

    /**
     * Iterates over the ZIP codes, and returns the closest match.
     *
     * @return string
     */
    public function loadByTags()
    {
        $data      = false;
        $padLength = $this->getConfigData('cache_accuracy/zip');
        for ($i = 1; $i < 5; $i++) {
            $zipTag = str_pad(substr($this->getData('sCepDestino'), 0, $padLength - $i), $padLength, '0');
            $tags   = array();
            $tags   = array_merge($tags, $this->getPostMethodsTags());
            $tags   = array_merge($tags, $this->getWeightTags());
            $tags   = array_merge($tags, $this->getSizeTags());
            $tags[] = 'PEDROTEIXEIRA_CORREIOS';
            $tags[] = "ZIP_{$zipTag}";
            $keys   = $this->getCache()->getIdsMatchingTags($tags);
            if (count($keys)) {
                Mage::log("{$this->_code} [cache]: mode={$this->getConfigData('cache_mode')} status=hit tag=zip");
                $data = $this->getCache()->load($keys[0]);
                break;
            }
        }
        return $data;
    }

    /**
     * Validate the response data from Correios.
     * This method will choose between Request Cache or Save in Cache
     *
     * Step 1:
     *     Invalid responses must call the Cache load.
     *     Cache loading is requested by throwing adapter exception.
     *
     * Step 2:
     *     To save valid responses, it must contain no errors.
     *     Errors are detected by pattern_nocache and returns false.
     *
     * @param string $data XML Content
     *
     * @throws Zend_Http_Client_Adapter_Exception
     *
     * @return boolean
     */
    protected function _isValidCache($data)
    {
        // Step 1
        try {
            $response = Zend_Http_Response::fromString($data);
            $content = $response->getBody();
        } catch (Zend_Http_Exception $e) {
            throw new Zend_Http_Client_Adapter_Exception($e->getMessage());
        }
        
        if (empty($content)) {
            throw new Zend_Http_Client_Adapter_Exception();
        }
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($content);
        if (!$xml || !isset($xml->cServico)) {
            throw new Zend_Http_Client_Adapter_Exception();
        }
        
        // Step 2
        $pattern = $this->getConfigData('pattern_nocache');
        if ($pattern != '' && preg_match($pattern, $content, $matches)) {
            return false;
        }
        return true;
    }

    /**
     * Save Correios content, tags and expiration period.
     *
     * @param string $data XML Content
     *
     * @return boolean|PedroTeixeira_Correios_Model_Cache
     */
    public function save($data)
    {
        if ($this->_isValidCache($data)) {
            $id = $this->_getId();
            $tags = $this->getCacheTags();
            if ($this->getCache()->save($data, $id, $tags)) {
                Mage::log("{$this->_code} [cache]: mode={$this->getConfigData('cache_mode')} status=write key={$id}");
            }
        }
        return $this;
    }

    /**
     * Retrieve information from carrier configuration
     *
     * @param string $field Field
     *
     * @return mixed
     */
    public function getConfigData($field)
    {
        if (empty($this->_code)) {
            return false;
        }
        $path = 'carriers/' . $this->_code . '/' . $field;
        return Mage::getStoreConfig($path);
    }
}
