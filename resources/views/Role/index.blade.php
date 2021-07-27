@extends('layouts.app')
@section('title','Role listing -Curno Medical')
@section('content')


<div class="card">
    <div class="card-body">
        <h4 class="card-title">Role's table</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="add-items d-flex">
                    <input type="text" class="form-control todo-list-input" placeholder="Which role do you have to create today?">
                    <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
                </div>
            </div>
            <div class="col-sm-6"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="order-listing" class="table dataTable table-hover no-footer" role="grid" aria-describedby="order-listing_info">
                                <thead>
                                    <tr role="row">
                                        <th>Sn.</th>
                                        <th>Name</th>
                                        <th>Count</th>
                                        <th>Created On</th>
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
<div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('permission.set') }}" id="permissionSet" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-3"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <div class="container-fluid">
                        <div class="row">
                            @forelse(Spatie\Permission\Models\Permission::all() as $key => $per)
                            <div class="col-sm-6 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <div class="form-check form-check-success">
                                        <label for="id-{{$key}}" class="form-check-label">
                                            <input id="id-{{$key}}" name="permission[]" type="checkbox" value="{{ $per->id }}" class="form-check-input"> {{strtoupper($per->name)}} <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-sm-12">
                                <blockquote class="blockquote blockquote-primary">
                                    <p>No permission Available For assign.</p>
                                </blockquote>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
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
            var DTable = $('#order-listing').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('role') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                    }, {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        data: 'permissions_count',
                        name: 'permissions_count',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            var todoListItem = $('.todo-list');
            var todoListInput = $('.todo-list-input');
            $('.todo-list-add-btn').on("click", function(event) {
                event.preventDefault();

                var role = $(this).prevAll('.todo-list-input').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('role')}}",
                    data: {
                        'name': role
                    },
                    success: (data) => {
                        $('.validation_remove-msg').remove();
                        if (data.status && data.status > 0) {
                            swal("Role Created", data.massage, "success");
                            $(this).prevAll('.todo-list-input').val('');
                            DTable.draw();
                        }
                        if (data.error) {
                            $.each(data.error.name, function(a, b) {
                                $('.todo-list-input').parent('div').after('<span class="validation_remove-msg d-block text-danger">' + b + '</span>');
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
                // if (item) {
                //     todoListItem.append("<li><div class='form-check'><label class='form-check-label'><input class='checkbox' type='checkbox'/>" + item + "<i class='input-helper'></i></label></div><i class='remove mdi mdi-close-circle-outline'></i></li>");
                //     todoListInput.val("");
                // }

            });

            $(document).on('submit', '#permissionSet', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('permission.set')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        $(this).parents('.modal').modal('hide')
                        if (data.permissions.length > 0) {
                            swal('Permssion Set ' + data.name, 'Permissoin Set SuccessFully', 'success')
                        } else {
                            swal('Permssion Set ' + data.name, 'All Permissoin Removed', 'info')
                        }
                        DTable.ajax.reload( null, false );
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $(document).on('click', '.getPermssion', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('permission.get')}}",
                    data: {
                        id
                    },
                    success: (data) => {
                        
                        $("#permissionSet input:checkbox").prop("checked", false);
                        if (data.length > 0) {
                            $.each(data, function(i, v) {
                                $("#permissionSet input[value=" + v.id + "]").prop("checked", true);
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });


        });



    })(jQuery);
</script>
@endsection