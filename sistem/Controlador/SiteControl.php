<?php

/**
 * Classe para a controlação da aplicação, com ela todas as rotas são conectadas, dados são encontrados e arquivos html são renderizados atravez do twig template. 
 * @author Igor Maia <igormaia055@gmail.com>
 * @copyright Copyright (c) 2023
 */

namespace sistem\Controlador;

// Classes bases
use sistem\Nucleo\Controlador;
use sistem\Nucleo\Helpers;
use sistem\Nucleo\ConnectionGpt;

// Insert DataBase
use sistem\Database\insert\InsertUser;

// Select DataBase
use sistem\Database\select\SelectIdunic;
use sistem\Database\select\SelectUser;
use sistem\Database\select\SelectResposta;

class SiteControl extends Controlador
{
    public function __construct()
    {
        parent::__construct('views/');
    }

    public function cadastro(string $aviso): void 
    {
      echo $this->template->renderizar('cadastro.html', [
        'aviso' => $aviso
      ]);
    }

    public function goCadastro(): void
    {
      $usuario = filter_input(INPUT_GET,'usuario', FILTER_DEFAULT);
      $email = filter_input(INPUT_GET,'email', FILTER_DEFAULT);
      $idade = filter_input(INPUT_GET,'idade', FILTER_DEFAULT);
      $senha = filter_input(INPUT_GET,'senha', FILTER_DEFAULT);
      $idunic = uniqid();

      // Valida o e-mail
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        (new InsertUser)->insert($usuario, $email, $idade, $idunic, $senha);
      
        Helpers::redirecionar('home/'. $idunic);
      } else {
          Helpers::redirecionar('cadastrar/email_invalid');
      }
    }

    public function validation(string $mensagem): void
    {
      echo $this->template->renderizar('validation.html', [
        'mensagem' => $mensagem
      ]);
    }

    public function goValid(): void
    {
      $usuario = filter_input(INPUT_POST,'usuario', FILTER_DEFAULT);
      $senha = filter_input(INPUT_POST,'senha', FILTER_DEFAULT);

      $valid = (new SelectUser)->select($usuario, $senha);
      if(count($valid) != 0){
        Helpers::redirecionar('home/'. $valid[0]->idunic);
      }else{
        Helpers::redirecionar('validation/invalid');
      }
    }

    public function index(string $key): void 
    {
      $buscKey = (new SelectIdunic)->select($key);
        if(count($buscKey) != 0){
          echo $this->template->renderizar('home.html', [
            'key' => $key,
          ]);
        }else{
          Helpers::redirecionar('validation/enter');
        }
    }

    public function chatGpt(): void 
    {
      $mensagem = $_POST['mensagem'];

      $respostaDB = (new SelectResposta)->select($mensagem);

      if(count($respostaDB) == 0){
        $resposta = (new ConnectionGpt)->enviarSolicitacaoChatGPT($mensagem);
        echo $resposta['choices'][0]['message']['content'];
      }else{
        echo $respostaDB[0]->resposta;
      }
    }
    
}


?>