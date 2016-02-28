<?php

namespace Meetmagento\Shipping\Plugin\Block\Catalog\Product;

class AbstractProductPlugin2
{
    /**
     * @param $subject
     * @param $product
     * @param array $additional
     */
    public function beforeGetAddToCartUrl(
        $subject,
        $product, $additional = []
    )
    {
        var_dump('Plugin1 - beforeGetAddToCartUrl');
    }

    /**
     * @param $subject
     */
    public function afterGetAddToCartUrl($subject)
    {
        var_dump('Plugin1 - afterGetAddToCartUrl');
    }

    /**
     * @param $subject
     * @param \Closure $proceed
     * @param $product
     * @param array $additional
     * @return mixed
     */
    public function aroundGetAddToCartUrl(
        $subject,
        \Closure $proceed,
        $product,
        $additional = []
    )
    {
        var_dump('Plugin1 - aroundGetAddToCartUrl');
        return $proceed($product, $additional);
    }

}