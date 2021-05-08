<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Indicar cual es el nombre de la tabla

    protected $table = "images";

    // Relacion de one to many

    public function comments(){
        
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    
    }

    // Relacion one to many

    public function likes(){

        return $this->hasMany('App\Like');

    }

    // Relacion Many to One

    public function user(){

        return $this->belongsTo('App\User','user_id');

    }

}
