<div class="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="d-flex justify-content-between">
            <div class="logo">
                <a href="index.html"><img src="{{asset('Backend/images/logo/logo.png')}}" alt="Logo" srcset=""></a>
            </div>
            <div class="toggler">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item active ">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item  has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-stack"></i>
                    <span>Product</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item ">
                        <a href="#">Products</a>
                    </li>
                    <li class="submenu-item ">
                        <a href="component-badge.html">Sizes</a>
                    </li>
                    <li class="submenu-item ">
                        <a href="#">Colors</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item ">
                <a href="{{URL::to('/all-category-product')}}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Danh Mục</span>
                </a>
            </li>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>