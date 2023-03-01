<?php
abstract class Action
{
    abstract function prepare(Database $db, $data = null);
    abstract function run();
    abstract function return_row();
}

?>