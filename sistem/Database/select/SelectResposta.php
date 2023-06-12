<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectResposta
{
    public function select(string $pergunta): array
    {
        $query = "SELECT resposta FROM per_res WHERE pergunta LIKE '%{$pergunta}%'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}