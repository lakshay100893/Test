<?php

namespace App\Http\Controllers;

use App\Actions\UserActions;
use App\Http\Requests\User as RequestsUser;
use App\Models\User as Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
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
          $actionBtn = '';
          if (auth()->user()->canany(['User View', 'User Edit'])) {
            if (auth()->user()->can('User View')) {
              $actionBtn .= '<a href="' . route('Userprofile', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">View</a>';
            }
            if (auth()->user()->can('User Edit')) {
              $actionBtn .= ' <a href="' . route('UserEdit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>';
            }
          }
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

  public function Update(RequestsUser $request, Users $id, UserActions $action)
  {
    try {
      $action->handle($request, $id);
    } catch (\Throwable $th) {
      Log::error($th);
      return redirect()->back()->withInput()->with('error', 'Something Wrong. Try Again');
    }

    return redirect()->intended('/Userlist')->with('success', 'User Update Successfully');
  }
}
