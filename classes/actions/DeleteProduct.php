<?php
require_once("./classes/actions/Action.php");
class DeleteProduct extends Action
{
    private PDOStatement $command;
    private $row;
    private $id_exists = false;
    private $id;
    function prepare(Database $db, $data = null)
    {
        $this->command = $db->prepare('select * from products where products.id = :id');
        $this->command->execute([":id" => $data]);
        if ($this->command->rowCount() == 0) {
            $this->id_exists = false;
        } else {
            $this->id_exists = true;
            $this->row = $this->command->fetch(PDO::FETCH_NAMED);
            $this->id = $this->row["id"];
            $this->command = $db->prepare('delete from products where id =:id;');
        }
    }
    function run()
    {
        if (!$this->id_exists) {
            return;
        }
        $this->command->execute([":id" => $this->id]);
    }
    function return_row()
    {

    }
}


?>