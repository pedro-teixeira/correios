<?php
class PedroTeixeira_Correios_Model_Observer {

	public function getConfigFlag($field) {
		return Mage::getStoreConfigFlag("carriers/pedroteixeira_correios/{$field}");
	}
	
	/**
	 * This keeps only postmethods available for all items in cart.
	 * In other words you can set post methods by products.
	 * Methods not available for all items in cart are removed.
	 * Require attribute creation called postmethods.
	 * Example:
	 * 	code: 		postmethods
	 *  type: 		multiselect
	 *  label:		[free]
	 *  value 1:	41068
	 *  value 2:	40096
	 *  ...
	 *  value 99:	81019
	 *
	 * @return PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
	 */
	public function filterByItem(Varien_Event_Observer $observer) {
		/* @var $carrier PedroTeixeira_Correios_Model_Carrier_CorreiosMethod */
		$carrier = $observer->getEvent()->getData('carrier');
		if ( $this->getConfigFlag('filter_by_item') ) {
			$items = Mage::getSingleton('checkout/cart')->getQuote()->getAllVisibleItems();
			if (count($items) == 0) {
				$items = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getAllVisibleItems();
			}
			/* @var $item Mage_Eav_Model_Entity_Abstract */
			foreach($items as $item){
				/* @var $_product Mage_Catalog_Model_Product */
				$product = Mage::getModel('catalog/product')->load($item->getProductId());
				$postMethodsList = explode(',', $carrier->getPostMethods());
				$prodPostMethods = (array)$product->getAttributeText('postmethods');
				$intersection    = array_intersect($prodPostMethods, $postMethodsList);
				$carrier->setPostMethods( implode(',', $intersection) );
			}
			$carrier->setPostMethodsFixed( $carrier->getPostMethods() );
			$carrier->setPostMethodsExplode( trim($carrier->getPostMethods()) ? explode(",", $carrier->getPostMethods()) : array() );
		}
		$observer->getEvent()->setData('carrier', $carrier);
	}

}