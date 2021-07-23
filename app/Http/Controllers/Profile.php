<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class Profile extends Controller
{
    public function show($id = false)
    {
        if (!$id) {
            $id = Auth::user()->id;
        }
        $user = User::find($id);
        return view('User.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $image = null;
        $response = array();
        $Validator = Validator::make($request->all(), [
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($Validator->fails()) {
            $response = ['error' => $Validator->errors('img')];
        } else {
            if ($request->has('img')) {
                $image = time() . '.' . $request->img->extension();
                $request->img->move(public_path('UserFiles/UserAvtar/'), $image);
                $user = User::find(Auth::user()->id);
                $user->avtar = 'UserFiles/UserAvtar/' . $image;
                $user->save();
                $response = ['status' => 1, 'oldPath' => asset((Auth::user()->avtar) ? Auth::user()->avtar : 'assets/images/faces/face1.jpg'), 'path' => asset('UserFiles/UserAvtar/' . $image)];
            }
        }
        return response()->json($response);
    }
}
