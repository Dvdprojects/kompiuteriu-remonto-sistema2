<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Part
 *
 * @property int $id
 * @property string $part_name
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Part newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Part newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Part query()
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part wherePartName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $order_id
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereOrderId($value)
 */
class Part extends Model
{
    use HasFactory;
    protected $fillable = ['part_name', 'comment'];
    public function order(){
        return $this->belongsTo(Order::Class);
    }
}
