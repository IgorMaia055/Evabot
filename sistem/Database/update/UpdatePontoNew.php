<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdatePontoNew
{
    public function update(string $id_funcionario)
    {
        $id_funcionarioInt = intval($id_funcionario);

        $query = "UPDATE pontos SET pontos = '". 0 ."', `date` = '". 0 ."' WHERE id_funcionario = '". $id_funcionarioInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}