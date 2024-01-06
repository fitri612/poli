<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poli Klinik BK | Pendaftaran Poli</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">

    <div class="login-box" style="width: 450px !important">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h4>Poli Klinik </h4>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Mendaftar Poli</p>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Whoops!</strong> Terjadi kesalahan input data yang anda masukan.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true"> &times; </span>
                        </button>
                    </div>
                @endif

                @if (session('queue_number'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Selamat!</strong> Anda telah terdaftar<br>
                        Nomor antrian anda adalah <strong>{{ session('queue_number') }}</strong>
                        <p class="mt-3">
                            Pastikan anda mengingat nomor antrian anda, karena nomor antrian ini akan digunakan untuk
                            melakukan poli klinik
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true"> &times; </span>
                        </button>
                    </div>
                @endif
                <form action="{{ route('register.poli') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('rm_number') is-invalid  @enderror"
                            name="rm_number" value="{{ old('rm_number') }}" placeholder="Nomor Rekam Medis">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="poli_id" id="poli_id" class="form-control">
                            <option value="">-- Pilih Poli --</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}">
                                    {{ $poli->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <select name="schedule_id" id="schedule_id" class="form-control">
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach ($schedules as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->doctor->name }} - Poli {{ $item->doctor->poli->name }}
                                    ({{ $item->day == 1 ? 'Senin' : '' }}
                                    {{ $item->day == 2 ? 'Selasa' : '' }}
                                    {{ $item->day == 3 ? 'Rabu' : '' }}
                                    {{ $item->day == 4 ? 'Kamis' : '' }}
                                    {{ $item->day == 5 ? 'Jumat' : '' }}
                                    {{ $item->day == 6 ? 'Sabtu' : '' }}
                                    {{ $item->day == 7 ? 'Minggu' : '' }}
                                    - {{ $item->start_time }} s/d {{ $item->end_time }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <textarea id="" cols="30" rows="3" class="form-control" name="complaint" placeholder="Keluhan">{{ old('complaint') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Daftar Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
