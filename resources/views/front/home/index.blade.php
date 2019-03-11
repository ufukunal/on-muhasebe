@extends('layouts.app')
@section('content')
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Panel</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Panel</a>
                </li>
                <li class="breadcrumb-item active">Anasayfa</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->
    <!-- =================================== -->
    <!-- Different data widgets ============ -->
    <!-- =================================== -->
    <div class="widget-list row">
        <!-- /.widget-holder -->
        <div class="widget-holder widget-sm widget-border-radius col-md-3">
            <div class="widget-bg">
                <div class="widget-heading bg-purple"><span class="widget-title my-0 color-white fs-12 fw-600">Gelir Faturası</span></i>
                </div>
                <!-- /.widget-heading -->
                <div class="widget-body">
                    <div class="counter-w-info">
                        <div class="counter-title color-color-scheme"><span class="counter">{{\App\Fatura::getGelirCount()}}</span> Adet</div>
                    </div>
                    <!-- /.counter-w-info -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
        <div class="widget-holder widget-sm widget-border-radius col-md-3">
            <div class="widget-bg">
                <div class="widget-heading bg-purple"><span class="widget-title my-0 color-white fs-12 fw-600">Gider Faturası</span></i>
                </div>
                <!-- /.widget-heading -->
                <div class="widget-body">
                    <div class="counter-w-info">
                        <div class="counter-title color-color-scheme"><span class="counter">{{\App\Fatura::getGiderCount()}}</span> Adet</div>
                    </div>
                    <!-- /.counter-w-info -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
        <div class="widget-holder widget-sm widget-border-radius col-md-3">
            <div class="widget-bg">
                <div class="widget-heading bg-purple"><span class="widget-title my-0 color-white fs-12 fw-600">Toplam Ödeme</span></i>
                </div>
                <!-- /.widget-heading -->
                <div class="widget-body">
                    <div class="counter-w-info">
                        <div class="counter-title color-color-scheme"><span class="counter">{{\App\Rapor::getOdeme()}}</span> TL</div>
                    </div>
                    <!-- /.counter-w-info -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
        <div class="widget-holder widget-sm widget-border-radius col-md-3">
            <div class="widget-bg">
                <div class="widget-heading bg-purple"><span class="widget-title my-0 color-white fs-12 fw-600">Toplam Tahsilat</span></i>
                </div>
                <!-- /.widget-heading -->
                <div class="widget-body">
                    <div class="counter-w-info">
                        <div class="counter-title color-color-scheme"><span class="counter">{{\App\Rapor::getTahsilat()}}</span> TL</div>
                    </div>
                    <!-- /.counter-w-info -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
    </div>
    <!-- /.widget-list -->
    <hr>
    <div class="widget-list row">
        <div class="widget-holder widget-full-height col-md-12">
            <div class="widget-bg">
                <div class="widget-heading widget-heading-border">
                    <h5 class="widget-title">Son Yapılan İşlemler</h5>
                    <!-- /.widget-actions -->
                </div>
                <!-- /.widget-heading -->
                <div class="widget-body">
                    <table class="widget-latest-transactions">
                        @foreach($logger as $k => $v)
                        <tr>
                            <td class="single-user-details">
                                <a class="single-user-name" href="#">{{$v['text']}}</a>
                                <small>{{$v['created_at']}}</small>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <!-- /.widget-latest-transactions -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
        <!-- /.widget-holder -->
    </div>
@endsection