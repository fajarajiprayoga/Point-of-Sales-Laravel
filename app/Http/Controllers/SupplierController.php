<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.index');
    }

    public function data()
    {
        $suppliers = Supplier::all();

        return datatables()
            ->of($suppliers)
            ->addIndexColumn()
            ->editColumn('action', function ($suppliers) {
                return '
                    <button class="btn btn-xs btn-info btn-flat" onclick="editForm(`' . route('supplier.update', $suppliers->id_supplier) . '`)"> <i class="fa fa-edit"></i> </button>
                    <button class="btn btn-xs btn-danger btn-flat" onclick="deleteData(`' . route('supplier.destroy', $suppliers->id_supplier) . '`)"> <i class="fa fa-trash"></i> </button>
                ';
            })
            ->rawColumns(['action'])
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
        $stores = new Supplier();
        $stores->name = $request->name;
        $stores->address = $request->address;
        $stores->telephone = $request->telephone;
        $stores->save();

        return response()->json('Data sucessfull saved', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        $data = Supplier::findOrFail($supplier->id_supplier);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $data = Supplier::findOrFail($supplier->id_supplier);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->telephone = $request->telephone;
        $data->update();

        return response()->json('Data sucessfull edited', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $data = Supplier::findOrFail($supplier->id_supplier);
        $data->delete();

        return response()->json('Successfull delete data');
    }
}
