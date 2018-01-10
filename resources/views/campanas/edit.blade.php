@extends('base.app')

@section('migas')
<h1>
CAMPAÑAS
<small>Campañas Creadas</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Campaña</a></li>
<li class="active">Publico</li>
</ol>
@endsection

@section('contenido')


<div class="col-md-12">
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Campaña</h3>
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
            <form role="form" id="registro" action="{{ route('new_campana') }}" method="">
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el nombre de la campaña" value="{{ old('nombre') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="asunto">Asunto</label>
                  <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Ingresa el asunto" value="{{ old('asunto') }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Categoria Campaña</label>
                  <select class="form-control" id="categoria" name="categoria">
                    <option value="0"> Seleccione </option>
                    @foreach($catCampana as $key)
                    <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="checkbox icheck col-md-12">
                  <label>
                    <input type="checkbox"  id="no_personalizado">&nbsp;&nbsp;No Personalizado&nbsp;
                    <input type="checkbox"  id="personalizado">&nbsp;&nbsp;Personalizado
                    <input type="hidden" name="resultado_personalizado" id="resultado_personalizado" value="0">
                  </label>
                </div>

                <dir class="col-md-12 hidden" id="info">

                  <span>Para añadir el nombre dentro del SMS Personalizado por favor copiar de la siguiente forma en cualquier parte del texto del mensaje</span></br>    
                  <label>[nombre]</label>     </br>
                  <span>Ejemplo:</span>    </br>    
                  <span>Hola [nombre], como estas?</span>
                </dir>

                <div class="form-group col-md-12">
                  <label>Mensaje de texto</label>
                  <textarea class="form-control" rows="3" id="mensaje" name="mensaje" placeholder="Escribe..." maxlength="160"></textarea>
                  <ul>
                    <li>
                      <label>Limite de mensaje de texto 160 caracteres.</label>
                    </li>
                    <li>
                      <label>No es permitido el uso de tiles, Ñ, ñ ó caracteres especiales.</label>
                    </li>
                  </ul>
                </div>

                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>  Crear</button>
              </div>
            </form>
          </div>
</div>

@endsection

@section('js')

<script type="text/javascript">

  $(function () {
    $('#personalizado').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    $('#no_personalizado').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    
    $("#no_personalizado").iCheck('check');//inica checked
  });

  $('#no_personalizado').on('ifChecked', function(event){// para cuando checked
    $("#info").addClass("hidden");
      $("#resultado_personalizado").val('0');
      $("#personalizado").iCheck('uncheck');//inica checked

  });

  $('#no_personalizado').on('ifUnchecked', function(event){//si quitan el checked
    $("#resultado_personalizado").val('1');
    $("#personalizado").iCheck('check');//inica checked     
  });

  $('#personalizado').on('ifChecked', function(event){// para cuando checked
    $("#info").removeClass("hidden");
      $("#resultado_personalizado").val('1');
      $("#no_personalizado").iCheck('uncheck');//inica checked      

  });
  
  $('#personalizado').on('ifUnchecked', function(event){//si quitan el checked
    $("#resultado_personalizado").val('0');
    $("#no_personalizado").iCheck('check');//inica checked
  });


</script>

@endsection

