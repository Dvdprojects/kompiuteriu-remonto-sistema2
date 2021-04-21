<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Forma
 *
 * @property int $id
 * @property string $computer_brand
 * @property string $computer_model
 * @property string $comment
 * @property string|null $address
 * @property string|null $postal_code
 * @property int $delivery
 * @property string $busena
 * @property string $saskaitos_nr
 * @property int $comment_state
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Comment|null $formComment
 * @property-read \App\Models\User $forms
 * @method static \Illuminate\Database\Eloquent\Builder|Forma newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forma newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forma query()
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereBusena($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereCommentState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereComputerBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereComputerModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereSaskaitosNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forma whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Forma extends Model
{
    use HasFactory;


    protected $fillable = ['computer_brand', 'computer_model', 'comment', 'saskaitos_nr', 'address', 'postal_code', 'delivery'];

    public function comment(){
        return $this->hasOne('App\Models\Comment', 'form_id','id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }

}
