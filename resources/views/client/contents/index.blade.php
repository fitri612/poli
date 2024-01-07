@extends('client.layouts.index')

@section('content')
    <section class="hero-area circle-wrap">
        <div class="circle x1"></div>
        <div class="circle x2"></div>
        <div class="circle x3"></div>
        <div class="circle x4"></div>
        <div class="circle x5"></div>
        <div class="circle x6"></div>
        <div class="circle x7"></div>
        <div class="circle x8"></div>
        <div class="circle x9"></div>
        <div class="circle x10"></div>
        <div class="container">
            <div class="row full-height align-items-center">
                <div class="col-md-6 p-100px-t p-50px-b md-p-10px-b">
                    <h2 class="text-capitalize m-25px-b">Rumah Sakit. <br>Pelayanan Kesehatan Terbaik</h2>
                    <p class="m-25px-b">Melayani dengan sepenuh hati, memberikan pelayanan kesehatan terbaik untuk
                        masyarakat</p>
                    <div class="hero-btn-wrapper">
                        <a href="{{ route('get.register.poli') }}" class="btn btn-default animated-btn">Daftar Sekarang</a>
                    </div>
                </div>
                <div class="col-md-6 p-100px-t p-50px-b md-p-10px-t">
                    <img class="hero-mock" src="{{ asset('assets/img/docter.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="services" class="p-100px-tb sm-p-50px-b">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-4 col-md-6">
                    <div class="service-box text-center p-60px lg-p-40px md-p-30px sm-p-20px m-10px-t m-10px-b">
                        <h4>Poli Umum</h4>
                        <p>Melayani pasien umum yang membutuhkan pelayanan kesehatan secara umum</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box text-center p-60px lg-p-40px md-p-30px sm-p-20px m-10px-t m-10px-b">
                        <h4>Poli Gigi</h4>
                        <p>Melayani pasien yang membutuhkan pelayanan kesehatan gigi</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box text-center p-60px lg-p-40px md-p-30px sm-p-20px m-10px-t m-10px-b">
                        <h4>Poli Kandungan</h4>
                        <p>Melayani pasien yang membutuhkan pelayanan kesehatan kandungan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
