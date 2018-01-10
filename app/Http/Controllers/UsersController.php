<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CatSexo;
use DB;

class UsersController extends Controller
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
    	
    	$catsexo = CatSexo::all();

    	return view('users.create',compact('catsexo'));

    }

    public function new(Request $request){

    	$nombre 	= $request->nombre;
    	$correo 	= $request->correo;
    	$sexo 		= $request->sexo;
    	$password 	= $request->password;
    	
    	$request->validate([
				'name' 		=> 'required|string|max:255',
				'email' 	=> 'required|string|email|max:255|unique:users',
				'password' 	=> 'required|string|min:6|confirmed',   
				'sexo'		=> 'required',     
				]);

    	$usuario = User::create([
		  'name' 			=> $nombre,
		  'email' 		    => $correo,
		  'password' 		=> bcrypt($password), 
		  'cat_sexo_id' 	=> $sexo, 
		]);

        return $usuario->id;
    }

    public function list(){

    	return view('users.list');

    }

    public function getUsersAjax(Request $request){
        
        ini_set('max_execution_time',0);

        $sEcho = $request->get('draw');
        $iDisplayStart = $request->get('start');
        $iDisplayLength = $request->get('length');

        //Ordering
        $iSortCol_0 = $request->get('iSortCol_0');
        $iSortingCols = $request->get('iSortingCols');
        $aColumns = array("u.id","u.name","u.email","cats.nombre");
        
        $sWhere = ' ';
        
        //Searching
        $sSearch = $request->get('search')['value'];        
        $OrderD = $request->get('order')['0']['dir'];

        //Ordering
        $sByColumn = $request->get('order')['0']['column'];
        if($sByColumn == 0){

            $bY="u.id";

        }elseif($sByColumn == 1){

            $bY="u.name";

        }elseif($sByColumn == 2){

            $bY="u.email";

        }elseif($sByColumn == 3){

            $bY="cats.nombre";

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

        $inventario = DB::select("SELECT u.id, u.name, u.email, cats.nombre, u.status 
                                FROM users u
                                INNER JOIN cat_sexo cats ON cats.id = u.cat_sexo_id
                                ".$sWhere."
                                ".$sOrder."
                                LIMIT ".$iDisplayLength." OFFSET ".$iDisplayStart);

        $inventario2 = DB::select("SELECT u.id, u.name, u.email, cats.nombre, u.status 
                                FROM users u
                                INNER JOIN cat_sexo cats ON cats.id = u.cat_sexo_id
                                ".$sWhere." 
                                ".$sOrder);

        $filteredInventario = count($inventario);
        $totalInventario = count($inventario2);

        $output = array(
            "draw" => $sEcho,
            "recordsTotal" => $filteredInventario,
            "recordsFiltered" => $totalInventario,
            "data" => array()
        );

        $string = "";

        foreach ($inventario as $inv)
        {
            $actions = '<a class="btn btn-success" href="#">
                            <i class="fa fa-edit"></i> Editar
                        </a>';
            $row = array();          

            $row[] = $inv->id;
            $row[] = $inv->name;
            $row[] = $inv->email;
            $row[] = $inv->nombre;

            if ($inv->status == 'Online') {
                $status = '<label class="label label-info"> Conectado </label>';
            }else{
                $status = '<label class="label label-danger"> Desconectado </label>';
            }

            $row[] = $status;
            $row[] = $actions;            

            $output['data'][] = $row;

        }

        return response()->json($output);

    }

}