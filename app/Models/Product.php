<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

     protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'user_id',
        'color'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
