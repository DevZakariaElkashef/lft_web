<!--begin::Page-->
<div class="d-flex flex-row flex-column-fluid page">
	<!--begin::Aside-->
	<!--begin::Aside-->
	<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
		<!--begin::Brand-->
		<div class="brand flex-column-auto" id="kt_brand">
			<!--begin::Logo-->
			<a href="{{route('main')}}" class="brand-logo">
				<img alt="Logo" src="{{asset('assets/media/logo.png')}}" />
			</a>
			<!--end::Logo-->
			<!--begin::Toggle-->
			<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
				<span class="svg-icon svg-icon svg-icon-xl">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<polygon points="0 0 24 0 24 24 0 24" />
							<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
							<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>
			</button>
			<!--end::Toolbar-->
		</div>
		<!--end::Brand-->
		<!--begin::Aside Menu-->
		<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
			<!--begin::Menu Container-->
			<div id="kt_aside_menu" class="aside-menu mb-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
				<!--begin::Menu Nav-->
				<ul class="menu-nav pt-0">
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{route('main')}}" class="menu-link">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="menu-text">{{__('main.home')}}</span>
                        </a>
                    </li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
                                <i class="fas fa-building"></i>
							</span>
							<span class="menu-text">{{ __('main.companies') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								<li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.companies') }}</span>
									</span>
								</li>
                                @can('companies.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('companies.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.companies') }}</span>
									</a>
								</li>
                                @endcan

								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('superagents.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.superagents') }}</span>
									</a>
								</li>

								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('agents.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.agents') }}</span>
									</a>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('drivers.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.drivers') }}</span>
									</a>
								</li>

								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('cars.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.cars') }}</span>
									</a>
								</li>

                                @can('employees.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('employees.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.employees') }}</span>
									</a>
								</li>
                                @endcan
							</ul>
						</div>
					</li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
                                <i class="fas fa-industry"></i>
							</span>
							<span class="menu-text">{{ __('main.factories') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								<li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.factories') }}</span>
									</span>
								</li>
                                @can('factories.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('factories.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.factories') }}</span>
									</a>
								</li>
                                @endcan

                                @can('branches.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('branches.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.branches') }}</span>
									</a>
								</li>
                                @endcan
							</ul>
						</div>
					</li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
                                <i class="fas fa-location"></i>
							</span>
							<span class="menu-text">{{ __('main.cities_and_regions') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								<li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.cities_and_regions') }}</span>
									</span>
								</li>
                                @can('cities.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('citiesAndRegions.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.cities_and_regions') }}</span>
									</a>
								</li>
                                @endcan
							</ul>
						</div>
					</li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
								<i class="fas fa-box"></i>
							</span>
							<span class="menu-text">{{ __('main.containers') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								<li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.containers') }}</span>
									</span>
								</li>
                                @can('containers.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('containers.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.containers') }}</span>
									</a>
								</li>
                                @endcan
							</ul>
						</div>
					</li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
								<i class="fas fa-box"></i>
							</span>
							<span class="menu-text">{{ __('main.services') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								@can('serviceCategories.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('serviceCategories.index') }}" id="serviceCategories-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.serviceCategories') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('services.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('services.index') }}" id="services-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.services') }}</span>
                                    </a>
                                </li>
                                @endcan

								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('financial_custody_agents.index') }}" id="services-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.financial_custody_agents') }}</span>
                                    </a>
                                </li>
							</ul>
						</div>
					</li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
                                <i class="fas fa-clipboard-list"></i>
							</span>
							<span class="menu-text">{{ __('main.bookings') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								<li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.bookings') }}</span>
									</span>
								</li>

                                @can('bookings.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('bookings.index')}}" class="menu-link">
										<span class="menu-text">{{ __('main.bookings') }}</span>
									</a>
								</li>
                                @endcan
							</ul>
						</div>
					</li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
								<i class="fas fa-box"></i>
							</span>
                            <span class="menu-text">{{ __('main.reports') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.reports') }}</span>
									</span>
                                </li>
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{route('reports.daily_reports')}}" class="menu-link">
                                            <span class="menu-text">{{ __('main.daily_reports') }}</span>
                                        </a>
                                    </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="svg-icon menu-icon">
								<i class="fas fa-cog"></i>
							</span>
							<span class="menu-text">{{ __('main.website_setting') }}</span>
							<i class="menu-arrow"></i>
						</a>
						<div class="menu-submenu">
							<i class="menu-arrow"></i>
							<ul class="menu-subnav">
								<li class="menu-item menu-item-parent" aria-haspopup="true">
									<span class="menu-link">
										<span class="menu-text">{{ __('main.website_setting') }}</span>
									</span>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('yards.index') }}" id="yards-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.yards') }}</span>
                                    </a>
                                </li>

                                @can('shippingAgents.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('shippingAgents.index') }}" id="shippingAgents-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.shippingAgents') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('staticPages.index')
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="{{route('staticPages.index')}}" id="static-pages-link" class="menu-link">
										<span class="menu-text">{{ __('main.staticPages') }}</span>
									</a>
								</li>
                                @endcan
                                @can('ourServices.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('ourServices.index') }}" id="our-services-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.ourServices') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('chooseUs.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('chooseUs.index') }}" id="choose-us-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.chooseUs') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('sponsers.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('sponsers.index') }}" id="sponsers-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.sponsers') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('reviews.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('reviews.index') }}" id="reviews-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.reviews') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('settings.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('settings.edit',1) }}" id="settings-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.settings') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('contactUs.index')
                                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ route('contactUs.index') }}" id="Contact-us-link" class="menu-link">
                                        <span class="menu-text">{{ __('main.contactUs') }}</span>
                                    </a>
                                </li>
                                @endcan
							</ul>
						</div>
					</li>
				</ul>
				<!--end::Menu Nav-->
			</div>
			<!--end::Menu Container-->
		</div>
		<!--end::Aside Menu-->
	</div>
	<!--end::Aside-->
	<!--begin::Wrapper-->
	<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

		<!--begin::Header-->
		<div id="kt_header" class="header header-fixed">
			<!--begin::Container-->
			<div class="container-fluid d-flex align-items-stretch justify-content-between">
				<!--begin::Header Menu Wrapper-->
				<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
					<!--begin::Header Menu-->
					<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
						<!--begin::Header Nav-->
						<ul class="menu-nav">
						</ul>
						<!--end::Header Nav-->
					</div>
					<!--end::Header Menu-->
				</div>
				<!--end::Header Menu Wrapper-->
				<!--begin::Topbar-->
				<div class="topbar">
					<!--begin::User-->
					<div class="dropdown">
						<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
							<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
								<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
								<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ auth()->user()->name }}</span>
								<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
									<span class="symbol-label font-size-h5 font-weight-bold">A</span>
								</span>
							</div>
						</div>
						<div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
							<ul class="navi navi-hover py-4">
								<!--begin::Item-->
								<li class="navi-item">
                                    <a class="dropdown-item navi-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        <span class="navi-text">{{ __('Logout') }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
								</li>
							</ul>
						</div>
					</div>
					<!--end::User-->
				</div>
				<!--end::Topbar-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Header-->

		<!--begin::Content-->
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
			@yield("content")
		</div>
		<!--end::Content-->

		<!--begin::Footer-->
		<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
			<!--begin::Container-->
			<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
				<!--begin::Copyright-->
				<div class="text-dark order-2 order-md-1">
					<span class="text-muted font-weight-bold mr-2">2023©</span>
					<a href="{{route('main')}}" class="text-dark-75 text-hover-primary">LeaderForTrans</a>
				</div>
				<!--end::Copyright-->
				<!--begin::Nav-->
				<div class="nav nav-dark">
				</div>
				<!--end::Nav-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Footer-->
	</div>
	<!--end::Wrapper-->

</div>


<script>
    var url = window.location;
    // for treeview
    $('ul.menu-subnav .menu-item a').filter(function() {
        return this.href == url;
    }).parentsUntil(".menu-parent-menu > .menu-item a").addClass('active menu-item-open');
</script>

<style>
    .aside-menu .menu-nav {
        margin-top: 2rem;
    }
</style>