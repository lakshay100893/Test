@extends('layouts.app')
@section('title','User create -Curno Medical')
@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Create Agencie</h4>
        <form class="form-sample" method="POST" action="{{ route('editagencie',['agencie'=>$data->id]) }}" enctype="multipart/form-data">
            @csrf
            <p class="card-description"> Personal info </p>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $data->name }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $data->email }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Phone Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('phn_no') is-invalid @enderror" name="phn_no" value="{{ old('phn_no') ?? $data->phn_no }}">
                            @error('phn_no')
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
                            <textarea type="text" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') ?? $data->address }}</textarea>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') ?? $data->description }}">
                            @error('description')
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
                <div class="col-sm-12">
                    @forelse($data->Files->chunk(3) as $imgs)
                    <div class="row">
                        @foreach($imgs as $user)
                        <div class="col-lg-{{12/$loop->count}} grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-right">
                                        <button data-id="{{$user->id}}" title="Delete" type="button" class="btn btn-outline-info btn-rounded btn-icon delImageAgencie">
                                            <i class="mdi mdi-close-octagon-outline text-primary"></i>
                                        </button>
                                    </h4>
                                    <p class="card-description">
                                        <a target="_blank" href="{{asset($user->file_url)}}">
                                            <img width="100%" src="{{asset($user->file_url)}}" alt="CurnoMedical">
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @empty
                    <p>No Images</p>
                    @endforelse
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><button class="btn btn-block btn-lg btn-gradient-primary mt-4" type="submit">Submit</button></div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('jcCode')
<script>
    $(document).ready(function() {

        $(document).on('click', '.delImageAgencie', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var self = $(this);
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ route('editagencie',['agencie'=>$data->id]) }}",
                            data: { id},
                            success: (data) => {
                                if (data > 0) {
                                    swal("Poof! Your imaginary file has been deleted!", {
                                        icon: "success",
                                    });
                                    self.parents('div.grid-margin').remove()
                                } else {
                                    swal("Opps! Somthing Wrong with the file!", {
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });

                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });

        });

    });
</script>
@endsection