<div class="vertical-menu">
	<!-- LOGO -->
	<div class="navbar-brand-box">
		<a href="{{ route('app') }}" class="logo">
			<span class="logo-sm">
				<img src="{{ url('assets/images/logo-sm.png') }}" alt="logo" height="22">
			</span>
			<span class="logo-lg">
				<img src="{{ url('assets/images/logo/logoWhite.png') }}" alt="logo" height="22">
			</span>
		</a>
	</div>
	<button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
		<i class="fa fa-fw fa-bars"></i>
	</button>
	<div data-simplebar class="sidebar-menu-scroll">
		<div id="sidebar-menu">
			<ul class="metismenu list-unstyled" id="side-menu">

				<li class="mm-active itemMenu" item="dashboard" url="{{ route('dashboard') }}">
					<a id="link-dashboard" class="active" href="#">
						<i class="icon nav-icon" data-feather="home"></i>
						<span class="menu-item">Dashboard</span>
					</a>
				</li>

				<!----------------------------TICKETS----------------------->

				<li class="itemMenu" item="ticket" url="{{ route('ticket') }}">
					<a id="link-ticket" class="" href="#">
						<i class="icon nav-icon" data-feather="clipboard"></i>
						<span class="menu-item">Tickets</span>
					</a>
				</li>

				<!----------------------------BILLING----------------------->

                @if (session('role') == 'admin')

				<li class="menu-title" data-key="t-applications">BILLING</li>

				<li class="itemMenu" item="invoices" url="{{ route('invoices') }}">
					<a id="link-invoices" class="" href="#">
						<i class="icon nav-icon" data-feather="file"></i>
						<span class="menu-item">Invoices</span>
					</a>
				</li>
				<li class="itemMenu" item="payments" url="{{ route('payments') }}">
					<a id="link-payments" class="" href="#">
						<i class="icon nav-icon" data-feather="credit-card"></i>
						<span class="menu-item">Payments</span>
					</a>
				</li>
				{{--<li class="itemMenu" item="contracts" url="{{ route('contracts') }}">
					<a id="link-contracts" class="" href="#">
						<i class="icon nav-icon" data-feather="clipboard"></i>
						<span class="menu-item">Contracts</span>
					</a>
				</li>--}}

                @endif

				<!----------------------------ACCOUNT----------------------->

				<li class="menu-title" data-key="t-applications">Account</li>

				<li class="itemMenu" item="profile" url="{{ route('profile') }}">
					<a id="link-profile" class="" href="#">
						<i class="icon nav-icon" data-feather="user"></i>
						<span class="menu-item">Profile</span>
					</a>
				</li>
				<li class="itemMenu" item="contacts" url="{{ route('contacts') }}">
					<a id="link-contacts" class="" href="#">
						<i class="icon nav-icon" data-feather="users"></i>
						<span class="menu-item">Contacts</span>
					</a>
				</li>

				<!----------------------------API----------------------->

                @if (session('role') == 'admin')

				<li class="menu-title" data-key="t-applications">API</li>

				<li class="itemMenu" item="settings" url="{{ route('settings') }}">
					<a id="link-settings" class="" href="#">
						<i class="icon nav-icon" data-feather="settings"></i>
						<span class="menu-item">Settings</span>
					</a>
				</li>

                    @if (session('accessAPI') == 1)

                    <li class="itemMenu" item="logs" url="{{ route('logs') }}">
                        <a id="link-logs" class="" href="#">
                            <i class="icon nav-icon" data-feather="file"></i>
                            <span class="menu-item">Logs</span>
                        </a>
                    </li>

                    @endif

                @endif

			</ul>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {

		$('.itemMenu').on('click', function (event) {

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

			let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

			let item = $(this).attr('item');
			let url = $(this).attr('url');

			$('.itemMenu').each(function() { // REMOVE CLASS ACTIVE ON CLICK ALL ITEM-MENU
				$(this).removeClass('mm-active');
				$('#link' + item).removeClass('active');
			});

			$(this).addClass('mm-active'); // SET CLASS ACTIVE ON CLICK TO SELECT ITEM-MENU
			$('#link' + item).addClass('active');

			$('.itemSubMenu').each(function() {
				$(this).removeClass('mm-active');
				let sub = $(this).attr('sub');
				$('#' + sub).removeClass('active');
			});

			$.ajax({

				type: "post",
				url: url,
				dataType: "html",

			}).done(function(htmlResponse) {

				spinner.stop();
				$('#main-container').html(htmlResponse);

			}).fail(function(error) {

				spinner.stop();

				Swal.fire({
					title: 'Session Expired',
					showClass: {popup: 'animate__animated animate__fadeInDown'},
					hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					position: 'top-end',
					icon: 'error',
					showConfirmButton: false,
					timer: 1500
				});

				window.location.reload();
			});
		});

	});
</script>
