<!DOCTYPE html>
 
<html lang="en">
<head>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laravel DataTable Ajax Crud Tutorial </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<h2>Laravel DataTable Ajax Crud Tutorial</h2>
<br>
<a href="{{ url('/') }}" class="btn btn-secondary">Back to Post</a>
<a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-user">Add New</a>
<br><br>

<table class="table table-bordered table-striped" id="laravel_datatable">
<thead>
    <tr>
        <th>ID</th>
        <th>S. No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Action</th>
    </tr>
</thead>
</table>
</div>

<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="userCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="userForm" name="userForm" class="form-horizontal">
        <input type="hidden" name="user_id" id="user_id">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-12">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required="">
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
            </button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        
    </div>
</div>
</div>
</div>
</body>
<script>
var SITEURL = '{{URL::to('')}}';
console.log(SITEURL);
$(document).ready( function()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#laravel_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: SITEURL + "/ajax-crud-list",
            type: 'GET',
        },
        columns: [
            {data: 'id', name: 'id', 'visible': false },
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
    });
    // when click add user button
    $('#create-new-user').click( function() {
        $('#btn-save').val("create-user");
        $('#user_id').val();
        $('#userForm').trigger("reset");
        $('#userCrudModal').html("Add New User");
        $('#ajax-crud-modal').modal('show');
    });
    // when click edit user
    $('body').on('click', '.edit-user', function() 
    {
        var user_id = $(this).data('id');
        console.log(user_id);
        // console.log(data);
        $.get('ajax-crud-list/' + user_id +'/edit', function (data){
            $('#name-error').hide();
            $('#email-error').hide();
            $('#userCrudModal').html("Edit User");
            $('#btn-save').val("edit-user");
            $('#ajax-crud-modal').modal("show");
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
        })
    });

    $('body').on('click', '#delete-user', function () {
        var user_id = $(this).data("id");
        confirm("Are you sure to delete? ");

        $.ajax({
            type: "get",
            url: SITEURL + "/ajax-crud-list/delete/"+user_id,
            success: function (data) {
                var oTable = $('#laravel_datatable').dataTable();
                oTable.fnDraw(false);
            },
            error: function (data) {
                console.log('Error', data);
            }
        });
    });

});

if ( $("#userForm").length > 0 ) {
    $("#userForm").validate({
        submitHandler: function(form) {
            var actionType = $('#btn-save').val();
            $('#btn-save').html('Submit ');

            $.ajax({
                data: $('#userForm').serialize(),
                url: SITEURL + "/ajax-crud-list/store",
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $('#userForm').trigger("reset");
                    $('#ajax-crud-modal').modal('hide');
                    $('#btn_save').html('Save Changes');
                    var oTable = $('#laravel_datatable').dataTable();
                    oTable.fnDraw(false);
                },
                error: function(data){
                    console.log('Error:', data);
                    $('#btn-save').html('save changes');
                }
            });
        }
    })
}

// if ($("#userForm").length > 0) {
//     $("#userForm").validate({

//         submitHandler: function(form) {

//             var actionType = $('#btn-save').val();
//             $('#btn-save').html('Sending..');
            
//             $.ajax({
//                 data: $('#userForm').serialize(),
//                 url: SITEURL + "ajax-crud-list/store",
//                 type: "POST",
//                 dataType: 'json',
//                 success: function (data) {

//                     $('#userForm').trigger("reset");
//                     $('#ajax-crud-modal').modal('hide');
//                     $('#btn-save').html('Save Changes');
//                     var oTable = $('#laravel_datatable').dataTable();
//                     oTable.fnDraw(false);
                    
//                 },
//                 error: function (data) {
//                     console.log('Error:', data);
//                     $('#btn-save').html('Save Changes');
//                 }
//             });
//         }
//     })
// }
</script>
</html>