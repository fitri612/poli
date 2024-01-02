@extends('dashboard/master')
@section('title', 'Riwayat Periksa Pasien')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Riwayat Periksa Pasien</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Riwayat Periksa Pasien</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>
                                                Nomor Antrian
                                            </th>
                                            <td>
                                                {{ $checkup->queue_number }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Jadwal
                                            </th>
                                            <td>
                                                Hari : {{ $checkup->schedule->day == 1 ? 'Senin' : '' }}
                                                {{ $checkup->schedule->day == 2 ? 'Selasa' : '' }}
                                                {{ $checkup->schedule->day == 3 ? 'Rabu' : '' }}
                                                {{ $checkup->schedule->day == 4 ? 'Kamis' : '' }}
                                                {{ $checkup->schedule->day == 5 ? 'Jumat' : '' }}
                                                {{ $checkup->schedule->day == 6 ? 'Sabtu' : '' }}
                                                {{ $checkup->schedule->day == 7 ? 'Minggu' : '' }}
                                                <br>
                                                Jam : {{ $checkup->schedule->start_time }} s/d
                                                {{ $checkup->schedule->end_time }}
                                                <br>
                                                Tanggal : {{ Carbon\Carbon::parse($checkup->created_at)->format('d F Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Nama Dokter
                                            </th>
                                            <td>
                                                {{ $checkup->schedule->doctor->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Nama Pasien
                                            </th>
                                            <td>
                                                {{ $checkup->patient->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Nomor Rekam Medis
                                            </th>
                                            <td>
                                                {{ $checkup->patient->rm_number }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Poli
                                            </th>
                                            <td>
                                                {{ $checkup->schedule->doctor->poli->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Keluhan
                                            </th>
                                            <td>
                                                {{ $checkup->complaint }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Status
                                            </th>
                                            <td>
                                                @php
                                                    // ambil hari ini apakah senin, selasa, rabu, dst
                                                    $day = \Carbon\Carbon::now()->format('N');
                                                    $timeNow = \Carbon\Carbon::now()->format('H:i:s');
                                                    $today = \Carbon\Carbon::now()->format('Y-m-d');
                                                @endphp
                                                @if ($checkup->status == 'waiting')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif($checkup->created_at->format('Y-m-d') != $today && $checkup->status == 'waiting')
                                                    <span class="badge badge-danger">Telat</span>
                                                @elseif($checkup->status == 'done')
                                                    <span class="badge badge-success">Selesai</span>
                                                @endif

                                                @if ($checkup->status == 'waiting')
                                                    @if ($checkup->schedule->day == $day)
                                                        @if ($timeNow >= $checkup->schedule->start_time && $timeNow <= $checkup->schedule->end_time)
                                                            <span class="badge badge-primary">
                                                                Saatnya Periksa
                                                            </span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    @if ($checkup->status == 'done' && $checkup->checkup != null)
                                        <h3>Hasil Periksa</h3>
                                        <h6>
                                            Diperiksa pada tanggal :
                                            {{ Carbon\Carbon::parse($checkup->checkup->date_checkup)->format('d F Y') }}
                                        </h6>
                                        <br>
                                        <h5>Obat</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga</th>
                                                </tr>
                                                @if ($checkup->checkup?->drugDetail == null)
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @else
                                                    @foreach ($checkup->checkup->drugDetail as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->drug->name }}</td>
                                                            <td>1</td>
                                                            <td>
                                                                Rp.
                                                                {{ number_format($item->drug->price, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </thead>
                                        </table>
                                        <br>
                                        <br>
                                        <h5>Catatan</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Catatan dari Dokter</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $checkup->checkup?->note }}
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <br>
                                        <h5>Total Pembayaran</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>
                                                    Biaya Poli
                                                </th>
                                                <td>
                                                    Rp. 150.000
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Biaya Obat
                                                </th>
                                                <td>
                                                    Rp.
                                                    {{ number_format($checkup->checkup?->total_payment - 150000, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Total
                                                </th>
                                                <td>
                                                    Rp. {{ number_format($checkup->checkup?->total_payment, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
