<?php

namespace Meetmagento\Shipping\Model\Carrier;

// Per Magento_OfflineShipping
use Magento\Quote\Model\Quote\Address\RateRequest;


//Per Magento_Catalog
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Quote\Model\Quote\Item;

/**
 * Class Shipping
 * @package Meetmagento\Shipping\Model\Carrier
 */

class Shipping extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    protected $_code = 'shippingmeetmagento';
    protected $_isFixed = true;
    protected $_rateResultFactory;
    protected $_rateMethodFactory;

    /**
     * Shipping constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        array $data = []
    )
    {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * @param RateRequest $request
     * @return bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $total = 0;

        if ($request->getAllItems()) {
            foreach ($request->getAllItems() as $item) {
                $total += $item->getPrice();
            }
        }

        if($this->getConfigData('free_shipping_amount') < $total){
            $shippingPrice = $this->getConfigData(0);
        } else {
            $shippingPrice = $this->getConfigData('price');
        }

        $result = $this->_rateResultFactory->create();

        $method = $this->_rateMethodFactory->create();

        $method->setCarrier('shippingmeetmagento');
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod('shippingmeetmagento');
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result->append($method);

        return $result;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['shippingmeetmagento' => $this->getConfigData('name')];
    }

    /**
     * @param ProductInterface $product
     * @return bool
     */
    public function isAvailableForProduct(ProductInterface $product)
    {
        $attributeSets = array_map("intval", explode(",", $this->getConfigData('attribute_set')));
        return in_array($product->getAttributeSetId(), $attributeSets) && $this->getConfigFlag('active');
    }
}
