<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poli Klinik BK | Pendaftaran Anggota</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h4>Pendaftaran Berhasil 🥳</h4>
            </div>
            <div class="card-body text-center">
                <p class="login-box-msg">Selamat anda telah terdaftar sebagai anggota rekam medis</p>

                Nomor rekam medis anda adalah <br>
                <h2 class="text-center text-success">
                    {{ $no_rm }}
                </h2>

                <p>
                    Pastikan anda mengingat nomor rekam medis anda, karena nomor rekam medis ini akan digunakan untuk
                    melakukan pendaftaran kunjungan ke poli klinik
                </p>
                <br>
                <br>
                <a href="/">
                    <button type="button" class="btn btn-primary btn-block btn-flat">Kembali ke halaman utama</button>
                </a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('notification/sweetalert')


</body>

</html>
