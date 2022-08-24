<?php

namespace App\Http\Controllers;

use App\Models\Buyying_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Supplier;

class BuyyingDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::findOrFail(session('id_supplier'));
        $products = Product::all();
        $id_buyying = session('id_buyying');

        if (!$suppliers) {
            abort(404);
        }

        $data = Buyying_detail::where('id_buyying', $id_buyying)->get();

        $total = 0;
        $total_item = 0;
        foreach ($data as $key => $item) {
            $total += $item->subtotal;
            $total_item += $item->count;
        }

        return view('buyying_detail.index', compact(['id_buyying', 'products', 'suppliers', 'total', 'total_item']));
    }

    public function data($id)
    {
        $detail = Buyying_detail::with('product')
            ->where('id_buyying', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('product_name', function ($detail) {
                return $detail->product->product_name;
            })
            ->addColumn('product_code', function ($detail) {
                // return $detail->product->product_code;
                return '<span class="badge badge-success">' . $detail->product->product_code . '</span> ';
            })
            ->editColumn('buy_price', function ($detail) {
                return format_uang($detail->buy_price);
            })
            ->addColumn('count', function ($detail) {
                return '<input type":number" data-id="' . $detail->id_buyying_detail . '" class="form-control input-sm quantity" value="' . $detail->count . '"> ';
            })
            ->editColumn('subtotal', function ($detail) {
                return 'Rp ' . format_uang($detail->subtotal);
            })
            ->addColumn('action', function ($detail) {
                return '
                    <a href="javascript:deleteData(`' . route('buyying_detail.destroy', $detail->id_buyying_detail) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                ';
            })
            ->rawColumns(['action', 'product_code', 'buy_price', 'subtotal', 'count', 'tot_hide'])
            ->make(true);
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
        $product = Product::where('id_product', $request->id_product)->first();
        if (!$product) {
            return response()->json('Cannot add data', 400);
        }

        $detail = new Buyying_detail();
        $detail->id_buyying = $request->id_buyying;
        $detail->id_product = $product->id_product;
        $detail->buy_price = $product->buy_price;
        $detail->count = 1;
        $detail->subtotal = $product->buy_price;
        $detail->save();

        return response()->json('Data sucessfull added', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buyying_detail  $buyying_detail
     * @return \Illuminate\Http\Response
     */
    public function show(Buyying_detail $buyying_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buyying_detail  $buyying_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyying_detail $buyying_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyying_detail  $buyying_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyying_detail $buyying_detail)
    {
        $detail = Buyying_detail::findOrFail($buyying_detail->id_buyying_detail);
        $detail->count = $request->count;
        $detail->subtotal = $detail->buy_price * $request->count;
        $detail->update();

        return response()->json('Data sucessfull updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buyying_detail  $buyying_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyying_detail $buyying_detail)
    {
        $data = Buyying_detail::findOrFail($buyying_detail->id_buyying_detail);
        $data->delete();

        return response()->json('Data Successfull Deleted', 200);
    }

    public function gettotal(Request $request)
    {
        $id = $request->id;
        $b_detail = Buyying_detail::where('id_buyying', $id)->get();

        #Sementara discount 0
        $discount = 0;

        $total = 0;
        $total_item = 0;
        foreach ($b_detail as $key => $item) {
            $total += $item->subtotal;
            $total_item += $item->count;
        }

        $bayar = $total - ($discount / 100 * $total);

        $data = [
            'total' => $total,
            'total_item' => $total_item,
            'totalrp' => format_uang($total),
            'discount' => $discount,
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . 'Rupiah')
        ];

        return response()->json($data);
    }
}
