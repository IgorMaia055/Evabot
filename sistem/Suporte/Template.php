<?php

namespace sistem\Suporte;

use Twig\Lexer;
use sistem\Nucleo\Helpers;
use Symfony\Component\HttpFoundation\Session\Session;

class Template
{
    private \Twig\Environment $twig;

    public function __construct(string $diretorio)
    {
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);
        
        $lexer = new Lexer($this->twig, array(
            $this->Helpers()
        ));

        $this->twig->setLexer($lexer);
    }

    public function renderizar(string $view, array $dados)
    {
        return $this->twig->render($view, $dados);
    }

    public function Helpers(): void 
    {
        array(
            $this->twig->addFunction(
                new \Twig\TwigFunction('url', function(string $url = null){
                    return Helpers::url($url);
                })
            ),
            $this->twig->addFunction(
                new \Twig\TwigFunction('dataFormat', function(){
                    return Helpers::dataFormat();
                })
            ),
            $this->twig->addFunction(
                new \Twig\TwigFunction('contarTempo', function(string $data){
                    return Helpers::contarTempo($data);
                })
            ),
            $this->twig->addFunction(
                new \Twig\TwigFunction('orcamento', function(string $id){
                    return Helpers::orcamento($id);
                })
            )
        );
    }
    
}