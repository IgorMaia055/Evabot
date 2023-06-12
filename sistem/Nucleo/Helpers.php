<?php

namespace sistem\Nucleo;

use Exception;
// use Illuminate\Http\Request;

class Helpers
{

    public static function redirecionar(string $url = null): void 
    {
        header('HTTP/1.1 302 Found');

        $local = ($url ? self::url($url) : self::url());

        header("Location: {$local}");
        exit();
    }

    /**
     * Método para validar um cpf
     * @param string $cpf cpf a ser validado
     * @return bool Verdadeiro ou Falso
     */
     
    public static function validaCpf (string $cpf): bool
    {
        $cpfLimp = preg_replace("/[^0-9]/", '', $cpf);
        if(mb_strlen($cpfLimp) != 11 or preg_match('/(\d)\1{10}/', $cpfLimp))
        {
            throw new Exception("O Cpf precisa ter 11 digitos");
        }
        for($t = 9; $t < 11; $t++)
        {
            for($d = 0, $c = 0; $c < $t; $c++)
            {
                $d += $cpfLimp[$c] * (($t + 1) - $c);
            }
            $d = (($d * 10) % 11) % 10;
            if($cpfLimp[$c] != $d)
            {
                throw new Exception("Cpf Invalido!");
            }
        }
    
        return true;
    }
    
    public static function formataMoeda (float $valor = null, string $moeda = 'R$'): string
    {
        $valueFormat = $moeda .' '. number_format($valor, 2, ',', '.');
        return $valueFormat;
    }
    
    //Boas vindas 
    public static function msgBoaVinda ():string 
    {
        $hora = date('H');
    
        $saldação = match (true) 
        {
          $hora <= 12 AND $hora >= 5 => 'Bom dia!',
          $hora <= 20 AND $hora >= 13 => 'Boa tarde!',
          default => 'Boa noite!'
        };
        return $saldação;
    }
    
    public static function formataValor (string $value = null): float
    {
        return number_format(($value ? $value : 0), 0, '.', '.');
    }
    public static function formataNumber (string $value = null): int
    {
        $replaceVar = str_replace(".", "", $value);
        $replaceVar2 = str_replace(",", ".", $replaceVar);

        return intval($replaceVar2);
    }
    
    /**
     * Método para resumir uma string
     * @param string $texto texto para resumir
     * @param int $limit limite para fatorar o texto
     * @param string $continue opcional continuação adicionada no texto para inicar continuamento
     * @return string texto resumido
     */
    
     public static function resumirTxt(string $texto, int $limit, string $continue = '...'): string
     {
         $textoLimp = self::filterStr(trim(strip_tags($texto)));
         if(mb_strlen($texto) <= $limit)
         {
             return $textoLimp;
         }
     
         $textoSub = mb_substr($textoLimp, 0, $limit);
         return $textoSub . $continue;
     }
    
    
    /**
     * Método contador de tempo
     * @param string $data A data da publicação vindo do banco de dados
     * @return string Diferença de tempo
     */
    
    public static function contarTempo (string $data): string
    {
        $dateNew = strtotime(date('Y-m-d H:i:s'));
        $time = strtotime($data);
        $diferenca = $dateNew - $time;
    
        $segundos = round($diferenca);
        $minutos = round($diferenca / 60);
        $horas = round($diferenca / 3600);
        $dias = round($diferenca / 86400);
        $semanas = round($diferenca / 604800);
        $meses = round($diferenca / 2419200);
        $anos = round($diferenca / 29030400);
    
    
        $dateFormatNew = match (true)
        {
            $segundos <= 60=> 'Agora',
            $minutos <= 60 => $minutos == 1 ? 'Há 1 m' : 'Há '.$minutos.' m',
            $horas <= 24 => $horas == 1 ? 'Há 1 h' : 'Há '.$horas.' h',
            $dias <= 7 => $dias == 1 ? 'Há 1 d' : 'Há '.$dias.' d',
            $semanas <= 4 => $semanas == 1 ? 'Há 1 s' : 'Há '.$semanas.' s',
            $meses <= 12 => $meses == 1 ? 'Há 1 mês' : 'Há '.$meses.' mêses',
            default => $anos == 1 ? 'Há 1 ano' : 'Há '.$anos.' anos'
        };
    
        return $dateFormatNew;
    
    }
    
    
    public static function validaEmail (string $email): bool
    {
        return filter_var ($email, FILTER_VALIDATE_EMAIL);
    }
    
    public static function validaUrl (string $url): bool
    {
        return filter_var ($url, FILTER_VALIDATE_URL);
    }
    
    /**
     * Método para autentificar o servidor a ser usado e assim poder redirecionar para a url correta
     * @param string $url Rota para navegação
     * @return string URL correta
     */
    public static function localhost (): bool
    {
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME');
        if($server === 'localhost')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function url(string $url = null) :string
    {
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($server === 'localhost' ? URL_DESENVOLVIMENTO : URL_ONLINE);
    
        if(str_starts_with($url, '/'))
        {
            return $ambiente.$url;
        }
    
        return $ambiente.'/'.$url;
    }
    
    public static function dataFormat (): string
    {
        $diaMes = date('d');
        $diaSemana = date('w');
        $mes = date('n') - 1;
        $ano = date('Y');
    
        $diaSemanaArr = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
    
        $mesesArr = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'
        ];
    
        $dataFormat = $diaSemanaArr[$diaSemana].', '. $diaMes.' de '.$mesesArr[$mes].' de '.$ano;
        return $dataFormat;
    }
    public function dateNew(): string 
    {
        return date('Y-m-d');
    } 
    
    public static function urlSlug (string $txt): string
    {
        $nova_string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$txt);
    
        $caractsStr = str_replace(['?', '/','[ˆ0-99]h', ':', ';', '+', '=', '-', '_', '|'], '', $nova_string); 
        
        $slug = strip_tags(trim($caractsStr));
        $sludReplace = str_replace(' ', '+', $slug);
        $sludReplace2 = str_replace(array('+++++', '++++', '++', '+'), '+', $sludReplace);
    
        return strtolower(utf8_decode($sludReplace2));
    }

    public static function filterStr (string $txt): string
    {
        return filter_var($txt, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public static function orcamento(string $id): array
    {
        $idInt = intval($id);
        $query = "SELECT * FROM orcamentos WHERE id = '". $idInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public static function get_client_ip() 
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    }

?>    