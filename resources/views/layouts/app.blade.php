<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Laravel Crud</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <nav class="navbar navbar-default navbar-static-top" >
        	<div class="container">
        		<div class="navbar-header">
        			<a href="{{route('post.index')}}" class="navbar-brand">Ajax Crud</a>
        		</div>
        		
        	</div>
        </nav>
        <div class="container">
        	@yield('content')
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<!-- ajax form add -->
		<script type="text/javascript">
			 $(document).on('click','.create-modal', function(){
			 	$('#create').modal('show');
			 	$('.form-horizontal').show();
			 	$('.modal-title').text('Add Post');
			 });
		</script>
		<!-- function add save -->
		<script>
			$("#add").click(function(){
				$.ajax({
					type : "post",
					url : 'addPost',
					data : {
						'_token': $('input[name=_token]').val(),
						'title': $('input[name=title]').val(),
						'body': $('input[name=body]').val(),
					},
					success: function(data){
						if ((data.errors)) {
							$('.error').removeClass('hidden');
							$('.error').text(data.errors.title);
							$('.error').text(data.errors.body);
						}else{
							 $('.error').remove();
							 $('#table').append("<tr class='post" + data.id + "'>"+
							 	"<td>" + data.id + "</td>"+
							 	"<td>" + data.title + "</td>"+
							 	"<td>" + data.body + "</td>"+
							 	"<td>" + data.created_at + "</td>"+
							 	"<td><a class='show-modal btn btn-info btn-sm' data-id'" + data.id + "' data-title '" + data.title + "' data-body '" + data.body + "'>"+
							 	"<i class='fa fa-eye'></i></a>"+
							 	"<a class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-title '" + data.title + "' data-body '" + data.body + "'>"+
							 	"<i class='glyphicon glyphicon-pencil'></i></a>"+
							 	"<a class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-title '" + data.title + "' data-body '" + data.body + "'>"+
							 	"<i class='glyphicon glyphicon-trash'></i></a>"+
							 	"</td>"+
							 	"</tr>");

						}
					},
				});
				$('#title').val('');
				$('#body').val('');
			});

			// show function 
			$(document).on('click', '.show-modal', function(){
				$('#show').modal('show');
				$('#idshow').text($(this).data('id'));
				$('#idtitle').text($(this).data('title'));
				$('#idbody').text($(this).data('body'));
				$('.modal-title').text('show-post');
			});

			//function edit post
			$(document).on('click', '.edit-modal', function(){
				$('#footer_action_button').text(" Update Post");
				$('#footer_action_button').addClass('glyphicon-check');
				$('#footer_action_button').removeClass('glyphicon-trash');
				$('.actionBtn').addClass('btn-success');
				$('.actionBtn').removeClass('btn-danger');
				$('.actionBtn').addClass('edit');
				$('.modal-title').text('Post Edit');
				$('.deleteContent').hide();
				$('.form-horizontal').show();
				$('#fid').val($(this).data('id'));
				$('#t').val($(this).data('title'));
				$('#b').val($(this).data('body'));
				$('#myModal').modal('show');
			});

			$('.modal-footer').on('click', '.edit', function(){
				$.ajax({
					type: 'POST',
					url: 'editPost',
					data: {
						'_token': $('input[name=_token]').val(),
						'id': $('#fid').val(),
						'title': $('#t').val(),
						'body': $('#b').val(),
					},
					success: function(data){
						$('.post' + data.id).replaceWith(" "+
						"<tr class='post" + data.id + "'>"+
						"<td>" + data.id + "</td>"+
					 	"<td>" + data.title + "</td>"+
					 	"<td>" + data.body + "</td>"+
					 	"<td>" + data.created_at + "</td>"+
					 	"<td><a class='show-modal btn btn-info btn-sm' data-id'" + data.id + "' data-title '" + data.title + "' data-body '" + data.body + "'>"+
					 	"<i class='fa fa-eye'></i></a>"+
					 	"<a class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-title '" + data.title + "' data-body '" + data.body + "'>"+
					 	"<i class='glyphicon glyphicon-pencil'></i></a>"+
					 	"<a class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-title '" + data.title + "' data-body '" + data.body + "'>"+
					 	"<i class='glyphicon glyphicon-trash'></i></a>"+
					 	"</td>"+
					 	"</tr>");
						// alert("Berhasil Dirubah");
					},
					error: function(data){
						alert("Terjadi Kesalahan");
					}
				});
			});

			// function delete
			$(document).on('click', '.delete-modal', function() {
				$('#footer_action_button').text(" Delete");
				$('#footer_action_button').removeClass('glyphicon-check');
				$('#footer_action_button').addClass('glyphicon-trash');
				$('.actionBtn').removeClass('btn-success');
				$('.actionBtn').addClass('btn-danger');
				$('.actionBtn').addClass('delete');
				$('.modal-title').text(' Delete Post');
				$('.id').text($(this).data('id'));
				$('.deleteContent').show();
				$('.form-horizontal').hide();
				$('.title').html($(this).data('title'));
				$('#myModal').modal('show');
			});

			$('.modal-footer').on('click', '.delete', function(){
				$.ajax({
					type: 'POST',
					url: 'deletePost',
					data: {
						'_token': $('input[name=_token]').val(),
						'id': $('.id').text()
					},
					success: function(data){
						// alert("Berhasil Dihapus");
						$('.post' + $('.id').text()).remove();
					},
					error: function(data){
						alert("Terjadi Kesalahan Dihapus");
					}
				});
			});
		</script>
        <!-- <p>Hello world! This is HTML5 Boilerplate.</p> -->
        <!-- <script src="js/vendor/modernizr-3.5.0.min.js"></script> -->

        <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> -->
        <!-- <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script> -->
<!--         <script src="js/plugins.js"></script>
        <script src="js/main.js"></script> -->

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<!--         <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script> -->
        <!-- <script src="https://www.google-analytics.com/analytics.js" async defer></script> -->
    </body>
</html>