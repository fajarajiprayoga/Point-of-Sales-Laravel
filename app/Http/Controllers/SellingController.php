<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Selling;
use App\Models\SellingDetail;
use App\Models\setting;
use phpDocumentor\Reflection\PseudoTypes\True_;

class SellingController extends Controller
{
    public function index()
    {
        $sellings = Selling::all();

        return view('selling.index', compact('sellings'));
    }

    public function data()
    {
        $sellings = Selling::orderBy('id_selling', 'desc')->get();

        return datatables()
            ->of($sellings)
            ->addIndexColumn()
            ->editColumn('created_at', function ($sellings) {
                return tanggal_indonesia($sellings->created_at, false);
            })
            ->editColumn('id_selling', function ($sellings) {
                return tambah_nol_didepan($sellings->id_selling, 6);
            })
            ->editColumn('price_total', function ($sellings) {
                return "Rp. " . format_uang($sellings->price_total);
            })
            ->editColumn('bayar', function ($sellings) {
                return "Rp. " . format_uang($sellings->bayar);
            })
            ->editColumn('diterima', function ($sellings) {
                return "Rp. " . format_uang($sellings->diterima);
            })
            ->editColumn('discount', function ($sellings) {
                return $sellings->discount . "%";
            })
            ->addColumn('action', function ($sellings) {
                return '
                    <a href="javascript:showDetail()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $selling = new Selling();
        $selling->id_member = null;
        $selling->item_total = 0;
        $selling->price_total = 0;
        $selling->discount = 0;
        $selling->bayar = 0;
        $selling->diterima = 0;
        $selling->id_user = auth()->id();
        $selling->save();

        session(['id_selling' => $selling->id_selling]);

        return redirect()->route('transaction.index');
    }

    public function store(Request $request)
    {
        $data = Selling::findOrFail($request->id_selling);
        $data->item_total = $request->total_item;
        $data->price_total = $request->bayar;
        $data->discount = $request->discount;
        $data->bayar = $request->bayar;
        $data->diterima = $request->diterima;
        $data->save();

        return view('selling.end');
    }

    public function cetakNota()
    {
        $setting = setting::first();
        $selling = Selling::find(session('id_selling'));
        if (!$selling) {
            abort(404);
        }
        $detail = SellingDetail::with('product')->where('id_selling', session('id_selling'))->get();

        return view('selling.cetak_nota', compact('setting', 'selling', 'detail'));
    }
}
