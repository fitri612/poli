<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Dokter</title>

    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gredients/purple.css') }}">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg mb-5">
        <a class="navbar-brand" href="/">Home</a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Data Dokter</h1>
                <div class="card">

                    <div class="card-body">
                        <table class="table table-datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokter</th>
                                    <th>Poli</th>
                                    <th>No Telepon</th>
                                    <th>Jadwal</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctor as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->poli->name }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>
                                            @foreach ($service as $item2)
                                                @if ($item2->doctor_id == $item->id)
                                                    {{ $item2->day == 1 ? 'Senin' : '' }}
                                                    {{ $item2->day == 2 ? 'Selasa' : '' }}
                                                    {{ $item2->day == 3 ? 'Rabu' : '' }}
                                                    {{ $item2->day == 4 ? 'Kamis' : '' }}
                                                    {{ $item2->day == 5 ? 'Jumat' : '' }}
                                                    {{ $item2->day == 6 ? 'Sabtu' : '' }}
                                                    {{ $item2->day == 7 ? 'Minggu' : '' }}
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($service as $item2)
                                                @if ($item2->doctor_id == $item->id)
                                                    {{ $item2->start_time }} - {{ $item2->end_time }}
                                                @endif
                                            @endforeach

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
