<?php
/**
 * @category   Bitbull
 * @package    Bitbull_Bestlist
 * @author     Gennaro Vietri <gennaro.vietri@bitbull.it>
 */
class Bitbull_Bestlist_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACTIVE        = 'bitbull/bestlist/active';
    const XML_PATH_ACCOUNT       = 'bitbull/bestlist/account';

    /**
     * Whether Bestlist tracking is ready to use
     *
     * @param mixed $store
     * @return bool
     */
    public function isBestlistTrackingAvailable($store = null)
    {
        $accountId = Mage::getStoreConfig(self::XML_PATH_ACCOUNT, $store);
        return $accountId && Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, $store);
    }
}
