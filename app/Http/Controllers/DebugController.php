<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function countproduct()
    {
        $product_last = Product::latest()->first();

        // dd($product_last->id_product);
        dd($product_last);
    }
}
