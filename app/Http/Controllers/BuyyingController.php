<?php

namespace App\Http\Controllers;

use App\Models\Buyying;
use App\Models\Buyying_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Supplier;

class BuyyingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('buyying.index', compact('suppliers'));
    }

    public function showdata()
    {
        $buyyings = Buyying::join('supplier', 'supplier.id_supplier', '=', 'buyying.id_supplier')
            ->select('buyying.*', 'supplier.name')
            ->get();

        // return $buyyings->name;

        return datatables()
            ->of($buyyings)
            ->addIndexColumn()
            ->editColumn('supplier', function ($buyyings) {
                return $buyyings->name;
            })
            ->editColumn('created_at', function ($buyyings) {
                return tanggal_indonesia($buyyings->created_at, false);
            })
            ->editColumn('price_total', function ($buyyings) {
                return "Rp. " . format_uang($buyyings->price_total);
            })
            ->editColumn('discount', function ($buyyings) {
                return $buyyings->discount . " %";
            })
            ->editColumn('bayar', function ($buyyings) {
                return "Rp. " . format_uang($buyyings->bayar);
            })
            ->addColumn('action', function ($buyyings) {
                return '
                    <a href="javascript:detail(`' . route('buyying.detail', $buyyings->id_buyying) . '`)" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"> detail</i></a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function detail($id)
    {
        $data = Buyying_detail::where('buyying_detail.id_buyying', $id)
            ->with('product')
            // ->with('buyying')
            ->get();

        $data2 = Buyying::where('id_buyying', $id)->get();

        // return $data2;
        return view('buyying.detail', compact('data', 'data2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $buyying = new Buyying();
        $buyying->id_supplier = $id;
        $buyying->item_total = 0;
        $buyying->price_total = 0;
        $buyying->discount = 0;
        $buyying->bayar = 0;
        $buyying->save();

        session(['id_buyying' => $buyying->id_buyying]);
        session(['id_supplier' => $buyying->id_supplier]);

        return redirect()->route('buyying_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Buyying::findOrFail($request->id_buyying);
        $data->item_total = $request->total_item;
        $data->price_total = $request->total;
        $data->discount = $request->discount;
        $data->bayar = $request->bayar;
        $data->save();

        $detail = Buyying_detail::where('id_buyying', $request->id_buyying)->get();
        foreach ($detail as $item) {
            $product = Product::find($item->id_product);
            $product->stock += $item->count;
            $product->update();
        }

        return redirect()->route('buyying.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buyying  $buyying
     * @return \Illuminate\Http\Response
     */
    public function show(Buyying $buyying)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buyying  $buyying
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyying $buyying)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyying  $buyying
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyying $buyying)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buyying  $buyying
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyying $buyying)
    {
        //
    }
}
