<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\LocumUser;
use App\Models\User as Users;
use App\Models\UserFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class User extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $data = Users::with('LocumUser')->select(['id', 'title', DB::raw('(CONCAT(first_name," ",last_name)) as fullName'), 'email', DB::raw('UPPER(gender) as gender'), 'avtar', DB::raw('(if(is_active > 0,"Active","In-Active")) as status')])->latest();
      return Datatables::eloquent($data)
        ->addIndexColumn()
        ->addColumn('dob', function (Users $user) {
          return $user->LocumUser ? Carbon::parse($user->LocumUser->dob)->format('d M Y') : '';
        })
        ->addColumn('role', function (Users $user) {
          $user = $user->getRoleNames();
          return $user->implode('name', ',');
        })
        ->addColumn('action', function ($row) {
          $actionBtn = '<a href="' . route('Userprofile', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">View</a>';
          $actionBtn .= ' <a href="' . route('UserEdit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>';
          return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    return view('User.listing');
  }

  public function edit(Users $id)
  {
    $user = $id;
    return view('auth.editRegister', compact('user'));
  }

  public function Update(Request $request, Users $id)
  {
    $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'gender' => ['required', Rule::in(['Male', 'Female']),],
      'home_address' => ['required'],
      'dob' => ['required'],
      'profile_summary' => ['required'],
      'key_skills' => ['required'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id->id),],
      'password' => ['confirmed'],
      'password_confirmation' => ['required_with:password'],
    ]);

    $data = array(
      'title' => $request->input('title'),
      'first_name' => $request->input('first_name'),
      'last_name' => $request->input('last_name'),
      'gender' => $request->input('gender'),
      'email' => $request->input('email'),
    );

    if ($request->filled('password')) {
      $data['password'] = Hash::make($request->input('password'));
    }

    DB::beginTransaction();
    try {
      Users::where(['id' => $id->id])->Update($data);
      LocumUser::where(['user_id' => $id->id])->Update([
        'home_address' => $request->input('home_address'),
        'dob' => $request->input('dob'),
        'profile_summary' => $request->input('profile_summary'),
        'key_skills' => $request->input('key_skills'),
      ]);
      if ($request->hasfile('file_url')) {
        foreach ($request->file('file_url') as $files) {
          $Ext =  $files->extension();
          $name = time() . rand(1, 100) . '.' . $Ext;
          $files->move(public_path('UserFiles'), $name);
          $file = File::create(['file_url' => ('UserFiles/' . $name), 'type' => $Ext]);
          UserFile::create(['file_id' => $file->id, 'user_id' => $id->id,]);
        }
      }
      if ($request->has('role')) {
        $role = Role::findById($request->role);
        $id->removeRole($id->getRoleNames()->first());
        $id->assignRole($role->name);
      }
      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::error($th);
      return redirect()->back()->withInput()->with('error', 'Something Wrong. Try Again');
    }


    return redirect()->intended('/Userlist')->with('success', 'User Update Successfully');
  }
}
