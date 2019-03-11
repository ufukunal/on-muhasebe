@extends('layouts.app')
@section('content')
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Müşteriler</h6>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a>
                </li>
                <li class="breadcrumb-item active">Müşteriler</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Yeni Müşteri Ekle</a>
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
                        <form action="{{route('musteriler.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="l16">Müşteri Resmi</label>
                                    <input id="l16" class="form-control" name="photo" type="file">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="" class="col-form-label">Müşteri Tipi</label>
                                    <div>
                                        <input type="radio" checked class="change-customerType" name="musteriTipi" value="0"> Bireysel
                                    </div>
                                    <div>
                                        <input type="radio" class="change-customerType" name="musteriTipi" value="1"> Kurumsal
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row firma--area" style="display: none">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="l0">Firma Adı</label>
                                    <input class="form-control" name="firmaAdi" placeholder="Firma Adı Giriniz" id="l0"  type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="l0">Vergi Numarası</label>
                                    <input class="form-control" name="vergiNumarasi" id="l0" placeholder="Vergi Numarası Giriniz" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="l0">Vergi Dairesi</label>
                                    <input class="form-control" name="vergiDairesi" id="l0" placeholder="Vergi Dairesi Giriniz" type="text">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="l0">Adı</label>
                                    <input class="form-control" name="ad" id="l0" placeholder="Müşteri Adı Giriniz" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="l0">Soyadı</label>
                                    <input class="form-control" name="soyad" id="l0" placeholder="Müşteri Soyadı Giriniz" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="l0">Doğum Tarihi</label>
                                    <input class="form-control" name="dogumTarih" id="l0"  type="date">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="l0">TC</label>
                                    <input class="form-control" name="tc" id="l0" placeholder="Müşteri TC Giriniz" type="text">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="l0">Adres</label>
                                    <input class="form-control" name="adres" placeholder="Adres Giriniz" id="l0"  type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="l0">Telefon</label>
                                    <input class="form-control" name="telefon" id="l0" placeholder="Telefon Numarası Giriniz" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="l0">E-Posta</label>
                                    <input class="form-control" name="email" id="l0" placeholder="E-Posta Adresi Giriniz" type="text">
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
<script>
    $(".change-customerType").click(function () {
       var value = $(this).val();
       if(value == 1){
           $(".firma--area").show();
       } else {
           $(".firma--area").hide();
       }
    });
</script>
@endsection