<?php
require_once("./classes/actions/Action.php");
class ListFurniture extends Action
{
    private $command;

    function prepare(Database $db, $data = null)
    {
        $this->command = $db->prepare('select * from products inner join furniture on products.type ="furniture" and products.id = furniture.id ;');
    }
    function run()
    {
        $this->command->execute([]);

    }
    function return_row()
    {
        return $this->command->fetch(PDO::FETCH_NAMED);
    }
}
?>