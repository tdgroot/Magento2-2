<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * It is available through the world-wide-web at this URL:
 * https://tldrlegal.com/license/mit-license
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to support@buckaroo.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact support@buckaroo.nl for more information.
 *
 * @copyright Copyright (c) Buckaroo B.V.
 * @license   https://tldrlegal.com/license/mit-license
 */

namespace Buckaroo\Magento2\Model\ConfigProvider\Method;

use Magento\Store\Model\ScopeInterface;

/**
 * @method getDueDate()
 * @method getSendEmail()
 */
class Eps extends AbstractConfigProvider
{
    const XPATH_EPS_ACTIVE                 = 'payment/buckaroo_magento2_eps/active';
    const XPATH_EPS_PAYMENT_FEE            = 'payment/buckaroo_magento2_eps/payment_fee';
    const XPATH_EPS_PAYMENT_FEE_LABEL      = 'payment/buckaroo_magento2_eps/payment_fee_label';
    const XPATH_EPS_SEND_EMAIL             = 'payment/buckaroo_magento2_eps/send_email';
    const XPATH_EPS_ACTIVE_STATUS          = 'payment/buckaroo_magento2_eps/active_status';
    const XPATH_EPS_ORDER_STATUS_SUCCESS   = 'payment/buckaroo_magento2_eps/order_status_success';
    const XPATH_EPS_ORDER_STATUS_FAILED    = 'payment/buckaroo_magento2_eps/order_status_failed';
    const XPATH_EPS_AVAILABLE_IN_BACKEND   = 'payment/buckaroo_magento2_eps/available_in_backend';
    const XPATH_EPS_DUE_DATE               = 'payment/buckaroo_magento2_eps/due_date';

    const XPATH_ALLOWED_CURRENCIES = 'payment/buckaroo_magento2_eps/allowed_currencies';

    const XPATH_ALLOW_SPECIFIC                  = 'payment/buckaroo_magento2_eps/allowspecific';
    const XPATH_SPECIFIC_COUNTRY                = 'payment/buckaroo_magento2_eps/specificcountry';

    /**
     * @return array
     */
    public function getConfig()
    {
        if (!$this->scopeConfig->getValue(
            static::XPATH_EPS_ACTIVE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            return [];
        }

        $paymentFeeLabel = $this->getBuckarooPaymentFeeLabel(\Buckaroo\Magento2\Model\Method\Eps::PAYMENT_METHOD_CODE);

        return [
            'payment' => [
                'buckaroo' => [
                    'eps' => [
                        'sendEmail' => (bool) $this->getSendEmail(),
                        'paymentFeeLabel' => $paymentFeeLabel,
                        'allowedCurrencies' => $this->getAllowedCurrencies(),
                    ]
                ]
            ]
        ];
    }

    /**
     * @param null|int $storeId
     *
     * @return float
     */
    public function getPaymentFee($storeId = null)
    {
        $paymentFee = $this->scopeConfig->getValue(
            static::XPATH_EPS_PAYMENT_FEE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $paymentFee ? $paymentFee : false;
    }


    /**
     * {@inheritdoc}
     */
    public function getActive($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_ACTIVE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentFeeLabel($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_PAYMENT_FEE_LABEL,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSendEmail($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_SEND_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveStatus($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_ACTIVE_STATUS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderStatusSuccess($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_ORDER_STATUS_SUCCESS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderStatusFailed($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_ORDER_STATUS_FAILED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableInBackend($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_AVAILABLE_IN_BACKEND,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDueDate($store = null)
    {
        return $this->scopeConfig->getValue(
            static::XPATH_EPS_DUE_DATE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
