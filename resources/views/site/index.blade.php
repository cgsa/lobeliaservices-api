@extends('main')

@section('contenido')

<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Clientes</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 m-b-5">
                                	<a href="" class="btn btn-primary" id="new_client" >Nuevo Cliente</a>
                                	
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th></th>
                                                <th>Redirect</th>
                                                <th>Secret</th>
                                                <th width="15%"></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach( $clients as $client)                                        
                                                <tr>
                                                    <td>{{ $client->name }}</td>
                                                    <td>{{ $client->redirect }}</td>
                                                    <td>{{ $client->secret }}</td>
                                                    <td>                                                    	
                                                      	<a href="" title="Editar" data-id="{{$client->id}}" class="btn btn-default edit_client" >
                                                      		<i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                      	</a>
                                                </tr>
                                        	@endforeach                                        
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- End Row -->



        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

</div> <!-- content -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
</div>
@stop

@section('javascript')
	$(document).ready(function()
	{
		
		
		$('#new_client').click(function(e) {
		
			e.preventDefault();
			
            _token = "{{ csrf_token() }}";
            var userid = "";
            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                url: "{{ route('user.new') }}",
                type: 'POST',
                cache: false,
                data: { 'userid': userid, '_token': _token }, //see the $_token
                datatype: 'json',
                beforeSend: function() {
                    //something before send
                },
                success: function(data) {
                    
                    if(data.success == true) {
                      //user_jobs div defined on page
                      $('#exampleModal').html(data.html);
                    }$('#exampleModal').modal('show');
                },
                error: function(xhr,textStatus,thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        });
        
        
        
        $('.edit_client').click(function(e) {
		
			e.preventDefault();
			
            _token = "{{ csrf_token() }}";
            var userid = $(this).attr('data-id');
            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                url: "{{ route('user.edit') }}",
                type: 'POST',
                cache: false,
                data: { 'userid': userid, '_token': _token }, //see the $_token
                datatype: 'json',
                beforeSend: function() {
                    //something before send
                },
                success: function(data) {
                    
                    if(data.success == true) {
                      //user_jobs div defined on page
                      $('#exampleModal').html(data.html);
                    }$('#exampleModal').modal('show');
                },
                error: function(xhr,textStatus,thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        });


	});
@stop


