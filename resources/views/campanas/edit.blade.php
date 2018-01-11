@extends('base.app')

@section('migas')
<h1>
CAMPAÑAS
<small>Edición de Campaña</small>
</h1>
<ol class="breadcrumb">
<li><a href="{{ route('Home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li class=""><a href="{{ route('list_campanas')}}">Campañas</a></li>
<li class="active">Editar Campaña</li>
</ol>
@endsection

@section('css')
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
@endsection

@section('contenido')

<form role="form" id="update" action="" method="">

  <input type="hidden" id="idCampana" name="idCampana" value="{{ $infoCampana->id }}">

<div class="col-md-6">
  <div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Información Campaña - </h3>
    
    @if ( $infoCampana->status == 0)
      <span class="text-light-blue">La campaña aun no se a ejecutado!</span> 
    @else
      <span class="text-red">La campaña ya se ejecuto!</span>
    @endif
    
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
        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
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
      <h4 class="box-title">Publicos Cargados</h4>
      <table id="list_public" class="table table-bordered table-striped" width="100%">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Enviados</th>
            <th>Rechazados</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

    </div>
    <div class="col-md-12 text-center box-footer" >
      <button type="button" class="btn btn-success" id="cargar" data-toggle="modal" data-target="#modal-default">Cargar Nuevo Publico</button> 

    </div>
    

  </div>
</div>

<div class="col-md-12">  
  <div class="box-footer text-center">
    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i>  Actualizar</button>
  </div>
</div>
</form>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Añadir Publico</h4>
      </div>
      <div class="" >
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
            <form role="form" id="" action="{{ route('new_publico') }}" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="nombre">Nombre del Publico</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el nombre del Publico Objetivo" value="{{ old('nombre') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="segmento">Segmento de Publico</label>
                  <select class="form-control" id="segmento" name="segmento">
                    <option value="0"> Seleccione </option>
                    @foreach($segmento as $key)
                      <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                    @endforeach
                  </select>

                </div>

                <div class="form-group col-md-12">
                  <label>Carga tu Archivo</label>
                  
                  <input class="" id="archivo" name="archivo" type="file" accept=".csv">
                </div>
                                
              </div>
              <!-- /.box-body -->

              <input type="hidden" name="idCampana" value="{{ $infoCampana->id }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>  Enviar</button>
              </div>
            </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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

  $(document).ready(function() {

    var idCampana = $('#idCampana').val();

    $('#list_public').DataTable( {

      "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "No hay publico asociado a esta campaña",
          "sInfo":           "Del _START_ al _END_ de un total _TOTAL_",
          "sInfoEmpty":      "No hay registros",
          "sInfoFiltered":   "",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
      },
          "ajax": '{{ route("list_public_ajax") }}?idCampana='+idCampana,
          "deferRender":    false,
          "processing":     true,
          "scrollCollapse": true,
          "scrollX":        true,
          "scroller":       true,
          "stateSave":      true,
          "serverSide":     true,
          "searching":      false,
          "bLengthChange":  false,
      } );
  });

  /*$("#cargar").click(function() {
    var idCampana = $('#idCampana').val();

    console.log(idCampana);

    $.ajax({
            method: "GET",
            url: "{{ route('create_publico',"+idCampana+") }}",
            data: { 'idCampana': idCampana },

            success: function(data){
              $('#modal-publico').html(data);
              //$('#modal-publico').modal('show');
              
              //n();
            }
    });
  })*/

</script>

@endsection

