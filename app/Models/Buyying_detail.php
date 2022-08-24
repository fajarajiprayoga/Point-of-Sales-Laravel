<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyying_detail extends Model
{
    use HasFactory;

    protected $table = 'buyying_detail';
    protected $primaryKey = 'id_buyying_detail';
    protected $guarded = [];

    public function buyying()
    {
        return $this->hasOne(Buyying::class, 'id_buyying', 'id_buyying');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id_product', 'id_product');
    }
}
