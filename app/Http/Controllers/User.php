<?php

namespace App\Http\Controllers;

use App\Models\User as Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

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
        ->addColumn('action', function ($row) {
          $actionBtn = '<a href="' . route('Userprofile', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">View</a>';
          return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    return view('User.listing');
  }
}
