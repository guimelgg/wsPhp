<?php
class Service
{
    public function getUsers()
    {
        return [
          ["id" => 1, "name" => "Iparra"],
          ["id" => 2, "name" => "Juan"]
        ];
    }

    public function sum($a, $b)
    {
        return array_sum(func_get_args());
    }

    public function getName($name)
    {
        return "Hello " . $name;
    }
}

?>
