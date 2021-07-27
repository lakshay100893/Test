<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\File;
use App\Models\UserFile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','can:User Add']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female']),],
            'home_address' => ['required'],
            'dob' => ['required'],
            'profile_summary' => ['required'],
            'key_skills' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $request = request();

        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $user->LocumUser()->create($data);
            if ($request->hasfile('file_url')) {
                foreach ($request->file('file_url') as $files) {
                    $Ext =  $files->extension();
                    $name = time() . rand(1, 100) . '.' . $Ext;
                    $files->move(public_path('UserFiles'), $name);
                    $file = File::create(['file_url' => ('UserFiles/' . $name), 'type' => $Ext]);
                    UserFile::create(['file_id' => $file->id, 'user_id' => $user->id,]);
                }
            }
            if ($request->has('role') && $request->filled('role')) {
                $role = Role::findById($request->role);
                $user->assignRole($role->name);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->back()->withInput()->with('error', 'Something Wrong. Try Again');
        }

        return redirect()->back()->with('success', 'User Created Successfully');
    }
}
