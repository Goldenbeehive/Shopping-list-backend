<?php
require_once("./classes/products/Product.php");
class DVD extends Product
{

    private float $size;
    function __construct(string $sku, string $n, float $p, float $s)
    {
        parent::__construct($sku, $n, $p);
        $this->size = $s;
    }

    function type()
    {
        return "dvd";
    }
    function list_for_database()
    {
        return $this->size;
    }
}
?>