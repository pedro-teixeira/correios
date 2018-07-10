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
class PedroTeixeira_Correios_Model_Sigepweb_Abstract extends Varien_Object {
    
    
    /**
     * {@inheritDoc}
     * @see Varien_Object::toXml()
     */
    public function toXml(array $arrAttributes = array(), $rootName = true, $addOpenTag=false, $addCdata=false)
    {
        $xml = '';
        if ($addOpenTag) {
            $xml.= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
        }
        if (!empty($rootName)) {
            $xml.= "<{$rootName}>";
        }
        $arrData = $this->toArray($arrAttributes);
        foreach ($arrData as $fieldName => $fieldValue) {
            if (is_null($fieldValue)) {
                $xml.= "<{$fieldName} />";
            } elseif (is_array($fieldValue)) {
                $xml.= implode("", $fieldValue)."";
            } else {
                if ($addCdata === true) {
                    $fieldValue = "<![CDATA[{$fieldValue}]]>";
                }
                $xml.= "<{$fieldName}>{$fieldValue}</{$fieldName}>";
            }
        }
        if (!empty($rootName)) {
            $xml.= "</{$rootName}>";
        }
        return $xml;
    }
    
}
