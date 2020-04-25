<nav class="navbar navbar-expand-lg">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('view.pageName.index') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#cart">{{ __('view.pageName.cart') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#products">{{ __('view.pageName.products') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#orders">{{ __('view.pageName.orders') }}</a>
            </li>
        </ul>

        <div>
            <span class="nav-item logout" style="display: none;">
                <a class="nav-link" href="#logout">{{ __('view.logout') }}</a>
            </span>
            <span class="nav-item login" style="display: none;">
                <a class="nav-link" href="#login">{{ __('view.login') }}</a>
            </span>
        </div>
    </div>
</nav>
