<?php

namespace App\Http\Controllers;

use App\Models\Buyying;
use App\Models\Product;
use App\Models\Selling;
use App\Models\SellingDetail;
use App\Models\setting;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class SellingDetailController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('product_name')->get();
        $setting = setting::first();

        #Cek ada transaksi yang sedang berjalan
        if ($id_selling = session('id_selling')) {
            $data = SellingDetail::where('id_selling', $id_selling)->get();

            $total = 0;
            $total_item = 0;
            foreach ($data as $key => $item) {
                $total += $item->subtotal;
                $total_item += $item->count;
            }
            return view('selling_detail.index', compact('products', 'setting', 'id_selling', 'total', 'total_item'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaction.new');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = SellingDetail::with('product')->where('id_selling', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('product_code', function ($detail) {
                return '<span class="badge badge-success">' . $detail->product->product_code . '</span> ';
            })
            ->addColumn('product_name', function ($detail) {
                return $detail->product->product_name;
            })
            ->editColumn('sell_price', function ($detail) {
                return format_uang($detail->sell_price);
            })
            ->addColumn('count', function ($detail) {
                return '<input type":number" data-id="' . $detail->id_selling_detail . '" class="form-control input-sm quantity" value="' . $detail->count . '"> ';
            })
            ->editColumn('subtotal', function ($detail) {
                return 'Rp ' . format_uang($detail->subtotal);
            })
            ->addColumn('action', function ($detail) {
                return '
                    <a href="javascript:deleteData(`' . route('transaction.destroy', $detail->id_selling_detail) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                ';
            })
            ->rawColumns(['product_code', 'product_name', 'count', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = Product::where('id_product', $request->id_product)->first();
        if (!$product) {
            return response()->json('Product Not Found!');
        }

        $detail = new SellingDetail();
        $detail->id_selling = $request->id_selling;
        $detail->id_product = $product->id_product;
        $detail->sell_price = $product->sell_price;
        $detail->count = 1;
        $detail->discount = 0;
        $detail->subtotal = $product->sell_price;
        $detail->save();

        return response()->json('Success buy product', 200);
    }

    public function update(Request $request)
    {
        $detail = SellingDetail::findOrFail($request->id);
        $detail->count = $request->count;
        $detail->subtotal = $detail->sell_price * $request->count;
        $detail->update();

        return response()->json('Data sucessfull updated', 200);
    }

    public function gettotal(Request $request)
    {
        $id = $request->id;

        $s_detail = SellingDetail::where('id_selling', $id)->get();
        $s = Selling::where('id_selling', $id)->first();

        #Sementara discount 0
        $discount = 0;

        $total = 0;
        $total_item = 0;

        foreach ($s_detail as $key => $item) {
            $total_item += $item->count;
            $total += $item->subtotal;
        }

        $bayar = $total - ($discount / 100 * $total);

        $data = [
            'total' => $total,
            'total_item' => $total_item,
            'totalrp' => format_uang($total),
            'discount' => $discount,
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . 'Rupiah'),
            'diterima' => $s->diterima
        ];

        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = SellingDetail::findOrFail($id);
        $data->delete();

        return response()->json('Data Successfull Deleted', 200);
    }
}
