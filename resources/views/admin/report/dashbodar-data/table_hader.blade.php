 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <div class="container-fluid">
         <a class="navbar-brand" href="#">Reports</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAlt"
             aria-controls="navbarNavAlt" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarNavAlt">
             <ul class="navbar-nav">
                 <li class="nav-item">
                     <a href="{{ route('admin.all-report') }}"
                         class="nav-link {{ Route::currentRouteName() === 'admin.all-report' ? 'active' : '' }}">
                         @if (Route::currentRouteName() === 'admin.all-report')
                             <span class="badge bg-primary">Purchase</span>
                         @else
                             Purchase
                         @endif
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('admin.purchase-return.reports') }}"
                         class="nav-link {{ Route::currentRouteName() === 'admin.purchase-return.reports' ? 'active' : '' }}">
                         @if (Route::currentRouteName() === 'admin.purchase-return.reports')
                             <span class="badge bg-primary">Purchase Return</span>
                         @else
                             Purchase Return
                         @endif
                     </a>
                 </li>
                 <li class="nav-item"><a href="{{ route('admin.sale.report') }}"
                         class="nav-link         {{ Route::currentRouteName() === 'admin.sale.report' ? 'active' : '' }}">
                         @if (Route::currentRouteName() === 'admin.sale.report')
                             <span class="badge bg-primary">Sale</span>
                         @else
                             Sale
                         @endif
                     </a>
                 </li>
                 <li class="nav-item"><a href="{{ route('admin.sale-return.reports') }}"
                         class="nav-link         
                                {{ Route::currentRouteName() === 'admin.sale-return.reports' ? 'active' : '' }}">
                         @if (Route::currentRouteName() === 'admin.sale-return.reports')
                             <span class="badge bg-primary">Sale Return</span>
                         @else
                             Sale Return
                         @endif
                     </a>
                 </li>
                 <li class="nav-item"><a href="{{ route('admin.stock.reports') }}"
                         class="nav-link         
                                {{ Route::currentRouteName() === 'admin.stock.reports' ? 'active' : '' }}">
                         @if (Route::currentRouteName() === 'admin.stock.reports')
                             <span class="badge bg-primary">Stock</span>
                         @else
                             Stock
                         @endif
                     </a>
                 </li>
             </ul>
         </div>

         <div class="d-flex align-items-center ms-3 position-relative">
             <select id="date-range" class="form-select">
                 <option value="today" selected>Today</option>
                 <option value="this_week">This Week</option>
                 <option value="last_week">Last Week</option>
                 <option value="this_month">This Month</option>
                 <option value="last_month">Last Month</option>
                 <option value="custom">Custom Range</option>
             </select>
             <span class="mdi mdi-filter-menu text-white ms-2"></span>

             <div id="custom-date-range" class="d-flex align-items-center ms-3 d-none">
                 <input type="date" id="start-date" name="start_date" class="form-control me-2">
                 <input type="date" id="end-date" name="end_date" class="form-control me-2">

                 <button id="search-date-range" type="button" class="btn btn-primary d-flex align-items-center">
                     <span class="mdi mdi-magnify me-1"></span> Search
                 </button>
             </div>
             <div id="ajax-loader" class="ms-3 d-none">
                 <span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>
             </div>
         </div>
     </div>
 </nav>
