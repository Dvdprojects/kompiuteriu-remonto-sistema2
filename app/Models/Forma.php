<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forma extends Model
{
    use HasFactory;


    protected $fillable = ['computer_brand', 'computer_model', 'comment', 'saskaitos_nr', 'address', 'postal_code', 'delivery'];

    public function formComment(){
        return $this->hasOne('App\Models\Comment', 'form_id','id');
    }
    public function forms(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }

}
