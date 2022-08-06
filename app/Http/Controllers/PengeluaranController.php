<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pengeluaran.index');
    }

    public function data()
    {
        $pengeluarans = Pengeluaran::all();

        return datatables()
            ->of($pengeluarans)
            ->addIndexColumn()
            ->editColumn('nominal', function ($pengeluarans) {
                return format_uang($pengeluarans->nominal);
            })
            ->addColumn('action', function ($pengeluarans) {
                return '
                    <a href="javascript:editForm(`' . route('pengeluaran.update', $pengeluarans->id_pengeluaran) . '`)" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                    <a href="javascript:deleteData(`' . route('pengeluaran.destroy', $pengeluarans->id_pengeluaran) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
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
        $pengeluaran = new Pengeluaran();
        $pengeluaran->description = $request->description;
        $pengeluaran->nominal = $request->nominal;
        $pengeluaran->save();

        return response()->json("Success add new data", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        $data = Pengeluaran::findOrFail($pengeluaran->id_pengeluaran);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $data = Pengeluaran::findOrFail($pengeluaran->id_pengeluaran);
        $data->description = $request->description;
        $data->nominal = $request->nominal;
        $data->update();

        return response()->json('Datta successfull edited', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $data = Pengeluaran::findOrFail($pengeluaran->id_pengeluaran);
        $data->delete();

        return response()->json('Data successfull deleted', 200);
    }
}
