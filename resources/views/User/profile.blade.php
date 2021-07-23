@extends('layouts.app')
@section('title','Profile -Curno Medical')
@section('content')

<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <h4 class="card-title float-left">Personal Info</h4>
                    <div id="visit-sale-chart-legend" class=" card-title rounded-legend legend-horizontal legend-top-right float-right">Join on: {{date('d-m-Y',strtotime($user->created_at))}}</div>
                </div>
                <div class="container-fluid text-sm">
                    <div class="row mt-3 mb-3">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">First Name: </div>
                                <div class="col-sm-6"><span class="d-block text-center btn-outline-light text-black btn-fw">{{strtoupper($user->first_name)}}</span></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">Last Name: </div>
                                <div class="col-sm-6"><span class="d-block text-center btn-outline-light text-black btn-fw">{{strtoupper($user->last_name)}}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Title: </div>
                                <div class="col-sm-8"><span class="d-block text-center btn-outline-light text-black btn-fw">{{strtoupper($user->title)}}</span></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">DOB: </div>
                                <div class="col-sm-8"><span class="d-block text-center btn-outline-light text-black btn-fw">{{date('d-m-Y',strtotime($user->LocumUser->dob))}}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 mb-1">Home Address: </div>
                                <div class="col-sm-12"><span class="d-block text-center btn-outline-light text-black btn-fw">{{strtoupper($user->LocumUser->home_address)}}</span></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <h4 class="card-title float-left">Profile Pic</h4>
                    <div id="visit-sale-chart-legend" class=" card-title rounded-legend legend-horizontal legend-top-right float-right">
                        <button type="button" data-toggle="modal" data-target="#exampleModal-4" data-whatever="Profile Image Upload For {{strtoupper($user->first_name.' '.$user->last_name)}}" class="btn btn-outline-secondary btn-rounded btn-icon">
                            <i class="mdi mdi-file-check text-danger"></i>
                        </button>
                    </div>
                </div>
                <img src="{{ asset( ($user->avtar) ? $user->avtar : 'assets/images/faces/face1.jpg') }}" width="150px" height="150px" class="mx-auto d-block img-raised rounded-circle" alt="...">
                <div class="rounded-legend legend-vertical legend-bottom-left pt-4">
                    <h6 class="clearfix">
                        <span class="float-left"> Email </span>
                        <span class="float-right text-muted">
                            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                        </span></span>
                    </h6>
                    <ul class="list-arrow">
                        @forelse ($user->UserFile as $user)
                        <li><a class="" download="" href="{{asset($user->file_url)}}"> Document No. {{$loop->index+1}} Download</a></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form action="{{ route('profile') }}" id="profilePicUpload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{$user->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-3"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="img" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </p>
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
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            $(document).on('submit', '#profilePicUpload', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var bar = $('.progress-bar');
                // console.log(bar);
                // console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('profile')}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        bar.width(0 + '%');
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                bar.width(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: (data) => {
                        $('.validation_remove-msg').remove();
                        if (data.status > 0) {
                            if (data.path) {
                                $(document).find("img[src='" + data.oldPath + "']").each(function(k, el) {
                                    var newSrc = $(el).attr("src").replace(data.oldPath, data.path);
                                    $(el).attr("src", newSrc);
                                });
                                this.reset();
                                $('#exampleModal-4').modal('hide');
                                swal("Done", "User Profile Pic Updated", "success");
                            }
                        }
                        if (data.error) {
                            $.each(data.error.img, function(a, b) {
                                console.log(b);
                                $('#profilePicUpload input[name="img"]').after('<span class="validation_remove-msg d-block text-danger">' + b + '</span>');
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