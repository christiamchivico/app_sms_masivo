<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use validate;

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
            return view('auth.register');
        }
    }

    public function register(Request $request)
    {

        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
            'name'     => 'required',
        ]);

        //creacion de usuario
        $usuario           = new User;
        $usuario->name     = $request->name;
        $usuario->email    = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        // Asigno Rol Visitante
        $usuario->roles()->attach('2');
        $informacion = $request->email;

        Mail::send('auth.emails.bienvenido', ['user' => $request->name, 'contrasena' => $request->password, 'usuario' => $request->email, 'url' => route('login')], function ($m) use ($informacion)
        {

            $m->to($informacion)->subject('Bienvenido a TeleSoft !');

        });

        return Redirect::to(route('login'))->with('mensaje', 'Se ha enviado un Email con la información para el ingreso al sistema!');
    }
}
