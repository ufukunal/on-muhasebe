@extends('layouts.app')
@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Ürün</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a>
                </li>
                <li class="breadcrumb-item active">Ürün</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Yeni Ürün Ekle</a>
            </div>
        </div>
        <!-- /.page-title-right -->
    </div>
    @if(session("status"))
        <div class="row" style="margin-top: 10px">
            <div class="col-md-12">
                <div class="alert alert-success">{{ session('status') }}</div>
            </div>
        </div>
    @endif
    <div class="widget-list">
        <div class="row">
            <div class="col-md-12 widget-holder">
                <div class="widget-bg">
                    <div class="widget-body clearfix">
                        <form action="{{route('urun.store')}}" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="form-group row firma--area">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="l0">Ad</label>
                                    <input class="form-control" required name="urunAdi" placeholder="Ürün Adı Giriniz" id="l0"  type="text">
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label" for="l0">Kalem Seçiniz</label>
                                    <select required name="kalemId" class="m-b-10 form-control" data-placeholder="Choose" data-toggle="select2">
                                        <option value="0">Kalem Seçiniz</option>
                                        @foreach(\App\Kalem::all() as $k => $v)
                                            <option value="{{$v['id']}}">{{ $v['ad'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="alisFiyati">Alış Fiyatı</label>
                                    <input type="text" class="form-control" name="alisFiyati">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="satisFiyati">Satış Fiyatı</label>
                                    <input type="text" class="form-control" name="satisFiyati">
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="form-group row">
                                    <div class="col-md-12 ml-md-auto btn-list">
                                        <button class="btn btn-primary btn-rounded" type="submit">Kaydet</button>
                                    </div>
                                </div>
                            </div>



                        </form>
                    </div>
                    <!-- /.widget-body -->
                </div>
                <!-- /.widget-bg -->
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endsection