<?php
/**
 * @category   Bitbull
 * @package    Bitbull_Bestlist
 * @author     Gennaro Vietri <gennaro.vietri@bitbull.it>
 */
class Bitbull_Bestlist_Block_Tracking extends Mage_Core_Block_Template
{
    /**
     * Render information about specified orders and their items
     *
     * @return string
     */
    protected function _getOrdersTrackingCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return '';
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds))
        ;
        $result = array();
        foreach ($collection as $order) {
            $result[] = sprintf("beslistQueue.push(['setShopId', '%s']);", Mage::getStoreConfig(Bitbull_Bestlist_Helper_Data::XML_PATH_ACCOUNT));
            $result[] = sprintf("beslistQueue.push(['cps', 'setTestmode', false]);");
            $result[] = sprintf("beslistQueue.push(['cps', 'setTransactionId', '%s']);", $order->getIncrementId());
            $result[] = sprintf("beslistQueue.push(['cps', 'setOrdersum', %s]);", $order->getBaseGrandTotal());
            $result[] = sprintf("beslistQueue.push(['cps', 'setOrderCosts', %s]);", $order->getBaseShippingAmount());

            $items = array();
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = sprintf("['%s', %s, %s]", $this->jsQuoteEscape($item->getSku()), $item->getQtyOrdered(), $item->getBasePrice());
            }
            $result[] = "beslistQueue.push(['cps', 'setOrderProducts',[" . implode(',', $items) . "]]);";

            $result[] = "beslistQueue.push(['cps', 'trackSale']);";
        }
        return implode("\n", $result);
    }

    /**
     * Render Bestlist tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::helper('bitbull_bestlist')->isBestlistTrackingAvailable()) {
            return '';
        }
        return parent::_toHtml();
    }
}
