@extends('base.app')

@section('migas')
<h1>
Dashboard
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Usuarios</li>
</ol>
@endsection

@section('contenido')

<div class="col-xs-12 col-md-12">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;Usuarios</h3>
      <div class="box-tools pull-right">
        <a href="{{ route('create_user') }}" class="btn btn-info"><i class="fa fa-users"></i>&nbsp;Crear Usuario</a>
      </div>
    </div>
    <div class="box-body">
      <table id="lista_usuarios" class="table table-bordered table-striped" width="100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Sexo</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection


@section('js')

<script type="text/javascript">
  $(document).ready(function() {
    $('#lista_usuarios').DataTable( {
      "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
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
          "ajax": '{{ route("list_user_ajax") }}',
          "deferRender":    false,
          "processing":     true,
          "scrollCollapse": true,
          "scrollX":       true,
          "scroller":       true,
          "stateSave":      true,
          "serverSide": true
      } );
  });
</script>

@endsection