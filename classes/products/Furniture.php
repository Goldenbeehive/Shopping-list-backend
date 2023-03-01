<?php
require_once("./classes/products/Product.php");
class Furniture extends Product
{

    private int $length;
    private int $width;
    private int $height;
    function __construct(string $sku, string $n, float $p, int $l, int $w, int $h)
    {
        parent::__construct($sku, $n, $p);
        $this->length = $l;
        $this->width = $w;
        $this->height = $h;
    }

    function type()
    {
        return "furniture";

    }
    function get_length(){
        return $this->length;
    }
    function get_width(){
        return $this->width;
    }
    function get_height(){
        return $this->height;
    }
    function list_for_database()
    {
        return "$this->length , $this->width, $this->height";
    }
}
?>