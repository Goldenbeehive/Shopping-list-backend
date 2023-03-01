<?php
require_once("./classes/actions/Action.php");
class ListBooks extends Action
{
    private $command;

    function prepare(Database $db, $data = null)
    {
        $this->command = $db->prepare('select * from products inner join books on products.type ="books" and products.id = books.id ;');
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