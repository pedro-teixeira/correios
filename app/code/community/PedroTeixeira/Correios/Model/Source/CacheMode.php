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
class PedroTeixeira_Correios_Model_Source_CacheMode extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const MODE_HTTP_PRIOR = 0;
    const MODE_CACHE_PRIOR = 1;
    const MODE_CACHE_ONLY = 2;

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::MODE_HTTP_PRIOR, 'label' => 'Consultar os Correios; e, se falhar, o Cache'),
            array('value' => self::MODE_CACHE_PRIOR, 'label' => 'Consultar o Cache; e, se falhar, os Correios'),
            array('value' => self::MODE_CACHE_ONLY, 'label' => 'Consultar somente o Cache'),
        );
    }

    /**
     * Get options for input fields
     *
     * @see Mage_Eav_Model_Entity_Attribute_Source_Interface::getAllOptions()
     *
     * @return array
     */
    public function getAllOptions()
    {
        return self::toOptionArray();
    }
}
