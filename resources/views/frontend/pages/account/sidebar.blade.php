<div class="dashboard-menu">
    <ul class="nav flex-column" role="tablist">
        <li class="nav-item ">
            <a class="nav-link {{ Request::routeIs('account-dash') ? 'active' : '' }}"  href="{{ route('account-dash') }}" ><i class="ti-view-grid mr-2"></i>Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('frontend.pages.account.order', 'frontend.pages.account.detailorder') ? 'active' : '' }}"  href="{{ route('frontend.pages.account.order') }}" role="tab"  ><i class="ti-bag mr-2"></i>Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('account-address', 'address.get') ? 'active' : '' }} "  href="{{ route('account-address') }}" ><i class="ti-location-pin mr-2"></i>My Address</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('account-my') ? 'active' : '' }}"  href="{{ route('account-my') }}"><i class="ti-settings mr-2"></i>Account details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="page-login.html"><i class="ti-power-off mr-2"></i>Logout</a>
        </li>
    </ul>
</div>