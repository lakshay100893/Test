@extends('layouts.app')
@section('title','Permission listing -Curno Medical')
@section('content')


<div class="card">
    <div class="card-body">
        <h4 class="card-title">Permssion's table</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="add-items d-flex">
                    <input type="text" class="form-control todo-list-input" placeholder="Which permission do you have to create today?">
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
                            <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                                <thead>
                                    <tr role="row">
                                        <th>Sn.</th>
                                        <th>Name</th>
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
    <div class="modal-dialog modal-md" role="document">
        <form action="javascript:void(0);" id="permissionEdit" method="post" enctype="multipart/form-data">
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
                            <div class="col-sm-12">
                                <p>
                                    <input type="hidden" name="id" value="">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Permission Name</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="Permission Name" value="">
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                </p>
                            </div>
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
                ajax: "{{ route('permission') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                    }, {
                        data: 'name',
                        name: 'name',
                        orderable: true,
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

                var value = $(this).prevAll('.todo-list-input').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('permission')}}",
                    data: {
                        'name': value
                    },
                    success: (data) => {
                        $('.validation_remove-msg').remove();
                        if (data.status && data.status > 0) {
                            swal("Permission Created", data.massage, "success");
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

            $(document).on('submit', '#permissionEdit', function(e) {
                e.preventDefault();
                var formdata = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('permissionEdit')}}",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('.validation_remove-msg').remove();
                        if (data.status) {
                            swal('Permssion Update',data.massage, 'success');
                            DTable.ajax.reload(null, false);
                            $(this).parents('.modal').modal('hide');
                        }
                        if (data.error) {
                            $.each(data.error.name, function(i, v) {
                                $('#permissionEdit input[name="name"]').parent('div').after('<span class="validation_remove-msg d-block text-danger">' + v + '</span>');
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