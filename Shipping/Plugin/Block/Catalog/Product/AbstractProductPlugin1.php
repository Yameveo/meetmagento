<?php

namespace Meetmagento\Shipping\Plugin\Block\Catalog\Product;
/**
 * Class AbstractProductPlugin1
 * @package Meetmagento\Shipping\Plugin\Block\Catalog\Product
 *
 */

class AbstractProductPlugin1
{
    /**
     * @param $subject
     * @param $product
     */

    public function beforeGetProductPrice(
        $subject,
        $product
    )
    {
        //var_dump(get_class($subject));
        var_dump('Plugin1 - beforeGetProductPrice');
    }

    /**
     * @param $subject
     */

    public function afterGetProductPrice($subject)
    {
        var_dump('Plugin1 - afterGetProductPrice');
    }

    /**
     * @param $subject
     * @param \Closure $proceed
     * @param $product
     * @return mixed
     */
    public function aroundGetProductPrice(
        $subject,
        \Closure $proceed,
        $product
    )
    {
        var_dump('Plugin1 - aroundGetProductPrice');
        return $proceed($product);
    }

}