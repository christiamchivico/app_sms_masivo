<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Models\CatSegmentacionPublico;
use App\Models\TabPublicoInf;
use App\Models\TabPublicoObjetivo;
use App\Models\RelCampanaPublico;

use App\Models\TabBonoSMS;
use App\Models\TabPrecioSMS;

use App\Http\Controllers\Api\ApiSendSMS;

use Redirect;
use Excel;

class TabPublicoObjetivoController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }


    public function create(Request $request)
    {
    	$idCampana	=	$request->idCampana;

    	if (is_numeric($idCampana)) {
	    	$segmento	= CatSegmentacionPublico::all();
	    	return view('public.create',compact('segmento','idCampana'));
    	}else{
    		return Redirect::to(route('Home'));
    	}
    }

    public function new(Request $request){

    	//Obtengo la empresa del usuario logueado

        var_dump($request->all()); exit();
        
    	$idUser 	= Auth::user()->id;
    	$idEmpresa 	= DB::table('users')
	    				->select('rel_users_empresa.tab_empresa_id')
			            ->leftJoin('rel_users_empresa', 'users.id', '=', 'rel_users_empresa.users_id')
			            ->where('users.id',$idUser)
	    				->get();

    	$request->validate([
    				'nombre'	=>	'required|string|max:255',
    				'segmento'	=>	'required|numeric',
    				'archivo'	=>	'required',
    		]);
    	

    	$idPublicoInfo	=	TabPublicoInf::create([
		    						'nombre'						=>	$request->nombre,
		    						'tab_empresa_id'				=>	$idEmpresa[0]->tab_empresa_id,
		    						'cat_segmentacion_publico_id'	=>	$request->segmento,
		    					]);

        $relCampPublico =   RelCampanaPublico::create([
                                    'tab_publico_objetivo_info_id'  =>  $idPublicoInfo->id,
                                    'tab_campana_id'                =>  $request->idCampana,
                                ]);
        

        //Se procesa el archivo cargado y se almacena el resultado
    	$file           =	Input::file('archivo');    	
    	$publicoSMS     =	$this->importExcel($file,$idPublicoInfo->id);

        //Se realiza la validacion del tipo de envio
        $idCampana      =   $request->idCampana;

        $infoCampana    =   DB::table('tab_campana')
                            ->where('id',$idCampana)
                            ->get();
        $infoCampana    =   $infoCampana[0];


                   
        
        /*
        if (!empty($publicoSMS)) {

            $sms            =   $infoCampana->mensaje_sms;
            $idEmpresa      =   $infoCampana->tab_empresa_id;
            $idPubliInfo    =   $idPublicoInfo->id;

            if ($infoCampana->personalizado === 0) {

                $this->saldoSinRestriccion($sms,$idEmpresa,$publicoSMS,$idPubliInfo);
                //$this->noPersonalizado($sms,$idEmpresa,$publicoSMS,$idPubliInfo);                

            }elseif ($infoCampana->personalizado === 1) {

                $this->personalizado($sms,$idEmpresa,$publicoSMS,$idPubliInfo);

            }else{
                return view('Home');
            }
        }*/

    }

    public function saldoSinRestriccion($sms,$idEmpresa,$publicoSMS,$idPubliInfo){


        //Almaceno el precio de la empresa y los bonos asignados
        $TabPrecioSMS   =   TabPrecioSMS::where('tab_empresa_id',$idEmpresa)->first();
        $TabBonoSMS     =   TabBonoSMS::where([
                                ['tab_empresa_id',$idEmpresa],
                                ['activo','1']
                            ])->get();

        //dd($TabBonoSMS);

        //Se extrae el array del objeto
        $TabPrecioSMS   =   json_decode( json_encode( $TabPrecioSMS), true );
        $TabBonoSMS     =   json_decode( json_encode( $TabBonoSMS), true );

        //Cantidad de sms a enviar por el usuario
        $totalPublic    =   count($publicoSMS);
        $exitosos       =   0;

        //Se valida primero que tenga saldo la empresa
        if ($TabPrecioSMS['saldo'] > 0) {

            //Se calcula cuantos sms puede enviar segun el costo vs el saldo actual de la empresa
            $saldoSMS    =   floor($TabPrecioSMS['saldo']/$TabPrecioSMS['costo_sms']);
            print_r('Total de SMS a enviar: '.$totalPublic.'<br/>');
            print_r('Total de SMS con saldo que puedes enviar es: '.$saldoSMS.'<br/>');

            //Se valida que tenga saldo para el total de sms a enviar
            if ($saldoSMS >= $totalPublic) {
                echo "enviados<br/>";
                //Realiza el envio del publico y alamace cuantos fueron exitos para descontar del saldo
                $exitosos   =   $this->noPersonalizado($sms,$idEmpresa,$publicoSMS,$idPubliInfo);
                echo ('Total exitosos '.$exitosos);

                //Calcula el valor segun los sms enviados exitosamente vs el costo que tiene la empresa
                $costo  =   $exitosos*$TabPrecioSMS['costo_sms'];
                $this->descontarSaldo($costo);

            //Cuando el saldo no alcanza se valida si tiene bonos
            }elseif (!empty($TabBonoSMS)){
                //Si tiene Bonos disponibles
                $bonoSMS    =   0;

                //Total de bonos acomulados que tenga la empresa
                foreach ($TabBonoSMS as $key => $value) {

                    $bonoSMS    +=  $value['restantes_sms'];
                }

                print_r('Total sms por bonos: '.$bonoSMS.'<br/>');

                $restante       =   $totalPublic-$saldoSMS;
                $inicioBono     =   $totalPublic-$restante;

                print_r('SMS que no cubre el saldo: '.$restante.'<br/>');

                //Se valida que la cantidad de SMS en bonos cubra el restante que desea enviar
                if ($restante <= $bonoSMS) {
                    //Se separan los SMS a enviar por saldo
                    echo "se puede enviar<br/><br/>";
                    print_r('Publico Saldo:<br/>');
                    $publicoSaldo   =   array_slice($publicoSMS, 0, $saldoSMS);
                    
                    //Realiza el envio del publico y alamace cuantos fueron exitos para descontar del saldo
                    $exitosos   =   $this->noPersonalizado($sms,$idEmpresa,$publicoSaldo,$idPubliInfo);
                    echo ('Total exitosos '.$exitosos.'<br/>');

                    //Calcula el valor segun los sms enviados exitosamente vs el costo que tiene la empresa
                    $costo  =   $exitosos*$TabPrecioSMS['costo_sms'];
                    $this->descontarSaldo($costo,$idEmpresa);
                    
                    foreach ($publicoSaldo as $key => $value) {
                        
                        print_r($value['telefono']);
                        print_r('<br/>');
                        
                    }
                    print_r('<br/>');

                    //--------------------------------------BONO-------------------------------------------
                    //Se separan los SMS a enviar por Bonos
                    print_r('Publico Bono:<br/>');
                    $publicoBono    =   array_slice($publicoSMS,$inicioBono);

                    //Realiza el envio del publico y alamace cuantos fueron exitos para descontar del saldo
                    $exitosos   =   $this->noPersonalizado($sms,$idEmpresa,$publicoBono,$idPubliInfo);
                    echo ('Total exitosos Bonos: '.$exitosos.'<br/>');

                    $this->descontarBonos($exitosos, $idEmpresa, $TabBonoSMS);
                    print_r('<br/>');


                    foreach ($publicoBono as $key => $value) {
                        
                        print_r($value['telefono']);
                        print_r('<br/>');
                        
                    }

                    print_r('<br/>');
                }

                }else{
                    echo "sin bono<br/>";
                    echo "no enviados<br/>";
                }

        }else{
            //Cuando no cuenta con saldo disponible
            echo "Sin saldo<br/>";
        }
        
        //var_dump($TabBonoSMS);


    }

    public function noPersonalizado($sms,$idEmpresa,$publicoSMS,$idPubliInfo){

        $cont       =   0;
        $numeros    =   array();
        $exitosos   =   0;

        //Recorre el array para concatenar los numeros por ',' y cuando concatene 99 los envia y vacia de nuevo el array para concatenar de nuevo otros 99. Si no posee mas de 99 los concatena y luego los envia al momento de cerrar el foreach
        foreach ($publicoSMS as $key => $value) {

            if ($cont == 99) {
                echo " Entro al If: ";
                print_r(count($numeros));
                $numeros    =   implode(',', $numeros);
                //$exitosos +=   ApiSendSMS::sendSMS($sms,$numeros,$idEmpresa,$idPubliInfo);
                $cont       =   0;
                $numeros    =   array();
            }
            array_push ( $numeros, $value['telefono'] );
            $cont       +=  1;
        }
        /*echo " Salio con un total: ";
        print_r(count($numeros));
        echo " y un conteo: ";
        print_r($cont);*/
        $numeros    =   implode(',', $numeros);

        //print_r($numeros);
        //$exitosos +=   ApiSendSMS::sendSMS($sms,$numeros,$idEmpresa,$idPubliInfo);

        echo (' Total de datos: '.count($publicoSMS).'<br />');

        return $exitosos;
        //return view('Home');
    }

    public function personalizado($sms,$idEmpresa,$publicoSMS,$idPubliInfo){

        $exitosos   =   0;

        //Realizo el envio por cada registro enviado
        foreach ($publicoSMS as $key => $value) {

            $msjPersonalizado   =   str_replace('[nombre]', $value['nombre'], $sms);
            $numero                 =   $value['telefono'];

            print_r($msjPersonalizado);
            //$exitosos +=   ApiSendSMS::sendSMS($msjPersonalizado,$numero,$idEmpresa,$idPubliInfo);
        }

        return $exitosos;
    }

    public function descontarSaldo($costo, $idEmpresa){

        TabPrecioSMS::where('id',$idEmpresa)
                      ->decrement('saldo', $costo);
    }

    public function descontarBonos($enviados, $idEmpresa, $TabBonoSMS){

        print_r('A descontar: '.$enviados);
        print_r('<br/>');

        //Recorro todos los bonos activos
        foreach ($TabBonoSMS as $key => $value) {
            
            //Valido que ya no se hayan descontado
            if ($enviados != 0) {
             
                print_r('Id del Bono: ');
                print_r($value['id'].' restante: '.$value['restantes_sms']);
                print_r('<br/>');

                //Valido que el bono no este vacio
                if ($value['restantes_sms'] != 0) {

                    //Valido que el bono actual posea los mismo sms enviados o menores
                    if ($enviados <= $value['restantes_sms']) {
                    
                        TabBonoSMS::where('id',$value['id'])
                                    ->decrement('restantes_sms', $enviados);
                        $enviados = 0;
                    
                    //Si es mayor, descuento el bono y lo inactivo
                    }else{

                        $enviados -= $value['restantes_sms'];
                        TabBonoSMS::where('id',$value['id'])
                                    ->update(['activo' => 0, 'restantes_sms' => 0]);
                    }
                //Si el bono esta vacio lo inactivo
                }elseif ($value['restantes_smst'] === 0) {
                    TabBonoSMS::where('id',$value['id'])
                                ->update(['activo' => 0]);
                }
            //Si ya se desconto todos los enviados dejo de recorrer los bonos
            }else{
                break;
            }
        }       

    }

    public function importExcel($file,$idPublicoInfo){

		$data = Excel::load($file, function($reader) {})->get();

		if(!empty($data) && $data->count()){
			foreach ($data as $key => $value) {
				$res = TabPublicoObjetivo::create(['email' => $value->email, 'nombre' => $value->nombre, 'telefono' => $value->telefono, 'tab_publico_inf_id' => $idPublicoInfo]);

				$insert[] = ['email' => $value->email, 'nombre' => $value->nombre, 'telefono' => '57'.$value->telefono, 'tab_publico_inf_id' => $idPublicoInfo];
			}
			//print_r($insert);
		}
		
		return $insert;

    }

    public function getPublicoInfoAjax(Request $request){

        ini_set('max_execution_time',0);

        $idCampana = $request->idCampana;

        /*$f_i = $request->fecha_i;
        $f_f = $request->fecha_f;*/
    
        $sEcho = $request->draw;
        $iDisplayStart = $request->start;
        $iDisplayLength = $request->length;

        //Ordering
        $iSortCol_0 = $request->iSortCol_0;
        $iSortingCols = $request->iSortingCols;
        $aColumns = array("pi.nombre","Enviados","Rechazados","Total");
        
        $sWhere = 'WHERE rcp.tab_campana_id = '.$idCampana;

        //Searching
        $sSearch = $request->search['value'];        
        $OrderD = $request->order['0']['dir'];

        //Ordering
        $sByColumn = $request->order['0']['column'];
        if($sByColumn == 0){

            $bY="pi.nombre";

        }elseif($sByColumn == 1){

            $bY="Enviados";

        }elseif($sByColumn == 2){

            $bY="Rechazados";

        }elseif($sByColumn == 3){

            $bY="Total";

        }

        $sOrder = "ORDER BY ".$bY." ".$OrderD;
        
        
        if ($sSearch != null && $sSearch != "")
        {
            if ($sWhere == '') {
                $sWhere .= 'WHERE (';
            } else {
                $sWhere .= 'AND (';
            }

            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . ' LIKE "%' . $sSearch . '%" OR ';
            }

            $sWhere = substr_replace($sWhere, '', -3);
            $sWhere .= ')';
        }

        $inventario = DB::select(
                        "SELECT pi.nombre, 
                                sum(rs.aceptado) as Enviados, 
                                (count(rs.id)-sum(rs.aceptado)) as Rechazados,
                                count(rs.id) as Total
                        FROM tab_publico_inf pi
                        LEFT JOIN rel_campana_publico rcp on rcp.tab_publico_objetivo_info_id = pi.id
                        LEFT JOIN tab_resultado_sms_det rs on rs.tab_publico_objetivo_info_id = pi.id
                        ". $sWhere . "
                        group by pi.id "
                        . $sOrder . "
                        LIMIT ". $iDisplayLength . " OFFSET " . $iDisplayStart 
                    );

        $inventario2 = DB::select("
                        SELECT pi.nombre, 
                                sum(rs.aceptado) as Enviados, 
                                (count(rs.id)-sum(rs.aceptado)) as Rechazados,
                                count(rs.id) as Total
                        FROM tab_publico_inf pi
                        LEFT JOIN rel_campana_publico rcp on rcp.tab_publico_objetivo_info_id = pi.id
                        LEFT JOIN tab_resultado_sms_det rs on rs.tab_publico_objetivo_info_id = pi.id
                        ". $sWhere . "
                        group by pi.id "
                        . $sOrder
                    );

        $filteredInventario = count($inventario);
        $totalInventario    = count($inventario2);

        $output = array(
            "draw"            => $sEcho,
            "recordsTotal"    => $filteredInventario,
            "recordsFiltered" => $totalInventario,
            "data"            => array(),
        );

        foreach ($inventario as $inv)
        {

            $row = array();          

            $row[] = $inv->nombre;
            $row[] = $inv->Enviados;
            $row[] = $inv->Rechazados;
            $row[] = $inv->Total;

            $output['data'][] = $row;

        }

        return response()->json($output);

    }
}
