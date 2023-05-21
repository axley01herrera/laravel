<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('app') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ url('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ url('assets/images/logo-dark.png') }}" alt="" height="22">
                    </span>
                </a>
                <a href="{{ route('app') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ url('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ url('assets/images/logo-light.png') }}" alt="" height="22">
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div class="d-flex">

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-sm" data-feather="bell"></i>
                    <span id="flag-not" class="noti-dot bg-danger" hidden></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications </h5>
                            </div>
                        </div>
                    </div>
                    <!-- MAIN NOTIFICATIONS -->
                    <div id="main-notification" data-simplebar style="max-height: 250px;">

                    </div>
                    <div class="p-2 border-top d-grid">
                        <!--<a class="btn btn-sm btn-link font-size-14 btn-block text-center"
                            href="javascript:void(0)">
                            <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                        </a>-->
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ url('assets/images/users/avatar.png') }}"
                        alt="Header Avatar">
                    <span class="ms-2 d-none d-sm-block user-item-desc">
                        <!-- USER -->
                        <span id="span-topBarUserName" class="user-name"></span>
                        <!-- EMAIL -->
                        <span id="span-topBarUserEmail" class="user-sub-title"></span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 bg-primary border-bottom">
                        <!-- USER -->
                        <h6 id="topBarUserName" class="mb-0 text-white">{{ session('user') }}</h6>
                        <!-- EMAIL -->
                        <p id="topBarUserEmail" class="mb-0 font-size-11 text-white-50 fw-semibold"></p>
                    </div>
                    <a id="top-profile" class="dropdown-item" href="#">
                        <i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i>
                        <span class="align-middle">Profile</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <!-- LOG OUT -->
                    <a class="dropdown-item" href="{{ route('logOut') }}">
                        <i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i>
                        <span class="align-middle">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    $(document).ready(function () {
        $('#top-profile').on('click', function (event) { // GO TO PROFILE
            event.preventDefault();
            let accessAPI = '<?php echo session('accessAPI')?>';
            if (accessAPI === '1'){
                try {
                    globalThis.chartOrder.destroy();
                    console.log('chartOrder is defined');
                } catch(e) {
                    console.log('chartOrder is not defined');
                }
            }
            $('#link-profile').trigger('click');
        });
    });
</script>
