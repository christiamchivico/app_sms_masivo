@extends('base.app')

@section('migas')
<h1>
CAMPAÑAS
<small>Gestion Publico</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Campañas</a></li>
<li class="active">Publico</li>
</ol>
@endsection

@section('contenido')


<div class="col-md-12">
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Añadir Publico</h3>
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

              <input type="hidden" name="idCampana" value="{{ $idCampana }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>  Enviar</button>
              </div>
            </form>
          </div>
</div>

@endsection

@section('js')

<script type="text/javascript"></script>

@endsection

