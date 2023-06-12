<?php
namespace sistem\Nucleo;

use GuzzleHttp\Client;

class ConnectionGpt
{
    public function enviarSolicitacaoChatGPT($mensagem) {
        $client = new Client([
            'base_uri' => 'https://api.openai.com/v1/', // URL base da API
            'headers' => [
                'Authorization' => 'Bearer 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',
                'Content-Type' => 'application/json',
            ],
        ]);
    
        $response = $client->post('chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Você: ' . $mensagem],
                ],
            ],
        ]);
    
        return json_decode($response->getBody()->getContents(), true);
    }

}
?>