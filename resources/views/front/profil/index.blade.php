@extends('layouts.app')
@section('content')
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Profil</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Panel</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Anasayfa</a>
                </li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Buy Now</a>
            </div>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->
    <!-- =================================== -->
    <!-- Different data widgets ============ -->
    <!-- =================================== -->
    <div class="widget-list">
        <div class="row">
            <!-- Tabs Content -->
            <div class="col-12 col-md-12 mr-b-30">
                <ul class="nav nav-tabs contact-details-tab">
                    <li class="nav-item"><a href="#profile-tab-bordered-1" class="nav-link active" data-toggle="tab">Profil Düzenle</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div role="tabpanel" class="tab-pane active" id="profile-tab-bordered-1">
                        <div class="contact-details-profile">
                            <h5 class="mr-b-20">Profil Düzenle</h5>
                            <form action="{{route('profil.update')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                            <div class="row">
                                <!-- /.col-md-6 -->
                                <div class="col-md-12">
                                    <div class="contact-details-cell"><small class="heading-font-family fw-500">Profil Resmi</small>
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                    <!-- /.contact-details-cell -->
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-details-cell"><small class="heading-font-family fw-500">Ad Soyad</small>
                                        <input type="text" class="form-control" name="name" value="{{Auth::user()->name }}">
                                    </div>
                                    <!-- /.contact-details-cell -->
                                </div>
                                <!-- /.col-md-6 -->
                                <div class="col-md-12">
                                    <div class="contact-details-cell"><small class="heading-font-family fw-500">E-Posta</small>
                                        <input type="email" class="form-control" name="email" value="{{Auth::user()->emai}}">
                                    </div>
                                    <!-- /.contact-details-cell -->
                                </div>
                                <!-- /.col-md-6 -->
                                <div class="col-md-12">
                                    <div class="contact-details-cell"><small class="heading-font-family fw-500">Şifre</small>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <!-- /.contact-details-cell -->
                                </div>
                                <!-- /.col-md-6 -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-rounded">Kaydet</button>
                                    <!-- /.contact-details-cell -->
                                </div>
                            </div>
                            </form>
                            <!-- /.row -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.col-sm-8 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.widget-list -->
@endsection