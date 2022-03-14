<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    protected $fillable = ['description'];

    // protected $rules = [
    //     'description' => 'required|min:4|max:255'
    // ];
}
