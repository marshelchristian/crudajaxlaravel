@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<h1>Simple Laravel Crud Ajax</h1>
	</div>  
</div>

<div class="row">
	<div class="table table-responsive">
		<table class="table table-bordered" id="table">
			<tr>
				<th width="150px"> No</th>
				<th> Title</th>
				<th> Body</th>
				<th> Created At</th>
				<th class="text-center" width="150px"> 
					<a href="#" class="create-modal btn btn-success btn-sm">
						<i class="glyphicon glyphicon-plus"></i>
					</a>
				</th>
			</tr>
			@csrf
			<?php $no = 1; ?>
			@foreach ($post as $key => $value)
			<tr class="post{{$value->id}}">
				<td>{{ $no++ }}</td>
				<td>{{ $value->title }}</td>
				<td>{{ $value->body }}</td>
				<td>{{ $value->created_at }}</td>
				<td>
					<a href="#" class="show-modal btn btn-info btn-sm" data-id="{{$value->id}}" data-title="{{$value->title}}" data-body="{{$value->body}}">
						<i class="fa fa-eye"></i>
					</a>
					<a href="#" class="edit-modal btn btn-warning btn-sm" data-id="{{$value->id}}" data-title="{{$value->title}}" data-body="{{$value->body}}">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
					<a href="#" class="delete-modal btn btn-danger btn-sm " data-id="{{$value->id}}" data-title="{{$value->title}}" data-body="{{$value->body}}">
						<i class="glyphicon glyphicon-trash"></i>
					</a>
						
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	{{ $post->links() }}
</div>
<!-- form create post -->
<div id="create" class=" modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form action="" role="form" class="form-horizontal">
					<div class="form-group row add">
						<label for="title" class="control-label col-sm-2">Tittle :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" name="title" value="" placeholder="Your Title Here" required>
							<p class="error text-center alert alert-danger hidden"></p>
						</div>
					</div>
					<div class="form-group ">
						<label for="body" class="control-label col-sm-2">Body :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="body" name="body" value="" placeholder="Your Body Here" required>
							<p class="error text-center alert alert-danger hidden"></p>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-warning" type="submit" id="add">
					<span class="glyphicon glyphicon-plus"> Save Post</span>
				</button>
				<button class="btn btn-warning" type="button" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"> Close</span>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- form show post -->
<div id="show" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<p>ID : <span id="idshow"></span></p>
				<p>Tittle : <span id="idtitle"></span></p>
				<p>Body : <span id="idbody"></span></p>
			</div>
			<div class="modal-footer">
				<button type="button" class=" btn btn-warning" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"></span> Close
				</button>
			</div>
		</div>
	</div>
</div>

<!-- form edit dan delete post -->
<div id="myModal" class="modal fade"  role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="modal">
					<div class="form-group">
						<label for="id" class="control-label col-sm-2">ID</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fid" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="control-label col-sm-2">Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="t">
						</div>
					</div>
					<div class="form-group">
						<label for="body" class="control-label col-sm-2">Body</label>
						<div class="col-sm-10">
							<textarea type="text" class="form-control" id="b"></textarea> 
						</div>
					</div>

				</form>
				<!-- form delete post -->
				<div class="deleteContent">
					Are you sure want to delete <span class="title"></span>?
					<span class="hidden id"></span>
				</div>
			</div>	

				<div class="modal-footer">
					<button type="button" class="btn actionBtn" data-dismiss="modal">
						<span id="footer_action_button" class="glyphicon"></span>
					</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal">
						<span class="glyphicon glyphicon"></span>Close
					</button>
				</div>		
		</div>		
	</div>
</div>

@endsection