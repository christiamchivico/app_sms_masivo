<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

use App\Models\TabCampana;
use App\Models\CatCategoriaCampana;
//use App\Models\CatTipoCampana;
//use App\Models\RelCampanaTipoCampana;
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

        $catCampana =   CatCategoriaCampana::all();
        //$tipCampana   =   CatTipoCampana::all();

        //return view('campanas.create',compact('catCampana','tipCampana'));
        return view('campanas.create',compact('catCampana'));
    }

    public function new(Request $request){

        $nombre     =   $request->nombre;
        $asunto     =   $request->asunto;
        $catCampana =   $request->categoria;
        //$tipCampana = $request->tipo;
        $tipSMS     =   $request->resultado_personalizado;
        $mensaje    =   $request->mensaje;

        //Obtengo la empresa del usuario logueado
        $idUser     = Auth::id();
        $idEmpresa  = DB::table('users')
                        ->select('rel_users_empresa.tab_empresa_id')
                        ->leftJoin('rel_users_empresa', 'users.id', '=', 'rel_users_empresa.users_id')
                        ->where('users.id',$idUser)
                        ->get();

        $request->validate([
                    'nombre'                    => 'required|string|max:255',
                    'asunto'                    => 'required|string|max:255',
                    'categoria'                 => 'required',   
                    'resultado_personalizado'   => 'required',   
                    'mensaje'                   => 'required|string|max:160',   
                    ]);

        $idCampana  =   TabCampana::create([
                                'nombre'                    =>  $nombre,
                                'asunto'                    =>  $asunto,
                                'email_emisor'              =>  '',
                                'email_respuesta'           =>  '',
                                'mensaje_sms'               =>  $mensaje,
                                'cat_categoria_campana_id'  =>  $catCampana,
                                'tab_empresa_id'            =>  $idEmpresa[0]->tab_empresa_id,
                                'personalizado'             =>  $tipSMS,
                            ]);

        RelUsersCampana::create([
                'users_id'          =>  $idUser,
                'tab_campana_id'    =>  $idCampana->id,
                ]);

        /*RelCampanaTipoCampana::create([
                'cat_tipo_campana_id'   =>  $catCampana,
                'tab_campana_id'        =>  $idCampana->id,
                ]);*/

        return Redirect::to(route('create_publico',['idCampana'=>$idCampana->id]));

    }

    public function list(){

        return view('campanas.list');
    }

    public function edit(Request $request){

        if (isset($request->id)) {
            
            $id = $request->id;

            $infoCampana = TabCampana::where('id',$id)->first();
            $catCampana  = CatCategoriaCampana::all();  

            return view('campanas.edit',compact('infoCampana','catCampana'));            
        }


    }

    public function getCampanasAjax(Request $request){

        ini_set('max_execution_time',0);

        $f_i = $request->fecha_i;
        $f_f = $request->fecha_f;
    
        $sEcho = $request->draw;
        $iDisplayStart = $request->start;
        $iDisplayLength = $request->length;

        //Ordering
        $iSortCol_0 = $request->iSortCol_0;
        $iSortingCols = $request->iSortingCols;
        $aColumns = array("id","nombre","asunto","email_emisor","email_respuesta","mensaje_sms","cat_categoria_campana_id","tab_empresa_id","status");
        
        $sWhere = '';
        
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
        }elseif($sByColumn == 8){

            $bY="status";
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

        $inventario = DB::select("SELECT id, nombre, asunto, email_emisor, email_respuesta, mensaje_sms, cat_categoria_campana_id, tab_empresa_id, status 
                                FROM tab_campana 
                                ". $sWhere . "
                                ". $sOrder . "
                                LIMIT ". $iDisplayLength . " OFFSET " . $iDisplayStart . "");


        $inventario2 = DB::select("SELECT id, nombre, asunto, email_emisor, email_respuesta, mensaje_sms, cat_categoria_campana_id, tab_empresa_id, status 
                                FROM tab_campana
                                ". $sWhere . "
                                ". $sOrder);

        $filteredInventario = count($inventario);
        $totalInventario    = count($inventario2);

        $output = array(
            "draw"            => $sEcho,
            "recordsTotal"    => $filteredInventario,
            "recordsFiltered" => $totalInventario,
            "data"            => array(),
        );

        $categoriaCampanas = CatCategoriaCampana::all();

        foreach ($inventario as $inv)
        {

            $actions = '<a class="btn btn-success" id="idCampana" name="idCampana" href="'.route('edit_campana',['id' => $inv->id]).'">
                            <i class="fa fa-edit"></i> Editar
                        </a>';

            $row = array();          

            $row[] = $inv->id;
            $row[] = $inv->nombre;
            $row[] = $inv->asunto;
            //$row[] = $inv->email_emisor;
            //$row[] = $inv->email_respuesta;
            $row[] = $inv->mensaje_sms;

            //Change id for name category campana
            foreach ($categoriaCampanas as $key) {

                if ($key['id'] == $inv->cat_categoria_campana_id) {

                    $row[] = $key['nombre'];
                    break 1;
                }
            }

            $row[] = $inv->tab_empresa_id;
            
            if ($inv->status == '0') {
                $status = '<label class="label label-success"> Sin Ejecutar </label>';
            }else{
                $status = '<label class="label label-danger"> Ejecutada </label>';
            }

            $row[] = $status;

            $row[] = $actions;

            $output['data'][] = $row;

        }

        return response()->json($output);

    }
}
