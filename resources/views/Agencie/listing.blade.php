@extends('layouts.app')
@section('title','User listing -Curno Medical')
@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Agenice's table</h4>
        <div class="row">
            <div class="col-12">
                <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6 text-right"><a class="add btn btn-gradient-primary font-weight-bold" href="{{ route('addagencie') }}">Add</a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('jcCode')


<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.bootstrap4.min.js')}}"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}



@endsection