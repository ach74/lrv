<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    //para que no se pueda acceder al controlador si logearte
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {
        // Validacion 
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content'  => 'string|required'
        ]);


        // Recogemos los datos del formulario

        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Asigno los valores a mi nuevo objeto guardado
        $comment = new Comment();

        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        // Guardar en la db
        $comment->save();

        // Redirerccion
        return redirect()->route('image.detail', ['id' => $image_id])
            ->with([
                'message' => 'Has publicado tu comentario correctamente!!'
            ]);
    }


    public function delete($id)
    {
        // Conseguir datos del usuario identuificado

        $user = \Auth::user();

        // Conseguir objeto del comentario

        $comment = Comment::find($id);

        // Comprobar si soy el duenyuo del comentario o publicacion

        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
        // Borrar comentario o imagen

        $comment->delete();

        // Redirerccion
        return redirect()->route('image.detail', ['id' => $comment->image->id])
            ->with([
                'message' => 'Comentario eliminado correctamente'
            ]);
        } else {

        // Redirerccion
        return redirect()->route('image.detail', ['id' => $comment->image->id])
            ->with([
                'message' => 'No se ha podido eliminar el comentario'
            ]);
        }
    }
}
