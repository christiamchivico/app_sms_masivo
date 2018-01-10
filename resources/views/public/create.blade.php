<div class="col-md-12">
           
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
            <form role="form" id="cargue" enctype="multipart/form-data">
              <input type="hidden" name="idCampana" value="{{ $idCampana }}">
              <!--input type="hidden" name="_token" value="{{ csrf_token() }}"-->
              <meta name="csrf-token" content="{{ csrf_token() }}">
              
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

              

              <div class="modal-footer">
                <a href="javascript:;" onclick="carga_publico()" class="btn btn-primary"><i class="fa fa-upload"></i>  Cargar</a>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>

              </div>
            </form>
</div>

<script type="text/javascript">
  
  function carga_publico(){

    var property = document.getElementById('archivo').files[0];

    var form_data = new FormData();
        form_data.append("file",property);
        form_data.append("idCampana",$('#idCampana').val());
        form_data.append("nombre",$('#nombre').val());
        form_data.append("segmento",$('#segmento').val());
        $.ajax({
          url:"{{ route('new_publico') }}",
          method:'POST',
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            $('#msg').html('Loading......');
          },
          success:function(data){
            console.log(data);
            $('#msg').html(data);
          }
        });

  }

</script>