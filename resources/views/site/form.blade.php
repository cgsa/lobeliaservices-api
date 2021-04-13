<div class="modal-dialog" role="document">
	<form class="" method="post" action="{{ route('passport.clients.store') }}">
    {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">                   
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Name"/>
                {{ $errors->first('name') }}
            </div>

            <div class="form-group">
                <label>Redirect</label>
                <input type="text" name="redirect" value="{{ old('redirect') }}" class="form-control" required placeholder="Redirect"/>
                {{ $errors->first('subtitulo') }}
            </div>               
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                Registrar
            </button>
          </div>
        </div>
    </form>
  </div>