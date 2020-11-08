@extends('userRecords.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div style="text-align: center">
            <h1>TEST - CRUD APPLICATION </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <h3>User Records </h3>
    </div>
    <div class="col-lg-6" style="text-align: right">
        <a class="btn btn-success" href="javascript:void(0)" id="addNewRecord"> Add New </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Experience</th>
            <th width="100px"></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modelHeading" >Add new record</h4>
            </div>
            <div class="modal-body">
                <form id="userRecordsForm" >
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="form-group input-group">
                        <label for="name" class="col-sm-4 control-label">Email <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required="">
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div id="err_email" class="required"></div>
                        </div>
                    </div>

                    <div class="form-group input-group">
                        <label for="name" class="col-sm-4 control-label">Full Name <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required="">
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div id="err_name" class="required"></div>
                        </div>
                    </div>

                    <div class="form-group input-group">
                        <label for="name" class="col-sm-4 control-label">Date of Joining <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group date dateOfJoining" data-date-format="dd-mm-yyyy">
                                <input type="text" id="date_of_joining" name="date_of_joining" value="" class="form-control" required=""/>
                                <label class="input-group-addon btn">
                                    <span class="fas fa-calendar">
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div id="err_date_of_joining" class="required"></div>
                        </div>
                    </div>

                    <div class="form-group input-group ">
                        <label for="name" class="col-sm-4 control-label">Date of Leaving <span class="required">*</span></label>
                        <div class="col-sm-4">
                            <div class="input-group date dateOfLeaving" data-date-format="dd-mm-yyyy">
                                <input type="text" id="date_of_leaving" name="date_of_leaving" value="" class="form-control"/>
                                <label class="input-group-addon btn">
                                    <span class="fas fa-calendar">
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 custom-control custom-checkbox">
                            <input type="checkbox" name="still_working" id="still_working" class="control-input" >
                            <label class="control-label" >Still Working</label>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div id="err_date_of_leaving" class="required"></div>
                        </div>
                    </div>

                    <div class="form-group input-group">
                        <label for="name" class="col-sm-4 control-label">Upload Image <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="image" name="image" value=""  required="" accept="image/*">
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div id="err_image" class="required"></div>
                        </div>
                    </div>

                    <div class="form-group input-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-primary" id="saveBtn" value="create">Save
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var table = $('.data-table').DataTable({
        serverSide: true,
        order: [],
        searching: false,
        ordering: false,
        ajax: "{{ route('userRecords.index') }}",
        columns: [
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'experience', name: 'experience'},
            {data: 'action', name: 'action'},
        ]
    });

    $('.date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
    });

    $('#email,#name').on('keyup', function () {
        if($(this).val() != '') {
            $('#err_'+$(this).attr('id')).html(' ');
        }
    });

    $('#date_of_joining').on('change', function () {
        if($(this).val() != '') {
            var joinDate = $(this).val();
            var joiningDate = joinDate.split("-").reverse().join("-");
            $('.dateOfLeaving').datepicker('setStartDate', new Date(joiningDate));

            $('#err_'+$(this).attr('id')).html(' ');
        }
    });

    $('#date_of_leaving').on('change', function () {
        if($(this).val() != '') {
            $("#still_working").prop("checked", false);

            var leaveDate = $(this).val();
            var leavingDate = leaveDate.split("-").reverse().join("-");
            $('.dateOfJoining').datepicker('setEndDate', new Date(leavingDate));

            $('#err_'+$(this).attr('id')).html(' ');
        } else {
            $("#still_working").prop("checked", true);
        }
    });

    $('#still_working').on('change', function () {
        if($('#still_working').is(':checked') == true){
            $('#date_of_leaving').val('');
            $('#err_date_of_leaving').html(' ');
        }
    });

    $('#image').on('change', function () {
        if($(this).val() != '') {
            $('#err_'+$(this).attr('id')).html(' ');
        }
    });

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#addNewRecord').click(function () {
            $('#userRecordsForm').trigger("reset");
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function (e) {
            var myForm = $("#userRecordsForm")[0];
            $.ajax({
                data: new FormData(myForm),
                url: "{{ route('userRecords.store') }}",
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#userRecordsForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },

                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var error = err.errors;
                    $('#err_email').html(error.email);
                    $('#err_name').html(error.name);
                    $('#err_date_of_joining').html(error.date_of_joining);
                    $('#err_date_of_leaving').html(error.date_of_leaving);
                    $('#err_image').html(error.image);
                }
            });
        });

        $('body').on('click', '.deleteProduct', function () {
            var user_record_id = $(this).data("id");
            var result = confirm("Are You sure you want to delete !");
            if(result) {
                $.ajax({
                    type: "DELETE",
                    url: 'userRecords'+'/'+user_record_id,
                    data: {
                        "id": user_record_id
                    },
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });
</script>

@endsection
