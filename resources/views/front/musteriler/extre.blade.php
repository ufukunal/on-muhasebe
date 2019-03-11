@extends('layouts.app')
@section('content')
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Müşteri Extresi</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Panel</a>
                </li>
                <li class="breadcrumb-item active">Müşteri Extresi</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">{{\App\Musteriler::getPublicName($data[0]['id'])}}</a>
            </div>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->
    <!-- =================================== -->
    <div class="widget-list">
        <div class="row">
            <!-- User Summary -->
            <div class="col-12 col-md-12 widget-holder widget-full-content">
                <div class="widget-bg">
                    <div class="widget-body clearfix">
                        <div class="widget-user-profile">
                            <figure class="profile-wall-img">
                                <img src="{{ asset('assets/demo/user-widget-bg.jpeg') }}" alt="User Wall">
                            </figure>
                            <div class="profile-body">
                                <figure class="profile-user-avatar thumb-md">
                                    <img src="{{asset(\App\Musteriler::getPhoto($data[0]['id']))}}" alt="User Wall">
                                </figure>
                                <h6 class="h3 profile-user-name">{{\App\Musteriler::getPublicName($data[0]['id'])}}</h6>
                                <small class="profile-user-address">@if($data[0]['msuteriTipi'] == 0) Bireysel @else Kurumsal @endif</small>
                                <!-- /.profile-user-description -->
                                <div class="mb-5">
                                    <a href="{{route('musteriler.edit', ['id' => $data[0]['id']])}}" class="btn btn-outline-color-scheme btn-rounded btn-lg px-5 border-thick text-uppercase mr-2 mr-0-rtl ml-2-rtl fw-700 fs-11 heading-font-family">Müşteriyi Düzenle</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.widget-user-profile -->

                    </div>
                    <!-- /.widget-body -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>İşlem</th>
                                        <th>Fiyat</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($viewData as $k => $v)
                                        <tr>
                                            <th>
                                                @if($v['uType'] == "fatura")
                                                    @if($v['type'] == FATURA_GELIR)
                                                        Gelir Faturası
                                                    @else
                                                        Gider Faturası
                                                    @endif
                                                @else
                                                    @if($v['type'] == ISLEM_ODEME)
                                                        Ödeme
                                                    @else
                                                        Tahsilat
                                                    @endif
                                                @endif
                                            </th>
                                            <th>{{$v['fiyat']}}</th>
                                            <th>{{$v['tarih']}}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.widget-bg -->
            </div>
            <!-- /.widget-holder -->
            <!-- Tabs Content -->
            <!-- /.col-sm-8 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.widget-list -->
@endsection