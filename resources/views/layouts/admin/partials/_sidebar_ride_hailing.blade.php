<div id="sidebarMain" class="d-none">
    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                @php($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first())
                <a class="navbar-brand" href="{{ route('admin.ride-hailing.dashboard') }}" aria-label="Zaqoota">
                    <img class="navbar-brand-logo initial--36 onerror-image"
                        data-onerror-image="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}"
                        src="{{ \App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value ?? '', $store_logo?->storage[0]?->value ?? 'public', 'favicon') }}"
                        alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36 onerror-image"
                        data-onerror-image="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}"
                        src="{{ \App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value ?? '', $store_logo?->storage[0]?->value ?? 'public', 'favicon') }}"
                        alt="Logo">
                </a>

                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <div class="navbar-nav-wrap-content-left">
                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip" data-placement="right" title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"></i>
                    </button>
                </div>
            </div>

            <div class="navbar-vertical-content bg--005555" id="navbar-vertical-content">
                <form autocomplete="off" class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input autocomplete="false" name="qq" type="text" class="form-control form--control"
                            placeholder="{{ translate('Search Menu...') }}" id="search">
                        <div id="search-suggestions" class="flex-wrap mt-1"></div>
                    </div>
                </form>

                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/ride-hailing') ? 'active' : '' }}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.ride-hailing.dashboard') }}" title="{{ translate('messages.Dashboard') }}"><i class="tio-home-vs-1-outlined nav-icon"></i><span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.Dashboard') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <small class="nav-subtitle">{{ translate('messages.Ride Management') }}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/ride-hailing/riders*') ? 'active' : '' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.ride-hailing.riders.index') }}" title="{{ translate('messages.Ride Riders') }}"><i class="tio-account-circle nav-icon"></i><span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.Ride Riders') }}</span></a></li>
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/ride-hailing/vehicles*') ? 'active' : '' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.ride-hailing.vehicles.index') }}" title="{{ translate('messages.Ride Vehicles') }}"><i class="tio-car nav-icon"></i><span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.Ride Vehicles') }}</span></a></li>
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/ride-hailing/categories*') ? 'active' : '' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.ride-hailing.categories.index') }}" title="{{ translate('messages.Ride Categories') }}"><i class="tio-category nav-icon"></i><span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.Ride Categories') }}</span></a></li>
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/ride-hailing/fares*') ? 'active' : '' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.ride-hailing.fares.index') }}" title="{{ translate('messages.Zone Ride Pricing') }}"><i class="tio-money nav-icon"></i><span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.Zone Ride Pricing') }}</span></a></li>
                    <li class="nav-item"><small class="nav-subtitle">{{ translate('messages.Configuration') }}</small><small class="tio-more-horizontal nav-subtitle-replacer"></small></li>
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/ride-hailing/setup*') ? 'active' : '' }}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{ route('admin.ride-hailing.setup') }}"
                            title="{{ translate('messages.Ride Hailing Setup') }}">
                            <i class="tio-settings nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{ translate('messages.Ride Hailing Setup') }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item py-5"></li>
                    @includeIf('layouts.admin.partials._logout_modal')
                </ul>
            </div>
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none"></div>

@push('script_2')
<script>
    $(window).on('load', function () {
        const activeItem = $('.navbar-vertical-content li.active');
        if (activeItem.length) {
            $('.navbar-vertical-content').animate({
                scrollTop: activeItem.offset().top - 150
            }, 10);
        }
    });

    $(document).ready(function () {
        const searchInput = $('#search');
        const menuItems = $('#navbar-vertical-content li');

        searchInput.on('input', function () {
            const keyword = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            menuItems.each(function () {
                $(this).toggle($(this).text().replace(/\s+/g, ' ').toLowerCase().includes(keyword));
            });
        });
    });
</script>
@endpush
