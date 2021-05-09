<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $saskaitos_nr
 * @property string $short_comment
 * @property string|null $address
 * @property string|null $postal_code
 * @property int $delivery
 * @property string $busena
 * @property int $comment_state
 * @property int $computer_id
 * @property int|null $part_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Computer|null $computer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Part[] $part
 * @property-read int|null $part_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBusena($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCommentState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereComputerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSaskaitosNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShortComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Comment|null $comment
 * @property-read int|null $computer_count
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'postal_code', 'delivery'];
    public function user(){
        return $this->belongsTo(User::Class);
    }
    public function part(){
        return $this->hasMany(Part::Class);
    }
    public function comment(){
        return $this->hasOne(Comment::Class);
    }
    public function computer(){
        return $this->hasOne(Computer::Class);
    }
}
