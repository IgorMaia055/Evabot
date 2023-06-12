<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectUser
{
    public function select(string $usuario, string $senha): array
    {
        $query = "SELECT idunic FROM users WHERE nome = '". $usuario ."' AND senha = '". $senha ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectKey(string $key): array 
    {
        $query = "SELECT * FROM users WHERE idunic = '". $key ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}