<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;


class UserController extends Controller
{

    //para que no se pueda acceder al controlador si logearte
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search = null)
    {

        if(!empty($search)){
            $users = User::where('nick', 'LIKE','%'.$search.'%')
                ->orWhere('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('surname', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'desc')
                            ->paginate(5);
        }else{
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', [
            'users' => $users
        ]);
    }

    public function profile($id)
    {
        $user = User::find($id);

        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function config()
    {
        return view('user.config');
    }


    //Recoger datos para actualizar datos de usuarios
    public function update(Request $request)
    {
        // Conseguir el usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        //Validar el formulario
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick, ' . $id,
            'email' => 'required|string|email|max:255|unique:users,email, ' . $id
        ]);

        // Recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Subir la imagen
        $image_path = $request->file('image_path');

        if ($image_path) {

            //Poner nombre unico
            $image_path_name = time() . $image_path->getClientOriginalName();

            // Guardar en la carpeta storage (Storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        // Ejecutar consulta y cambios en la base de datos
        $user->update();

        return redirect()->route('config')
            ->with(['message' => 'Datos de usuarios actualizado correctamente']);
    }

    public function getImage($filename)
    {

        $file = Storage::disk('users')->get($filename);

        return new Response($file, 200);
    }
}
