<?php

namespace Meetmagento\Shipping\Plugin\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Meetmagento\Shipping\Model\Carrier\Shipping as Shipping;

class Product
{
    /**
     * @var Shipping
     */
    private $shippingModel;

    /**
     * Product constructor.
     * @param Shipping $shippingModel
     */
    public function __construct(Shipping $shippingModel)
    {
        $this->shippingModel = $shippingModel;
    }

    /**
     * @param $subject
     * @param ProductInterface $result
     * @return ProductInterface
     */
    public function afterInitProduct($subject, ProductInterface $result)
    {
        if ($this->shippingModel->isAvailableForProduct($result)) {
            $result->setPrice($result->getPrice() * 0.9);
        }

        return $result;
    }
}
