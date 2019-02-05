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
class PedroTeixeira_Correios_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Gets the configuration value by path
     *
     * @param string $path System Config Path
     *
     * @return mixed
     */
    public function getConfigData($path)
    {
        $moduleName = strtolower($this->_getModuleName());
        return Mage::getStoreConfig("carriers/{$moduleName}/{$path}");
    }
    
    /**
     * Get a text for option value
     *
     * @param string|int $value Method Code
     *
     * @return string|bool
     */
    public function getShippingLabel($value)
    {
        $source = Mage::getSingleton('pedroteixeira_correios/source_postMethods');
        return $source->getOptionText($value);
    }
    
    /**
     * Retrieve stream context as a Soap parameter
     *
     * @return array
     */
    public function getStreamContext()
    {
        return array(
            'stream_context' => stream_context_create(
                array(
                    'http' => array(
                        'protocol_version'=>'1.1',
                        'header' => 'Connection: Close'
                    )
                )
            )
        );
    }
}
