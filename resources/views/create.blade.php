@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mb-3">
                <h3 class="jumbotron text-center">Craete One
                    <div class="row">
                        <div class="col-sm-12 text-right"><a href="{{ route('/') }}"
                                class="btn btn-sm btn-primary">listing</a></div>
                    </div>
                </h3>
            </div>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <form action="{{ route('save') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <input type="text" placeholder="Name" name="name"
                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="email" placeholder="Email" name="email"
                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="number" min="0" placeholder="Number" name="phone"
                        class="form-control form-control-sm @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 mb-3">
                    <select name="hospital_id" id="hos"
                        class="form-control form-control-sm @error('hospital_id') is-invalid @enderror">
                        <option value="">Select Hospital</option>
                        @forelse ($hospital as $hos)
                            <option {{ old('hospital_id') == $hos->id ? 'selected' : '' }} value="{{ $hos->id }}">
                                {{ $hos->name }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('hospital_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 mb-3">
                    <select name="department_id" id="dep"
                        class="form-control form-control-sm @error('department_id') is-invalid @enderror">
                        <option value="">Select Department</option>
                    </select>
                    @error('department_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 text-right">
                    <button class="btn btn-sm btn-success" type="submit"> Save</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('change', '#hos', function() {
                let value = $(this).val();
                $('#dep').html('<option value="">Select Department</option>');
                if (value) {
                    $.ajax({
                        url: "{{ route('department') }}",
                        type: 'GET',
                        data:{id:value},
                        dataType: 'json', // added data type
                        success: function(res) {
                            $('#dep').html('<option value="">Select Department</option>');
                            if (res) {
                                $.each(res,function(i,v){
                                    $('#dep').append('<option value="'+v.id+'">'+v.name+'</option>');
                                });
                            }
                        }
                    });
                }
            })
        });
    </script>
@endsection
