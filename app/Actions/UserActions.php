<?php

namespace App\Actions;

use App\Models\File;
use App\Models\LocumUser;
use App\Models\User as Users;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserActions
{


    public function handle(Request $request, Users $id)
    {
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

        if ($request->has('role') && $request->filled('role')) {
            $role = Role::findById($request->role);
            if ($id->hasAnyRole($id->getRoleNames())) {
                $id->removeRole($id->getRoleNames()->first());
            }
            $id->assignRole($role->name);
        } else {
            $id->roles()->detach();
        }

        return $data;

    }
}
