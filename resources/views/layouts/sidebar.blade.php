<!-- Sidebar Menu -->
<nav class="sidebar-nav">
    <ul class="nav in side-menu">

        @if(\App\UserPermission::getMyControl(0))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-list"></i> <span class="hide-menu">Müşteriler</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('musteriler.index')}}">Müşteri Listesi</a>
                </li>
                <li><a href="{{route('musteriler.create')}}">Yeni Müşteri Ekle</a>
                </li>
            </ul>
        </li>
        @endif
        @if(\App\UserPermission::getMyControl(1))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-plus"></i> <span class="hide-menu">Glr. & Gdr. Kalemi</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('kalem.index')}}">Glr. & Gdr. Kalemi Listesi</a>
                </li>
                <li><a href="{{route('kalem.create')}}">Glr. & Gdr. Kalemi Ekle</a>
                </li>
            </ul>
        </li>
        @endif
        @if(\App\UserPermission::getMyControl(2))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-folder"></i> <span class="hide-menu">Faturalar</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('fatura.index')}}">Fatura Listesi</a>
                </li>
                <li><a href="{{route('fatura.store', ['type' => 0])}}">Yeni Gelir Faturası Ekle</a>
                </li>
                <li><a href="{{route('fatura.store', ['type' => 1])}}">Yeni Gider Faturası Ekle</a>
                </li>
            </ul>
        </li>
        @endif
        @if(\App\UserPermission::getMyControl(3))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-star"></i> <span class="hide-menu">Ürünler</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('urun.index')}}">Ürün Listesi</a>
                </li>
                <li><a href="{{route('urun.create')}}">Yeni Ürün Ekle</a>
                </li>
            </ul>
        </li>
        @endif
        @if(\App\UserPermission::getMyControl(4))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-user"></i> <span class="hide-menu">Banka</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('banka.index')}}">Banka Listesi</a>
                </li>
                <li><a href="{{route('banka.create')}}">Yeni Banka Ekle</a>
                </li>
            </ul>
        </li>
        @endif
        @if(\App\UserPermission::getMyControl(5))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-user"></i> <span class="hide-menu">İşlemler</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('islem.index')}}">İşlem Listesi</a>
                </li>
                <li><a href="{{route('islem.create', ['type' => 0])}}">Ödeme Yap</a>
                </li>
                <li><a href="{{route('islem.create', ['type' => 1])}}">Tahsilat Al</a>
                </li>
            </ul>
        </li>
        @endif
        @if(\App\UserPermission::getMyControl(6))
        <li class="menu-item-has-children">
            <a href="javascript:void(0);">
                <i class="list-icon feather feather-user"></i> <span class="hide-menu">Kullanıcı</span>
            </a>
            <ul class="list-unstyled sub-menu">
                <li><a href="{{route('user.index')}}">Kullanıcı Listesi</a>
                </li>
                <li><a href="{{route('user.create')}}">Kullanıcı Ekle</a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
    <!-- /.side-menu -->
</nav>
<!-- /.sidebar-nav -->