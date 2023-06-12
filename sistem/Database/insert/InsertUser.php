<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertUser
{
    public function insert($usuario, $email, $idade, $idunic, $senha): void
    {
        $query = "INSERT INTO users (nome, idade, email, senha, idunic) VALUES ('". $usuario ."', '". $idade ."', '". $email ."', '". $senha ."', '". $idunic ."')";
        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}