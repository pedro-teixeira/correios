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
        return Mage::getStoreConfig("carriers/correios/{$path}");
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
    
    /**
     * Checks whether delivery is delayed or not
     *
     * @param string $date
     *
     * @return boolean
     */
    public function isDeliveryDelayed($date = null)
    {
        $return = false;
        
        if (!empty($date)) {
            try {
                $limitDt = new Zend_Date($date, 'dd/MM/yyyy');
                $today = Mage::app()->getLocale()->date();
                $return = ($today->compare($limitDt) > 0);
                Mage::log(self::__("test if is delayed ({$today->toString('dd/MM/yyyy')} > {$limitDt->toString('dd/MM/yyyy')}): %s", print_r($return, true)));
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
        
        return $return;
    }
    
    public function validateCalcPrazoData(Correios_CalcPrecoPrazo_CalcPrazoData $params)
    {
        $return = true;
        
        if (empty($params->nCdServico) || !is_numeric($params->nCdServico)) {
            $return = false;
            Mage::logException(new Exception('invalid service: ' . print_r($params, true)));
        }
        
        if (empty($params->sCepDestino) || !is_numeric($params->sCepDestino)) {
            $return = false;
            Mage::logException(new Exception('invalid zip dest: ' . print_r($params, true)));
        }
        
        if (empty($params->sCepOrigem) || !is_numeric($params->sCepOrigem)) {
            $return = false;
            Mage::logException(new Exception('invalid zip source: ' . print_r($params, true)));
        }
        
        if (empty($params->sDtCalculo)) {
            $return = false;
            Mage::logException(new Exception('invalid date: ' . print_r($params, true)));
        }
        
        return $return;
    }
    
    /**
     * Removes the Correios verification digit
     *
     * @param string $label
     * @return string
     */
    public function getLabelWithNoDigit($label)
    {
        $output = substr($label, 0, -3) . substr($label, -2);
        return $output;
    }
    
    /**
     * Removes the Correios verification digit
     *
     * @param string[] $labels
     * @return string[]
     */
    public function getLabelsWithNoDigit($labels)
    {
        $output = array();
        foreach ($labels as $label) {
            $output[] = self::getLabelWithNoDigit($label);
        }
        return $output;
    }
    
    /**
     * Returns the cheksum for Correios postcode
     *
     * @param string $number
     * @return number
     */
    public function getLabelCheckSum($number)
    {
        $dv = 0;
        $sum = 0;
        $multipliers = array(8, 6, 4, 2, 3, 5, 9, 7);
        
        for ($i=0; $i<8; $i++) {
            $sum += (int)$number{$i} * $multipliers[$i];
        }
        
        $mod = $sum % 11;
        if ($mod == 0) {
            $dv = 5;
        } elseif ($mod != 1) {
            $dv = 11 - $mod;
        }
        
        return $dv;
    }
    
    /**
     * Retrieves the postcode with Correios checksum
     *
     * @param string $label
     * @return string
     */
    public function getLabelWithCheckSum($label)
    {
        $label = self::formatLabel($label);
        $number = substr($label, 2, 8);
        $begin = substr($label, 0, 2);
        $end = substr($label, -2);
        $dv = self::getLabelCheckSum($number);
        return $begin.$number.$dv.$end;
    }
    
    /**
     *
     * @param string $label
     * @return boolean
     */
    public function validateRequestLabelResponse($label)
    {
        return (preg_match('/^[a-zA-Z]{2}[0-9]{8}[a-zA-Z]{2}$/', $label) == 1);
    }
    
    /**
     * @param string $label
     * @return string
     */
    public function formatLabel($label)
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $label);
    }
    
    /**
     * @param string $value
     * @return mixed
     */
    public function formatDigitsOnly($value)
    {
        return preg_replace('/\D/', '', (string)$value);
    }
    
    public function getNfeByOrder(Mage_Sales_Model_Order $order)
    {
        $nfeKey = '00000000000000000000000000000000000000000000';
        foreach ($order->getAllStatusHistory() as $status) {
            if (preg_match('/([\d]{44})/', $status->getData('comment'), $match)) {
                $nfeKey = array_pop($match);
                break;
            }
        }
        $nfeSerie = (int)substr($nfeKey, 22, 3);
        $nfeNumber = (int)substr($nfeKey, 25, 9);
        
        return array($nfeKey, $nfeSerie, $nfeNumber);
    }
    
    /**
     * Retrieve the delivery time in days
     *
     * @param string $method   Serviço de entrega
     * @param string $postcode CEP de entrega
     *
     * @return int|boolean
     */
    public function getDeliveryTime($method, $postcode)
    {
        $deliveries = self::getConfigData('sigepweb/delivery');
        foreach ((array)$deliveries as $config) {
            if ((string)$config['code'] == $method) {
                foreach ((array)$config['zip'] as $zip) {
                    if ((int)$zip['from'] <= $postcode && (int)$zip['to'] >= $postcode) {
                        $max = $zip['max'];
                        return $max;
                    }
                }
            }
        }
        
        return false;
    }
}
