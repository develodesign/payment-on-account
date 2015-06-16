<?php
/**
 * Model for handling the payment method.
 *
 * @category Develo
 * @package Develo_PaymentOnAccount
 * @author Doug Bromley <doug@develodesign.co.uk>
 * @copyright Develo Design Ltd.
 * @license https://github.com/develodesign/payment-on-account/blob/master/LICENSE MIT
 */

class Develo_PaymentOnAccount_Model_PaymentOnAccount extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'paymentonaccount';
    protected $_canUseInternal = true;

    /**
     * Overrides parent method to check customer groups to determine if
     * available for use by the customer checking out.
     *
     * @param object|null $quote
     *
     * @return boolean
     */
    public function isAvailable($quote = null)
    {
        if (parent::isAvailable($quote)) {
            if ($this->_checkCustomerGroup($quote)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks the customer groups config
     *
     * @param object|null $quote
     *
     * @return bool
     */
    private function _checkCustomerGroup($quote = null)
    {
        if (!$quote) {
            return false;
        }

        $allowedGroups = Mage::getStoreConfig('payment/paymentonaccount/customer_groups');
        if (in_array($quote->getCustomerGroupId(), explode(',', $allowedGroups))) {
            return true;
        }

        return false;
    }
}