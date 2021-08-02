@extends('layouts.app')
@section('title','User create -Curno Medical')
@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Create User</h4>
        <form class="form-sample" method="POST" action="{{ route('UserEdit',['id'=>$user->id]) }}" enctype="multipart/form-data">
            @csrf
            <p class="card-description"> Personal info {{($user->getRoleNames()->first())}}</p>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $user->title }}">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? $user->first_name }}">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $user->last_name }}">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                <option value="">Select One</option>
                                @foreach(['Male','Female'] as $value)
                                <option {{ (old('gender'))?((old('gender')==$value)?'selected':''):( ( strtolower($user->gender) == strtolower($value) )?'selected':'' ) }} value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date of Birth</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" placeholder="dd/mm/yyyy" name="dob" value="{{ old('dob') ?? date('Y-m-d',strtotime($user->LocumUser->dob??'')) }}">
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <p class="card-description"> Login info </p>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('role') is-invalid @enderror" name="role">
                                <option value="">Select One</option>
                                @foreach(Spatie\Permission\Models\Role::all() as $value)
                                    <option {{ (old('role'))?((old('role')==$value->id)?'selected':''):( ( strtolower($user->getRoleNames()->first())==strtolower($value->name) ) ? 'selected' : '' ) }} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <p class="card-description"> Address </p>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="home_address" class="form-control @error('home_address') is-invalid @enderror">{{ old('home_address') ?? $user->LocumUser->home_address??'' }}</textarea>
                            @error('home_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Profile Summary</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('profile_summary') is-invalid @enderror" name="profile_summary" value="{{ old('profile_summary') ?? $user->LocumUser->profile_summary ?? ''  }}">
                            @error('profile_summary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">key Skills</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('key_skills') is-invalid @enderror" name="key_skills" value="{{ old('key_skills')  ?? $user->LocumUser->key_skills ?? ''  }}">
                            @error('key_skills')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" multiple name="file_url[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><button class="btn btn-block btn-lg btn-gradient-primary mt-4" type="submit">Submit</button></div>
            </div>
        </form>
    </div>
</div>

@endsection