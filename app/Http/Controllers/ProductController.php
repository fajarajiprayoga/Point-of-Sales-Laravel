<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::all()->pluck('category_name', 'id_category');

        return view('product.index', compact('categorys'));
    }

    public function data()
    {
        $products = Product::leftJoin('category', 'category.id_category', 'product.id_category')
            // ->select('product.*', 'category_name')
            ->orderBy('id_product', 'desc')->get();
        return datatables()
            ->of($products)
            ->addIndexColumn()
            ->addColumn('select_all', function ($products) {
                // <input type="checkbox" name="id_product[]" value="' . $products->id_product . '">
                return '
                    
                    <input type="checkbox" name="id_product" value="{{$products->id_product}}">
                ';
            })
            // <input type="checkbox" name="id_product-' . $products->id_product . '" value="'.$products->id_product.'">
            ->editColumn('product_code', function ($products) {
                return '<span class="badge badge-success">' . $products->product_code . '</span>';
            })
            ->editColumn('buy_price', function ($products) {
                return format_uang($products->buy_price);
            })
            ->editColumn('sell_price', function ($products) {
                return format_uang($products->sell_price);
            })
            ->editColumn('stock', function ($products) {
                return format_uang($products->stock);
            })
            ->editColumn('discount', function ($products) {
                return $products->discount . '%';
            })
            ->addColumn('action', function ($products) {
                return '
                    <a href="javascript:editForm(`' . route('product.update', $products->id_product) . '`)" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                    <a href="javascript:deleteData(`' . route('product.destroy', $products->id_product) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                ';
            })
            ->rawColumns(['action', 'product_code', 'select_all'])
            ->make(true);
    }

    public function deleteselected(Request $request)
    {
        foreach ($request->id_product as $id) {
            $product = Product::findOrFail($id);
            $product->delete();
        }
        return response()->json('Data Successfull Deleted', 200);
    }

    public function cetakbarcode(Request $request)
    {
        $dataproduct = [];

        foreach ($request->id_product as $id) {
            $product = Product::findOrFail($id);
            $dataproduct[] = $product;
        }
        dd($dataproduct);
        $no = 1;

        $pdf = PDF::loadView('product.barcode', compact('dataproduct', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('product.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_last = Product::latest()->first();

        $product = new Product();
        if ($product_last == null) {
            $product->product_code = "P" . tambah_nol_didepan(1, 5);
        } else {
            $product->product_code = $request['id_product'] = "P" . tambah_nol_didepan($product_last->id_product + 1, 5);
        }
        $product->id_category = $request->id_category;
        $product->product_name = $request->product_name;
        $product->merk = $request->merk;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->save();

        return response()->json('Data Successfull Saved', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::findOrFail($product->id_product);

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::findOrFail($product->id_product);
        $product->id_category = $request->id_category;
        $product->product_name = $request->product_name;
        $product->merk = $request->merk;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->update();

        return response()->json('Data Successsfull Edited', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::findOrFail($product->id_product);
        $product->delete();

        return response()->json('Data Successfull Deleted', 200);
    }
}
