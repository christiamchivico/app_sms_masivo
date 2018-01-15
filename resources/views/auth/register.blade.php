<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BUBO | Registro</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('plugins/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('plugins/dist/css/skins/_all-skins.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/plugins/iCheck/all.css') }}">

</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="{{ Route('Home') }}"><b>Bubo </b>Digital</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Nuevo Registro</p>

        <form method="post" id="registro" action="{{ route('Registrar') }}">

            {!! csrf_field() !!}

            <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nombre Completo">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <!--div class="form-group has-feedback{{ $errors->has('sexo') ? ' has-error' : '' }}">
                <select class="form-control" id="sexo" name="sexo">
                    <option value="0"> Seleccione su Sexo</option>
                    @foreach($catsexo as $key)
                    <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                    @endforeach
                </select>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div-->

            
            <div class="form-group has-feedback{{ $errors->has('name_company') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="name_company" value="{{ old('name_company') }}" placeholder="Nombre Empresa">
                <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>

                @if ($errors->has('name_company'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name_company') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('nit') ? ' has-error' : '' }}">
                <input type="nit" class="form-control" name="nit" value="{{ old('nit') }}" placeholder="Nit">
                <span class="glyphicon glyphicon-ok-circle form-control-feedback"></span>

                @if ($errors->has('nit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nit') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('business_name') ? ' has-error' : '' }}">
                <input type="business_name" class="form-control" name="business_name" placeholder="Razon Social">
                <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>

                @if ($errors->has('business_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('business_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="Contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" id="registro_terminos" name="registro_terminos">&nbsp;He leído y estoy de acuerdo con los <a href="#">términos</a> y <a href="#">condiciones  </a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary">Registrarse&nbsp;<i class="fa fa-sign-in"></i></button>
                    <a href="{{ url('/login') }}" class="text-center btn btn-warning"><i class="fa fa-arrow-left"></i>&nbsp;Ya tengo una membresía</a>
                </div>
            </div>
        </form>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('plugins/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('plugins/dist/js/adminlte.min.js') }}"></script>
<!-- iChecked -->
<script src="{{ asset('plugins/plugins/iCheck/icheck.min.js') }}"></script>
<!-- validate -->
<script type="text/javascript" src="{{ asset('plugins/plugins/jQueryValidate/dist/jquery.validate.js') }}"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $("#registro").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 6
      },
      password_confirmation: {
        required: true,
        minlength: 6
      },
      registro_terminos: {
        required: true
      },
      sexo: {
        required: true,
        min: 1
      }
    },
    messages: {
      name: {
        required: "Por favor ingresa tu nombre",
        minlength: jQuery.validator.format("Al menos {0} Caracteres requeridos!")
      },
      email: {
        required: "Por favor ingresa tu email",
        email: "Ingresa un email válido"
      },
      password: {
        required: "Por favor ingresa tu Contraseña",
        minlength: jQuery.validator.format("Al menos {0} Caracteres requeridos!")
      },
      password_confirmation: {
        required: "Por favor confirma la Contraseña",
        minlength: jQuery.validator.format("Al menos {0} Caracteres requeridos!")
      },
      registro_terminos: {
        required: ""
      },
      sexo: {
        required: "Por favor seleccione su sexo",
        min: "Debe seleccionar tu sexo"
      },
    }
  });
</script>
</body>
</html>
