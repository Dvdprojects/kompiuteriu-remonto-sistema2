<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'comment'];

    public function comments(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
    public function formComment(){
        return $this->belongsTo('App\Models\Forma', 'form_id','id');
    }
}
