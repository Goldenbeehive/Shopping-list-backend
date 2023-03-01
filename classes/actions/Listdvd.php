<?php
require_once("./classes/actions/Action.php");
class ListDvd extends Action
{
    private $command;

    function prepare(Database $db, $data = null)
    {
        $this->command = $db->prepare('select * from products inner join dvd on products.type ="dvd" and products.id = dvd.id ;');
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