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
class PedroTeixeira_Correios_Block_Adminhtml_System_Config_Form_Button
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Retrieve the html code for Element
     *
     * @param Varien_Data_Form_Element_Abstract $element Element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->getButton()->toHtml();
    }
    
    /**
     * Retrieve an adminhtml button
     *
     * @return string
     */
    public function getButton()
    {
        $location = Mage::helper('adminhtml')->getUrl('*/sigepweb/postmethodsUpdate');
        $updateButton = $this->getLayout()->createBlock('adminhtml/widget_button');
        $updateButton->setData(
            array(
                'id'      => 'btn-update-postmethods',
                'label'   => $this->helper('adminhtml')->__('Update'),
                'onclick' => "setLocation('{$location}')",
            )
        );
        return $updateButton;
    }
}
