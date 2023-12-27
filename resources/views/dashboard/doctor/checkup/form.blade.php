@extends('dashboard/master')
@section('title', 'Memeriksa Pasien')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Memeriksa Pasien</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Memeriksa Pasien</li>
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
                            <div class="card-body">
                                <div class="row">

                                    {{-- error message validation --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <form
                                            action="{{ $registration->checkup ? route('dashboard.doctor.checkup.update', $registration->id)  : route('dashboard.doctor.checkup',$registration->id)}}"
                                            method="POST">
                                            @csrf
                                            @if ($registration->checkup)
                                                @method('PUT')
                                            @endif
                                            <div class="form-group">
                                                <label for="">Pasien</label>
                                                <input class="form-control" value="{{ $registration->patient->name }}"
                                                    disabled />
                                            </div>

                                            <div class="form-group">
                                                <label for="date">Tanggal Periksa</label>
                                                <input type="date"
                                                    class="form-control rounded-0 @error('date_checkup') is-invalid @enderror"
                                                    id="date_checkup" name="date_checkup"
                                                    value="{{ $registration->checkup?->date_checkup }}"
                                                    placeholder="Tanggal Periksa....">
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Catatan</label>
                                                <textarea name="note" id="" cols="30" rows="3" class="form-control">{{ $registration->checkup?->note }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Obat</label>
                                                <select class="js-example-basic-multiple form-control" name="drugs[]"
                                                    multiple="multiple">
                                                    @foreach ($drugs as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $registration->checkup && in_array($item->id, $registration->checkup->drugDetail->pluck('drug_id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $item->name }} - Rp.
                                                            {{ number_format($item->price) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
