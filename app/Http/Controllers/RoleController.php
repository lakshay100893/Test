<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;



class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::withCount('permissions')->latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->orderColumn('id', 'name $1')
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal-4" data-whatever="Set Permission to ' . strtoupper($row->name) . '" data-id="' . $row->id . '" class="edit btn btn-success btn-sm getPermssion">Set</a>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('d M Y') : '';
                })
                ->addColumn('permissions_count', function ($row) {
                    return $row->permissions_count . ' Permission';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Role.index');
    }

    public function store(Request $request)
    {
        $response = array();

        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
        ]);

        if ($Validator->fails()) {
            $response = ['error' => $Validator->errors('img')];
        } else {
            $role = Role::create(['name' => $request->input('name')]);
            $response = ['status' => 1, 'massage' => 'Successfully Create Role ' . $role->name];
        }
        return $response;
    }

    public function update(Request $request)
    {
        return $request;
    }

    public function assignPermission(Request $request)
    {

        if ($request->ajax()) {
            $role = Role::findById($request->id);
            $Permission = $role->revokePermissionTo($role->getAllPermissions());
            if ($request->has('permission')) {
                $Permission = Permission::findMany($request->permission);
                $Permission = $role->givePermissionTo($Permission);
            }
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            return $Permission;
        }
    }

    public function getPermssion(Request $request)
    {
        if ($request->ajax()) {
            $role = Role::findById($request->id);
            return $role->getAllPermissions();
        }
    }
}
