<?php

namespace App\Http\Controllers;


use Auth;
use Mail;
use Redirect;
use validate;

use App\Models\User;
use App\Models\CatSexo;
use App\Models\TabEmpresa;
use App\Models\TabCampana;
use App\Models\RelUsersEmpresa;

use Illuminate\Http\Request;

class SistemaController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check())
        {
            return Redirect::to(route('Home'));
        }
        else
        {
            return view('auth.login');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $email    = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $actualiza = User::where('id', Auth::user()->id)->update(['status' => 'Online']);
            if (Auth::user()->estado_usuario == 'Desactivado')
            {
                Auth::logout();
                return Redirect::to(route('login'));
            }
            else
            {
                return Redirect::to(route('Home'));
            }
        }
        else
        {
            return Redirect::to(route('login'))->with('error', 'Por favor verificar las credenciales');
        }
    }

    public function logout()
    {
        if (Auth::user() != null)
        {
            $actualiza = User::where('id', Auth::user()->id)->update(['status' => 'Offline']);
            Auth::logout();
        }
        return Redirect::to(route('login'));
    }

    public function showRegistrationForm()
    {
        if (Auth::check())
        {
            return Redirect::to(route('Home'));
        }
        else
        {   
            $catsexo    =   CatSexo::all();
            return view('auth.register', compact('catsexo'));
        }
    }

    public function register(Request $request)
    {

        $this->validate($request, [ 
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
            'name'     => 'required',
            #'sexo'     => 'required',
        ]);

        //creacion de usuario
        $usuario                = new User;
        $usuario->name          = $request->name;
        $usuario->email         = $request->email;
        $usuario->password      = bcrypt($request->password);
        $usuario->cat_sexo_id   = $request->sexo;
        $usuario->save();

        $company = new TabEmpresa;
        $company->nombre = $request->name_company;
        $company->nit    = $request->nit;
        $company->razon_social = $request->business_name;
        $company->save();

        $relUserCompany = new RelUsersEmpresa;
        $relUserCompany->users_id = $usuario->id;
        $relUserCompany->tab_empresa_id = $company->id;
        $relUserCompany->save();
        
        $tabCampana = new TabCampana;
        $tabCampana->nombre = 'GENERICA';
        $tabCampana->asunto = 'GENERICA';
        $tabCampana->email_emisor = $request->email;
        $tabCampana->email_respuesta = $request->email;
        $tabCampana->personalizado = 1; #personalizado true
        $tabCampana->cat_categoria_campana_id = 1; #personalizado true
        $tabCampana->save();

        // Asigno Rol Visitante
        /*$usuario->roles()->attach('2');
        $informacion = $request->email;

        Mail::send('auth.emails.bienvenido', ['user' => $request->name, 'contrasena' => $request->password, 'usuario' => $request->email, 'url' => route('login')], function ($m) use ($informacion)
        {

            $m->to($informacion)->subject('Bienvenido a Bubo Solutions !');

        });*/

        return redirect('login');
        #return Redirect::to(route('register.company'));
    }


    public function showRegisterCompany()
    {
        if (Auth::check())
        {
            return Redirect::to(route('Home'));
        }
        else
        {   
            return view('auth.registerEmpresa');
        }
    }
}
