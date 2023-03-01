<?php

require_once("./classes/actions/Action.php");
require_once("./classes/products/Product.php");
class AddProduct extends Action
{
    private PDOStatement $InsertIntoProduct;
    private Product $product;

    private int $id;
    private PDOStatement $GetId;
    private PDOStatement $InsertIntoType;
    function prepare(Database $db, $data = null)
    {
        $this->product = $data;
        $this->InsertIntoProduct = $db->prepare("insert into products(name, sku, price,type) values(:name,:sku,:price,:type);");
        switch ($this->product->type()) {
            case 'books':
                $this->InsertIntoType = $db->prepare("insert into books (id, weight) values(:id , :values);");
                break;
            case 'dvd':
                $this->InsertIntoType = $db->prepare("insert into dvd (id, size) values(:id , :values);");
                break;
            case 'furniture':
                $this->InsertIntoType = $db->prepare("insert into furniture (id, length, width, height) values(:id , :l,:w,:h);");
                break;
            default:
                break;
        }

        $this->GetId = $db->prepare("select LAST_INSERT_ID();");

    }
    function run()
    {
        $this->InsertIntoProduct->execute([":name" => $this->product->get_name(), ":sku" => $this->product->get_sku(), ":price" => $this->product->get_price(), ":type" => $this->product->type()]);
        $this->GetId->execute();
        $this->id = $this->GetId->fetch(PDO::FETCH_NUM)[0];

        $values = $this->product->list_for_database();

        if ($this->product->type() == "furniture") {
            $l = $this->product->get_length();
            $w = $this->product->get_width();
            $h = $this->product->get_height();
            $this->InsertIntoType->bindParam(":l", $l);
            $this->InsertIntoType->bindParam(":w", $w);
            $this->InsertIntoType->bindParam(":h", $h);
        } else {
            $this->InsertIntoType->bindParam(":values", $values);
        }

        $this->InsertIntoType->bindParam(":id", $this->id);
        $this->InsertIntoType->execute();

    }
    function return_row()
    {

    }
}

?>