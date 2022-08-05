<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use PDO;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $members = Member::all();

        return datatables()
            ->of($members)
            ->addIndexColumn()
            ->addColumn('action', function ($members) {
                return '
                    <a href="javascript:editForm(`' . route('member.update', $members->id_member) . '`)" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                    <a href="javascript:deleteData(`' . route('member.destroy', $members->id_member) . '`)" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                ';
            })
            ->editColumn('member_code', function ($members) {
                return '<span class="badge badge-success">' . $members->member_code . '</span>';
            })
            ->rawColumns(['action', 'member_code'])
            ->make(true);
    }

    public function deleteselected(Request $request)
    {
        foreach ($request->id_member as $id) {
            $member = Member::findOrFail($id);
            $member->delete();
        }
        return response()->json('Data Successfull Deleted', 200);
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
        $members_last = Member::latest()->first();

        $members = new Member();
        if ($members_last == null) {
            $members->member_code = "M" . tambah_nol_didepan(1, 5);
        } else {
            $members->member_code = "M" . tambah_nol_didepan($members_last->id_member + 1, 5);
        }
        $members->name = $request->name;
        $members->address = $request->address;
        $members->telephone = $request->telephone;
        $members->save();

        return response()->json(['success' => 'Member saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $member = Member::findOrFail($member->id_member);
        return response()->json($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $member = Member::findOrFail($member->id_member);
        $member->name = $request->name;
        $member->address = $request->address;
        $member->telephone = $request->telephone;
        $member->update();

        return response()->json('Data Successsfull Edited', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member = Member::findOrFail($member->id_member);
        $member->delete();

        return response()->json('Delete successful', 200);
    }
}
