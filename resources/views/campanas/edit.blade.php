@extends('base.app')

@section('migas')
<h1>
CAMPAÑAS
<small>Edición Campaña</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class=""><a href="#">Camapaña</a></li>
<li class="active">Editar</li>
</ol>
@endsection

@section('contenido')

<form role="form" id="update" action="" method="">
<div class="col-md-6">
  <div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Información Campaña</h3>
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
    <div class="box-body ">
      <div class="form-group has-feedback ">
        <label>Nombre</label>
        <input type="text" class="form-control my-valid-class" id="nombre" name="nombre" autofocus="autofocus" value="{{ $infoCampana->nombre }}" aria-invalid="false" @if($infoCampana->status == '1') disabled="disabled" @endif>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label>Asunto</label>
        <input type="text" class="form-control my-valid-class" id="asunto" name="asunto" autofocus="autofocus" value="{{ $infoCampana->asunto }}" aria-invalid="false" @if($infoCampana->status == '1') disabled="disabled" @endif>
        <span class="glyphicon glyphicon-tag form-control-feedback" ></span>
      </div>
      <div class="form-group">
        <label>Categoria Campaña</label>
        <select class="form-control" id="categoria" name="categoria" @if($infoCampana->status == '1') disabled="disabled" @endif >
          @foreach($catCampana as $key)
            <option @if($infoCampana->cat_categoria_campana_id == $key->id) selected="selected" @endif value="{{ $key->id }}">{{ $key->nombre }}</option>
          @endforeach
        </select>
      </div>

      <div class="checkbox icheck col-md-12">
        <label>
          <input type="checkbox"  id="no_personalizado" @if($infoCampana->personalizado == '0') checked="check" @endif  @if($infoCampana->status == '1') disabled="disabled" @endif >&nbsp;&nbsp;No Personalizado&nbsp;
          <input type="checkbox"  id="personalizado" @if($infoCampana->personalizado == '1') checked="check" @endif  @if($infoCampana->status == '1') disabled="disabled" @endif >&nbsp;&nbsp;Personalizado
          <input type="hidden" name="resultado_personalizado" id="resultado_personalizado" value="0" @if($infoCampana->status == '1') disabled="disabled" @endif >
        </label>
      </div>

      <div class="col-md-12 @if($infoCampana->personalizado == '0') hidden @endif " id="info">

        <span>Para añadir el nombre dentro del SMS Personalizado por favor copiar de la siguiente forma en cualquier parte del texto del mensaje</span></br>    
        <label>[nombre]</label>     </br>
        <span>Ejemplo:</span>    </br>    
        <span>Hola [nombre], como estas?</span>
      </div>

      <div class="form-group col-md-12">
        <label>Mensaje de texto</label>
        <textarea class="form-control" rows="3" id="mensaje" name="mensaje" maxlength="160" @if($infoCampana->status == '1') disabled="disabled" @endif >{{ $infoCampana->mensaje_sms }}</textarea>
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

  </div>

  
</div>
<!-- Panel Publico Objetivo -->
<div class="col-md-6">
  <div class="box box-primary col-md-6">
              <div class="box-header with-border">
                <h3 class="box-title">Información Publico</h3>
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
                <div class="box-body">

                  <div class="form-group has-feedback ">
                    <label>Nombre</label>
                    <input type="text" class="form-control my-valid-class" id="nombre" name="nombre" autofocus="autofocus" value="{{ $infoCampana->nombre }}" aria-invalid="false">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Asunto</label>
                    <input type="text" class="form-control my-valid-class" id="asunto" name="asunto" autofocus="autofocus" value="{{ $infoCampana->asunto }}" aria-invalid="false">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group">
                    <label>Categoria Campaña</label>
                    <select class="form-control select2" id="categoria" name="categoria" disabled="disabled">
                      <option selected="selected" value="">{{ $infoCampana->cat_categoria_campana_id }}</option>
                    </select>
                  </div>

  </div>
</div>
              <!-- /.box-body -->

  </div>
<div class="col-md-12">  
  <div class="box-footer text-center">
    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i>  Actualizar</button>
  </div>
</div>
</form>

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
    
    //$("#no_personalizado").iCheck('check');//inica checked
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

