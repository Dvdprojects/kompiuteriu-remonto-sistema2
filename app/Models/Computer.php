<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Computer
 *
 * @property int $id
 * @property string $computer_brand
 * @property string $computer_model
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Computer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Computer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Computer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereComputerBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereComputerModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $order_id
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereOrderId($value)
 */
class Computer extends Model
{
    use HasFactory;
    protected $fillable = ['computer_brand', 'computer_model'];

    public function order(){
        return $this->belongsTo(Order::Class);
    }
}
