<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdatePontos
{
    public function update(string $id, string $id_funcionario, array $pontos)
    {
        $id_funcionarioInt = intval($id_funcionario);
        $idInt = intval($id);

        $point = $pontos[0]->pontos += 1;

        $query2 = "SELECT `data` FROM service_funcionario WHERE id_funcionario = '". $idInt ."'";
        $result2 = Connection::getInstancia()->query($query2)->fetchAll();

        $newDate = $pontos[0]->date += round(strtotime(date('Y-m-d H:i')) - strtotime($result2[0]->data));

        $query = "UPDATE pontos SET pontos = '". $point ."', `date` = '". $newDate ."' WHERE id_funcionario = '". $id_funcionarioInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}