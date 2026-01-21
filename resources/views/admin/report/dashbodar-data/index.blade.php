  <div class="row">
      <!-- Dashboard Cards -->
      <!-- Purchase -->
      <div class="col-md-4 col-lg-4">
          <div class="card mb-3" style="max-width: 400px; background-color: #00BCD4;">
              <div class="row g-0">
                  <div class="col-4 d-flex align-items-center justify-content-center" style="height: 100px;">
                      <span class="mdi mdi-cart mdi-36px text-white"></span>
                  </div>
                  <div class="col-md-8">
                      <div class="card-body p-3">
                          <h2 class="fs-16 mb-1 fw-semibold text-white">Purchase</h2>
                          <p class="fs-16 mb-0 fw-semibold text-white">
                              <strong>{{ \App\Models\Purchase::count() }}</strong>
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Purchase Return -->
      <div class="col-md-4 col-lg-4">
          <div class="card mb-3" style="max-width: 400px; background-color: #FF7043;">
              <div class="row g-0">
                  <div class="col-4 d-flex align-items-center justify-content-center" style="height: 100px;">
                      <span class="mdi mdi-cart-off mdi-36px text-white"></span>
                  </div>
                  <div class="col-md-8">
                      <div class="card-body p-3">
                          <h2 class="fs-16 mb-1 fw-semibold text-white">Purchase Return</h2>
                          <p class="fs-16 mb-0 fw-semibold text-white">
                              <strong>{{ \App\Models\ReturnPurchase::count() }}</strong>
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Stock -->
      <div class="col-md-4 col-lg-4">
          <div class="card mb-3" style="max-width: 400px; background-color: #4CAF50;">
              <div class="row g-0">
                  <div class="col-4 d-flex align-items-center justify-content-center" style="height: 100px;">
                      <span class="mdi mdi-warehouse mdi-36px text-white"></span>
                  </div>
                  <div class="col-md-8">
                      <div class="card-body p-3">
                          <h2 class="fs-16 mb-1 fw-semibold text-white">Stock</h2>
                          <p class="fs-16 mb-0 fw-semibold text-white">
                              <strong>{{ \App\Models\Product::count() }}</strong>
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Sale -->
      <div class="col-md-4 col-lg-4">
          <div class="card mb-3" style="max-width: 400px; background-color: #FFC107;">
              <div class="row g-0">
                  <div class="col-4 d-flex align-items-center justify-content-center" style="height: 100px;">
                      <span class="mdi mdi-sale mdi-36px text-white"></span>
                  </div>
                  <div class="col-md-8">
                      <div class="card-body p-3">
                          <h2 class="fs-16 mb-1 fw-semibold text-white">Sale</h2>
                          <p class="fs-16 mb-0 fw-semibold text-white">
                              <strong>{{ \App\Models\Sale::count() }}</strong>
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Sale Return -->
      <div class="col-md-4 col-lg-4">
          <div class="card mb-3" style="max-width: 400px; background-color: #F44336;">
              <div class="row g-0">
                  <div class="col-4 d-flex align-items-center justify-content-center" style="height: 100px;">
                      <span class="mdi mdi-backspace mdi-36px text-white"></span>
                  </div>
                  <div class="col-md-8">
                      <div class="card-body p-3">
                          <h2 class="fs-16 mb-1 fw-semibold text-white">Sale Return</h2>
                          <p class="fs-16 mb-0 fw-semibold text-white">
                              <strong>{{ \App\Models\SaleReturn::count() }}</strong>
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
