@extends('welcome')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="jumbotron text-center">Listing
                <div class="row">
                    <div class="col-sm-12 text-right"><a href="{{ route('save') }}" class="btn btn-sm btn-primary">Create New</a></div>
                </div>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                    <form action="{{ route('/') }}" method="get">
                    <tr>
                        <td colspan="2"><input type="text" value="{{ app('request')->input('email') }}" name="email" class="form-control form-control-sm"  placeholder="email"></td>
                        <td colspan="2"><input type="text" value="{{ app('request')->input('phone') }}" name="phone"  class="form-control form-control-sm"  placeholder="number"></td>
                        <td colspan="2"><button class="btn btn-sm btn-primary" type="submit">Search</button>
                            <a href="{{ route('/') }}" class="btn btn-sm btn-danger">Clear</a>
                        </td>
                    </tr>
                </form>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Department</td>
                        <td>Hospital</td>
                        <td>Created On</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->phone}}</td>
                            <td>{{$value->dep->name}}</td>
                            <td>{{$value->hospital->name}}</td>
                            <td>{{$value->created_at->format('d,M Y')}}</td>
                        </tr>
                    @empty
                    <tr>
                        <td align="center" colspan="6">No record found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">{{ $data->appends(['email'=>app('request')->input('email'),'phone'=>app('request')->input('phone')])->links() }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection