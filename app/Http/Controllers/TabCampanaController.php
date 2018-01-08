<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

use App\Models\TabCampana;
use App\Models\CatCategoriaCampana;
use App\Models\CatTipoCampana;
use App\Models\RelCampanaTipoCampana;
use App\Models\RelUsersCampana;
use App\Models\TabEmpresa;

class TabCampanaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){

    	$catCampana	=	CatCategoriaCampana::all();
    	$tipCampana	=	CatTipoCampana::all();

    	return view('campanas.create',compact('catCampana','tipCampana'));
    }

    public function new(Request $request){

    	$nombre 	=	$request->nombre;
    	$asunto 	=	$request->asunto;
    	$catCampana =	$request->categoria;
    	$tipCampana =	$request->tipo;
    	$tipSMS		=	$request->resultado_personalizado;
    	$mensaje	=	$request->mensaje;

    	//Obtengo la empresa del usuario logueado
    	$idUser 	= Auth::id();
    	$idEmpresa 	= DB::table('users')
	    				->select('rel_users_empresa.tab_empresa_id')
			            ->leftJoin('rel_users_empresa', 'users.id', '=', 'rel_users_empresa.users_id')
			            ->where('users.id',$idUser)
	    				->get();

	    $request->validate([
	    			'nombre' 					=> 'required|string|max:255',
					'asunto' 					=> 'required|string|max:255',
					'categoria' 				=> 'required',   
					'tipo'						=> 'required',
					'resultado_personalizado'	=> 'required',   
                    'mensaje'                   => 'required|string|max:160',   
	    			]);

	    $idCampana	=	TabCampana::create([
			    				'nombre'					=>	$nombre,
			    				'asunto'					=>	$asunto,
			    				'email_emisor'				=>	'',
			    				'email_respuesta'			=>	'',
			    				'mensaje_sms'				=>	$mensaje,
			    				'cat_categoria_campana_id'	=>	$catCampana,
			    				'tab_empresa_id'			=>	$idEmpresa[0]->tab_empresa_id,
                                'personalizado'             =>  $tipSMS,
			    			]);

	    RelUsersCampana::create([
	    		'users_id'			=>	$idUser,
	    		'tab_campana_id'	=>	$idCampana->id,
	    		]);

	    RelCampanaTipoCampana::create([
	    		'cat_tipo_campana_id'	=>	$catCampana,
        		'tab_campana_id'		=>	$idCampana->id,
	    		]);

        return Redirect::to(route('create_publico',['idCampana'=>$idCampana->id]));

    }

    public function list(){

    	return view('campanas.list');
    }

    public function getUsuariosAjax(Request $request){

        ini_set('max_execution_time',0);

        $f_i = $request->fecha_i;
        $f_f = $request->fecha_f;
    
        $sEcho = $request->draw;
        $iDisplayStart = $request->start;
        $iDisplayLength = $request->length;

        //Ordering
        $iSortCol_0 = $request->iSortCol_0;
        $iSortingCols = $request->iSortingCols;
        $aColumns = array("id","nombre","asunto","email_emisor","email_respuesta","mensaje_sms","cat_categoria_campana_id","tab_empresa_id");
        
        $sWhere = '1=1';
        
        //Searching
        $sSearch = $request->search['value'];        
        $OrderD = $request->order['0']['dir'];

        //Ordering
        $sByColumn = $request->order['0']['column'];
        if($sByColumn == 0){

            $bY="id";

        }elseif($sByColumn == 1){

            $bY="nombre";

        }elseif($sByColumn == 2){

            $bY="asunto";

        }elseif($sByColumn == 3){

            $bY="email_emisor";

        }elseif($sByColumn == 4){

            $bY="email_respuesta";

        }elseif($sByColumn == 5){

            $bY="mensaje_sms";

        }elseif($sByColumn == 6){

            $bY="cat_categoria_campana_id";

        }elseif($sByColumn == 7){

            $bY="tab_empresa_id";

        }

        $sOrder = "ORDER BY ".$bY." ".$OrderD;
        
        
        if ($sSearch != null && $sSearch != "")
        {
        	$sWhere = '';
            $sWhere.= "AND (";           

            for ($i = 0; $i < count($aColumns); $i++)
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$sSearch."%' OR ";
            }

            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        $inventario = DB::table('tab_campana')
        						->select('id','nombre','asunto','email_emisor','email_respuesta','mensaje_sms','cat_categoria_campana_id','tab_empresa_id')
        						//->where($sWhere)
        						->get();


        $inventario3 = DB::table("tab_campana")
        					->count();

        //$displayInventario = count($inventario2);
        $totalInventario = $inventario3;

        $output = array(
            "draw" => $sEcho,
            "recordsTotal" => $totalInventario,
            "recordsFiltered" => $totalInventario,
            "data" => array()
        );

        $string = "";

        foreach ($inventario as $inv)
        {
            $row = array();          

            $row[] = $inv->id;
            $row[] = $inv->nombre;
            $row[] = $inv->asunto;
            $row[] = $inv->email_emisor;
            $row[] = $inv->email_respuesta;
            $row[] = $inv->mensaje_sms;
            $row[] = $inv->cat_categoria_campana_id;
            $row[] = $inv->tab_empresa_id;

            $output['data'][] = $row;

        }

        return response()->json($output);

    }
}
