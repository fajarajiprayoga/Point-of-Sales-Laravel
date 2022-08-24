<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyying extends Model
{
    use HasFactory;

    protected $table = 'buyying';
    protected $primaryKey = 'id_buyying';
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
}
