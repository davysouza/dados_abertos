<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graphic extends Model {

    protected $fillable = [
        'name',
        'dataini',
        'datafim',
        'tipo',
        'cidade',
        'funcao'
    ];

    /**
     * A graphic is owned by a user.
     *
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
