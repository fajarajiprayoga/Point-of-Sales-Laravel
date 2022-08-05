<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }
}
