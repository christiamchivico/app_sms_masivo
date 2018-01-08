@extends('base.app')

@section('migas')
<h1>
Dashboard
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
@endsection

@section('contenido')

<div class="col-md-12">
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Usuario</h3>
            </div>
            <!-- /.box-header -->
            @if ($errors->any())     
            <div class="alert alert-danger">         
              <ul>             
                @foreach ($errors->all() as $error)                 
                <li>{{ $error }}</li>             
                @endforeach         
              </ul>     
            </div> 
            @endif
            <!-- form start -->
            <form role="form" id="registro" action="{{ route('create_user') }}" method="">
              <div class="box-body">
                <div class="form-group">
                  <label for="email">Correo</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu Correo" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu Nombre" value="{{ old('nombre') }}">
                </div>
                <div class="form-group">
                  <label>Sexo</label>
                  <select class="form-control" id="sexo" name="sexo">
                    <option value="0"> Seleccione </option>
                    @foreach($catsexo as $key)
                    <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="exampleInputEmail1">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmar Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Registrar</button>
              </div>
            </form>
          </div>
</div>
@endsection

@section('js')
<script>
   
    $("#registro").validate({
    rules: {
      nombre: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        email: true
      },
      sexo: {
        required: true,
        min: 1
      },
      password: {
        required: true,
        minlength: 6
      },
      password_confirmation: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      nombre: {
        required: "Por favor ingresa tu nombre",
        minlength: jQuery.validator.format("Al menos {0} Caracteres requeridos!")
      },
      email: {
        required: "Por favor ingresa tu email",
        email: "Ingresa un email válido"
      },
      sexo: {
        required: "Por favor selecciona tu sexo",
        min: "Debes seleccionar una opcion"
      },
      password: {
        required: "Por favor ingresa tu teléfono celular",
        minlength: jQuery.validator.format("Al menos {0} Caracteres requeridos!")
      },
      password_confirmation: {
        required: "Por favor ingresa tu teléfono celular",
        minlength: jQuery.validator.format("Al menos {0} Caracteres requeridos!")
      }
    }
  });
</script>

@endsection