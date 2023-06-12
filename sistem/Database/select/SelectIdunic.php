<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectIdunic
{
    public function select(string $idunic): array
    {
        $query = "SELECT * FROM users WHERE idunic = '". $idunic ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}