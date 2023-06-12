<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateStates
{
    public function update(string $id, string $id_funcionario)
    {
        $idInt = intval($id);
        $id_funcionarioInt = intval($id_funcionario);

        $query = "UPDATE service_funcionario SET states = '". 1 ."', dateF = '". date('Y-m-d H:i:s') ."' WHERE id = '". $idInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}