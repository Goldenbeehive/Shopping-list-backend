<?php
require_once("./classes/products/Product.php");
class Book extends Product
{

    private float $weight;
    function __construct(string $sku, string $n, float $p, float $w)
    {
        parent::__construct($sku, $n, $p);
        $this->weight = $w;
    }

    function type()
    {
        return "books";
    }
    function list_for_database()
    {
        return $this->weight;
    }
}
?>