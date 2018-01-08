<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabResultadoSmsDet;
use Illuminate\Support\Facades\Log;


class ApiSendSMS extends Controller
{
    protected static $clienteId = 10010490; //identificador para la api de hablame
    protected static $clienteToken = 'MjodwcFa6hH9Mj66cLiyhDeXMbaiXB'; //token para la api hablame

    /**
     * Function que realiza el envio de un mensaje de 
     * texto con la api de hablame. 
     * @param  string $numbers numero de telefono destinatarios
     * @param  string $msg     mensaje de texto a enviar
     * @param  string $fecha   fecha del envio con formato 2017-12-31 23:59:59
     * @return json            resultado del envio
     */
    public static function sendSMS($msg, $numbers, $idEmpresa, $relCampPubli, $fecha = ''){

        if (!empty($numbers)) {

            $header = 'Content-type: application/x-www-form-urlencoded';    
            $content = [
                    'cliente'       => self::$clienteId, 
                    'api'           => self::$clienteToken, 
                    'numero'        => $numbers, 
                    'sms'           => $msg, 
                    'fecha'         => '', 
                    'referencia'    => $idEmpresa,
            ];
            $curlService = new \Ixudra\Curl\CurlService();

            $response = $curlService->to('https://api.hablame.co/sms/envio/')
                ->withHeader($header)
                ->withData($content)
                ->post();
            $responses = json_decode($response,true);
            #Valido resultado, si es igual a 0 fue existoso el envio

            #Se dividen el o los resultados 
            $resms = $responses['sms'];
            
            if ($responses['resultado'] === 0) {
                #Se almacena el resultado
                $existosos  =   self::saveResults($responses,$resms,$relCampPubli);
                
                /*echo response()
                    ->json(['code' => '200', 
                            'data' => $response,
                            'msg' => 'Send SMS',
                            'content' => $content]);*/
            } 
            else {
                /*echo  response()
                    ->json(['code' => '204', 'msg' => $responses['resultado_t']]);*/
            }
            //Log::info(var_dump($response));

            return $existosos;
        }else{
            echo "No hay numeros";
        }
    }

    public static function saveResults($responses,$resms,$relCampPubli){

        $existosos  =   0;
        foreach ($resms as $key) {

            if ($key['resultado'] == 0) {
                $existosos  +=   1; 
            }

            TabResultadoSmsDet::create([
                'tab_publico_objetivo_info_id'  =>  $relCampPubli,
                'aceptado'                      =>  $key['resultado'],
                'fecha_envio'                   =>  $key['fecha_envio'],
                'enviado'                       =>  $key['resultado'],
                'fecha_confirmado'              =>  $key['fecha_envio'],
                'resultado_t'                   =>  $key['resultado_t'],
                'caracteres'                    =>  strlen($key['sms']),
                'costo'                         =>  round($key['precio_sms']),
                'ip'                            =>  $responses['ip'],
                'numero'                        =>  $key['numero'],
            ]);            
        }
        return $existosos;
    }

}
