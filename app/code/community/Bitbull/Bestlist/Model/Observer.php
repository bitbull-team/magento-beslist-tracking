<?php
/**
 * @category   Bitbull
 * @package    Bitbull_Bestlist
 * @author     Gennaro Vietri <gennaro.vietri@bitbull.it>
 */
class Bitbull_Bestlist_Model_Observer
{
    /**
     * Add order information into tracking block to render on checkout success pages
     *
     * @param Varien_Event_Observer $observer
     */
    public function setBestlistOnOrderSuccessPageView(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('bitbull_bestlist');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }
}
