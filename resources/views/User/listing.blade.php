@extends('layouts.app')
@section('title','User listing -Curno Medical')
@section('content')


<div class="card">
    <div class="card-body">
        <h4 class="card-title">User's table</h4>
        <div class="row">
            <div class="col-12">
                <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                                <thead>
                                    <tr role="row">
                                        <th>Title</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>DOB</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('jcCode')
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/dataTables.bootstrap4.js"></script>
<script>
    (function($) {
        'use strict';
        $(function() {
            $('#order-listing').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('lsiting') }}",
                columns: [
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'fullName',
                        name: 'first_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'status',
                        name: 'is_active',
                        searchable: false
                    },
                    {
                        data: 'dob',
                        name: 'dob'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    })(jQuery);
</script>
@endsection