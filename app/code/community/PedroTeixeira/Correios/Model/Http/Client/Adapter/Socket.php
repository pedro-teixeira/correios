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
class PedroTeixeira_Correios_Model_Http_Client_Adapter_Socket
    extends Zend_Http_Client_Adapter_Socket
{
    protected $_cache = null;
    protected $_params = null;
    protected $_code = 'pedroteixeira_correios';

    const CACHE_TYPE = 'pedroteixeira_correios';

    /**
     * Connect to the remote server
     *
     * @param string $host   Host name
     * @param int    $port   Port number
     * @param bool   $secure Secure flag
     *
     * @return void
     */
    public function connect($host, $port = 80, $secure = false)
    {
        if (Mage::app()->useCache(self::CACHE_TYPE)) {
            $mode = $this->getConfigData('cache_mode');
            if (!($mode == PedroTeixeira_Correios_Model_Source_CacheMode::MODE_CACHE_ONLY)) {
                try {
                    parent::connect($host, $port, $secure);
                } catch (Zend_Http_Client_Adapter_Exception $e) {
                    Mage::log("{$this->_code} [socket]: {$e->getMessage()}");
                }
            }
        } else {
            parent::connect($host, $port, $secure);
        }
    }

    /**
     * Send request to the remote server
     *
     * @param string        $method   Method
     * @param Zend_Uri_Http $uri      Uri
     * @param string        $http_ver HTTP version
     * @param array         $headers  Headers
     * @param string        $body     Body
     *
     * @return string Request as string
     */
    public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
    {
        $request = false;
        if (Mage::app()->useCache(self::CACHE_TYPE)) {
            $this->_params = $uri->getQueryAsArray();
            try {
                $request = parent::write($method, $uri, $http_ver, $headers, $body);
            } catch (Zend_Http_Client_Adapter_Exception $e) {
                Mage::log("{$this->_code} [socket]: {$e->getMessage()}");
            }
        } else {
            $request = parent::write($method, $uri, $http_ver, $headers, $body);
        }
        return $request;
    }

    /**
     * Read response from server
     *
     * @see Zend_Http_Client_Adapter_Socket::read()
     *
     * @return string
     */
    public function read()
    {
        $response = false;
        if (Mage::app()->useCache(self::CACHE_TYPE)) {
            $cache = $this->getCache();
            $cache->addData($this->_params);
            $cacheMode = $this->getConfigData('cache_mode');
            if ($cacheMode == PedroTeixeira_Correios_Model_Source_CacheMode::MODE_HTTP_PRIOR) {
                try {
                    $response = parent::read();
                    $cache->save($response);
                } catch (Zend_Http_Client_Adapter_Exception $e) {
                    $response = $cache->load();
                }
            } elseif ($cacheMode == PedroTeixeira_Correios_Model_Source_CacheMode::MODE_CACHE_PRIOR) {
                $response = $cache->loadById();
                if (!$response) {
                    try {
                        $response = parent::read();
                        $cache->save($response);
                    } catch (Zend_Http_Client_Adapter_Exception $e) {
                        $response = $cache->loadByTags();
                    }
                }
            } elseif ($cacheMode == PedroTeixeira_Correios_Model_Source_CacheMode::MODE_CACHE_ONLY) {
                $response = $cache->load();
            }
        } else {
            $response = parent::read();
        }
        return $response;
    }

    /**
     * Retrieves the cache instance
     *
     * @return PedroTeixeira_Correios_Model_Cache
     */
    public function getCache()
    {
        if ($this->_cache == null) {
            $this->_cache = Mage::getModel('pedroteixeira_correios/cache');
        }
        return $this->_cache;
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
