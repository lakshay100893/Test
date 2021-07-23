<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Yajra\DataTables\Facades\DataTables;

class Permission extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = ModelsPermission::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->orderColumn('id', 'name $1')
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('Userprofile', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">View</a>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('d M Y') : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Role.permission');
    }

    public function store(Request $request)
    {
        $response = array();
        
        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions',
        ]);

        if ($Validator->fails()) {
            $response = ['error' => $Validator->errors('img')];
        } else {
            $role = ModelsPermission::create(['name' => $request->input('name')]);
            $response = ['status' => 1, 'massage' => 'Successfully Create Permission ' . $role->name];
        }
        return $response;
    }



}
