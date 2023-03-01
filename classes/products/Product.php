<?php
abstract class Product
{
    private string $SKU;
    private string $name;
    private float $price;
    function __construct($sku, $n, $p)
    {
        $this->SKU = $sku;
        $this->name = $n;
        $this->price = $p;
    }
    function get_sku()
    {
        return $this->SKU;
    }
    function get_name()
    {
        return $this->name;
    }
    function get_price()
    {
        return $this->price;
    }
    abstract function list_for_database();
    abstract function type();
}
?>