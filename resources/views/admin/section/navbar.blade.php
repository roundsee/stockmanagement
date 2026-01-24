<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Management</li>

                <li>
                    <a href="{{ route('admin.profile') }}">
                        <i data-feather="user-check"></i>
                        <span> My Profile </span>
                    </a>
                </li>

                @if (Auth::guard('web')->user()->can('brand.manage'))
                <li>
                    <a href="#brandManage" data-bs-toggle="collapse">
                        <i data-feather="briefcase"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="brandManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.brand.all') }}">All Brand</a></li>
                            <li><a href="{{ route('admin.brand.create') }}">Create Brand</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('warehouse.menu'))
                <li>
                    <a href="#warehouseManage" data-bs-toggle="collapse">
                        <i data-feather="database"></i>
                        <span> Manage Warehouse </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="warehouseManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.ware-house.all') }}">All Warehouse</a></li>
                            <li><a href="{{ route('admin.ware-house.create') }}">Create Warehouse</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('supplier.menu'))
                <li>
                    <a href="#supplierManage" data-bs-toggle="collapse">
                        <i data-feather="truck"></i>
                        <span> Manage Supplier </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="supplierManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.supplier.all') }}">All Supplier</a></li>
                            <li><a href="{{ route('admin.supplier.create') }}">Create Supplier</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('customer.menu'))
                <li>
                    <a href="#customerManage" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Manage Customer </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="customerManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.customer.all') }}">All Customer</a></li>
                            <li><a href="{{ route('admin.customer.create') }}">Create Customer</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('unit.menu'))
                <li class="nav-item">
                    <a href="{{ route('admin.unit.all') }}" class="nav-link">
                        <span class="nav-icon"><i class="mdi mdi-scale"></i></span>
                        <span class="nav-link-title">Units (Satuan)</span>
                    </a>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('product.menu'))
                <li>
                    <a href="#productManage" data-bs-toggle="collapse">
                        <i data-feather="shopping-bag"></i>
                        <span> Manage Product </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="productManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.all-products') }}">All Products</a></li>
                            <li><a href="{{ route('admin.all-products.create') }}">Add Product</a></li>
                            <li><a href="{{ route('admin.category.all') }}">All Category</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                <li class="menu-title">Transactions</li>

                @if (Auth::guard('web')->user()->can('purchase.menu'))
                <li>
                    <a href="#purchaseManage" data-bs-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Purchase </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="purchaseManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.all-purchase') }}">All Purchase</a></li>
                            <li><a href="{{ route('admin.create-purchase') }}">Create Purchase</a></li>
                            <li><a href="{{ route('admin.all-purchase-return') }}">Purchase Return</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('Sale.menu'))
                <li>
                    <a href="#saleManage" data-bs-toggle="collapse">
                        <i data-feather="trending-up"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="saleManage">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.sale.items-list') }}">All Sale</a></li>
                            <li><a href="{{ route('admin.sale.items-create') }}">Create Sale</a></li>
                            <li><a href="{{ route('admin.sale-item.return') }}">Sale Return</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::guard('web')->user()->can('transfer.menu'))
                <li>
                    <a href="#transfer" data-bs-toggle="collapse">
                        <i data-feather="repeat"></i>
                        <span> Transfers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="transfer">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.all-transfer.item') }}">All Transfer</a></li>
                            <li><a href="{{ route('admin.transfer.create') }}">Create Transfer</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                <li class="menu-title">Settings & Roles</li>

                <li>
                    <a href="#rolepermission" data-bs-toggle="collapse">
                        <i data-feather="shield"></i>
                        <span> Role & Permission </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="rolepermission">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.all.permission') }}">Permissions</a></li>
                            <li><a href="{{ route('admin.all.userRole') }}">Roles</a></li>
                            <li><a href="{{ route('admin.list.allrollinpermission') }}">Role in Permission</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#manageadmin" data-bs-toggle="collapse">
                        <i data-feather="user-plus"></i>
                        <span> Manage Admin </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="manageadmin">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('admin.list.all.user') }}">All Admins</a></li>
                            <li><a href="{{ route('admin.create.all.user') }}">Add Admin</a></li>
                        </ul>
                    </div>
                </li>

                @if (Auth::guard('web')->user()->can('report.menu'))
                <li>
                    <a href="{{ route('admin.all-report') }}">
                        <i data-feather="bar-chart-2"></i>
                        <span> Reports </span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>