<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnPurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SaleReturnController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\WareHouseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UnitController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// *** custom Auth Controller ***//
Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/login', [AuthController::class, 'loginStore'])->name('admin.login-store');
Route::get('/register', [AuthController::class, 'register'])->name('admin.register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('admin.register-store');

Route::get('/logout', [AuthController::class, 'logoutView'])->name('admin.logout-view');

// *** Admin Dashboard ***//
Route::prefix('admin')->as('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Profile Route
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::post('/profile/{id}', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/credential/{id}', [AdminProfileController::class, 'updateCredential'])->name('profile.credential.update');
    //**** Manage Brand ***//
    Route::controller(BrandController::class)->group(function () {
        Route::get('/brand-list', 'index')->name('brand.all');
        Route::get('/brand-create', 'create')->name('brand.create');
        Route::post('/brand-store', 'store')->name('brand.store');
        Route::get('/brand-edit/{id}', 'edit')->name('brand.edit');
        Route::post('/brand-update/{id}', 'update')->name('brand.update');
        Route::delete('/brand-delete/{id}', 'delete')->name('brand.delete');
    });
    // *** Ware House  ***//

    Route::controller(WareHouseController::class)->group(function () {
        Route::get('/ware-house-list', 'index')->name('ware-house.all');
        Route::get('/ware-house-create', 'create')->name('ware-house.create');
        Route::post('/ware-house-store', 'store')->name('ware-house.store');
        Route::get('/ware-house-edit/{id}', 'edit')->name('ware-house.edit');
        Route::post('/ware-house-update/{id}', 'update')->name('ware-house.update');
        Route::delete('/ware-house-update/{id}', 'delete')->name('ware-house.delete');
    });

    //*** Route Supplier ***//
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/suppliers-list', 'index')->name('supplier.all');
        Route::get('/supplier-create', 'create')->name('supplier.create');
        Route::post('/supplier-store', 'store')->name('supplier.store');
        Route::get('/supplier-edit/{id}', 'edit')->name('supplier.edit');
        Route::post('/supplier-update/{id}', 'update')->name('supplier.update');
        Route::delete('/supplier-delete/{id}', 'delete')->name('supplier.delete');
    });

    // *** Route Customer ***//
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers-list', 'index')->name('customer.all');
        Route::get('/customers-create', 'create')->name('customer.create');
        Route::post('/customers-store', 'store')->name('customer.store');
        Route::get('/customers-edit/{id}', 'edit')->name('customer.edit');
        Route::post('/customers-update/{id}', 'update')->name('customer.update');
        Route::delete('/customers-delete/{id}', 'delete')->name('customer.delete');
    });

    // *** Route Manage Category ***//
    Route::controller(ProductController::class)->group(function () {
        Route::get('/category-list', 'index')->name('category.all');
        Route::post('/category-store', 'store')->name('category.store');
        Route::post('/category-update/{id}', 'update')->name('category.update');
        Route::delete('/category-delete/{id}', 'delete')->name('category.delete');
    });


    Route::middleware(['auth'])->group(function () {

        // Route untuk CRUD Satuan
        Route::controller(UnitController::class)->group(function(){
            Route::get('/unit-list', 'index')->name('unit.all');
            Route::post('/unit-store', 'store')->name('unit.store');
            Route::post('/unit-update', 'update')->name('unit.update');
            Route::get('/unit-delete/{id}', 'destroy')->name('unit.delete');
        });

    });

    //*** All Product Route ***//

    Route::controller(ProductController::class)->group(function () {
        Route::get('all-products', 'productIndex')->name('all-products');
        Route::get('all-products-create', 'productCreate')->name('all-products.create');
        Route::post('all-products-store', 'productStore')->name('all-products.store');
        Route::delete('all-products-delete/{id}', 'productDelete')->name('all-products.delete');
        Route::get('product-details/{id}', 'productsDetails')->name('get.products.details');
        Route::get('product-edit/{id}', 'productsEdit')->name('all-products.edit');

        // Delete Image
        Route::post('admin/product/delete-main-image', 'deleteMainImage')->name('product.delete-main-image');
        Route::post('admin/product/delete-extra-image',  'deleteExtraImage')->name('product.delete-extra-image');
        // update Route
        Route::post('product-update/{id}', 'productUpdate')->name('all-products.update');
    });

    // Purchase Controller
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('all-purchase', 'index')->name('all-purchase');
        Route::get('create-purchase', 'create')->name('create-purchase');
        Route::get('/products/search',  'purchaseProductSearch')->name('purchase-products.search');
        Route::post('store-purchase', 'purchaseStore')->name('purchase-store');
        Route::get('details-purchase/{id}', 'detailsPurchase')->name('get.purchase.details');
        Route::delete('delete-purchase/{id}', 'deletePurchase')->name('purchase-delete');
        Route::get('/edit/purchase/{id}', 'EditPurchase')->name('edit.purchase');
        Route::put('/admin/purchase/{id}',  'purchaseUpdate')->name('purchase-update');
        Route::get('purchase/invoice/{id}', 'purchaseInvoice')->name('purchaseInvoice');
    });

    //Purchase Return Controller
    Route::controller(ReturnPurchaseController::class)->group(function () {
        Route::get('all-purchase-return', 'index')->name('all-purchase-return');
        Route::get('create-purchase-return', 'create')->name('create-purchase-return');
        Route::get('/return-products/search',  'purchaseReturnProductSearch')->name('purchase-return-products.search');
        Route::post('store-purchase-return', 'purchaseReturnStore')->name('purchase-return-store');
        Route::get('details-purchase-return/{id}', 'detailsPurchaseReturn')->name('get.purchase-return.details');
        Route::delete('delete-purchase-return/{id}', 'deletePurchaseReturn')->name('purchase-return-delete');
        Route::get('/edit/purchase-return/{id}', 'editPurchaseReturn')->name('edit.purchase-return');
        Route::put('/admin/purchase-return/{id}',  'purchaseReturnUpdate')->name('purchase-return-update');
        Route::get('purchase-return/invoice/{id}', 'purchaseReturnInvoice')->name('purchaseReturnInvoice');
    });

    // Sale Route--------
    Route::controller(SaleController::class)->group(function () {
        Route::get('sale-items-list', 'index')->name('sale.items-list');
        Route::get('sale-items-create', 'create')->name('sale.items-create');
        Route::post('sale-items-store', 'saleStore')->name('sales-store');
        Route::get('sale-items-edit/{id}', 'saleEdit')->name('sales-edit');
        Route::put('sale-items-update/{id}', 'saleUpdate')->name('sales-update');
        Route::get('sale-details/{id}', 'saleDetails')->name('get.sale.details');
        Route::delete('sale-delete/{id}', 'saleDelete')->name('sale-delete');
        Route::get('sale/invoice/{id}', 'saleInvoice')->name('saleInvoice');
    });

    // Sale Return
    Route::controller(SaleReturnController::class)->group(function () {
        Route::get('sale-item-return', 'index')->name('sale-item.return');
        Route::get('sale-return-create', 'create')->name('sale.return-create');
        Route::post('sale-return-store', 'saleReturnStore')->name('sales-return-store');
        Route::get('sale-return-details/{id}', 'saleReturnDetails')->name('get.sale-return.details');
        Route::get('sale-return/invoice/{id}', 'saleReturnInvoice')->name('sale.return.Invoice');
        Route::get('sale-return/edit/{id}', 'saleReturnEdit')->name('sale.return.edit');
        Route::put('sale-return/update/{id}', 'saleReturnUpdate')->name('sale.return.update');
        Route::delete('sale-return/delete/{id}', 'saleReturnDelete')->name('sale.return.delete');
        // Due Sale
        Route::get('due-sale-index', 'dueSaleIndex')->name('due.sale.index');
        Route::get('due-sale-return-index', 'dueSaleReturnIndex')->name('due.sale.return.index');
    });

    // Manage Transfer
    Route::controller(TransferController::class)->group(function () {
        Route::get('all-transfer-item', 'index')->name('all-transfer.item');
        Route::get('transfer-create', 'create')->name('transfer.create');
        Route::post('transfer-store', 'transferStore')->name('transfer.store');
        Route::get('transfer-details/{id}', 'transferDetails')->name('transfer.details');
        Route::delete('transfer-delete/{id}', 'transferDelete')->name('transfer.delete');
        Route::get('transfer-edit/{id}', 'transferEdit')->name('transfer.edit');
        Route::put('transfer-update/{id}', 'transferUpdate')->name('transfer.update');
    });
    // Report Controller
    Route::controller(ReportController::class)->group(function () {
        Route::get('all-report', 'index')->name('all-report');
        Route::get('purchases/filter',  'filterPurchase')->name('purchases.filter');

        // Purchase Return
        Route::get('purchase-return/reports', 'purchaseReturn')->name('purchase-return.reports');
        Route::get('purchases-return/filter',  'filterPurchaseReturn')->name('purchases-return.filter');

        //Sale
        Route::get('sale/report', 'saleReport')->name('sale.report');
        Route::get('sale/filter', 'filterSale')->name('sale.filter');
        //Sale Return
        Route::get('sale-return/report', 'saleReturnReports')->name('sale-return.reports');
        Route::get('sale-return/filter', 'saleReturnFilter')->name('sale-return.filter');

        // Stock
        Route::get('stock/report', 'stockReport')->name('stock.reports');
        Route::get('stock/filter', 'filterStockReport')->name('stock.filter');
    });
    // Role Controller
    Route::controller(RoleController::class)->group(function () {
        Route::get('all/permission', 'allPermission')->name('all.permission');
        Route::get('create/permission', 'permission')->name('create.permission');
        Route::post('store/permission', 'storePermission')->name('store.permission');
        Route::delete('delete/permission/{id}', 'deletePermission')->name('delete.permission');
        Route::get('edit/permission/{id}', 'editPermission')->name('edit.permission');
        Route::put('update/permission/{id}', 'updatePermission')->name('update.permission');
        // User Role
        Route::get('user/role', 'getAllrole')->name('all.userRole');
        Route::post('user/role-store', 'storeRoll')->name('store.userRole');
        Route::delete('user/role-delete/{id}', 'deleteRole')->name('delete.userRole');
        Route::put('user/role-update/{id}', 'updateRole')->name('update.userRole');

        // Add Role In Permission
        Route::get('user/role-in-permission', 'addRoleInPermission')->name('addrole.inpermission');
        //Store Role In Permission
        Route::post('user/add-role-in-permission', 'storeRoleInPermission')->name('store.roleInPermission');

        // List Role In permission
        Route::get('user/list-all-role-in-permission', 'listAllRoleInPermission')->name('list.allrollinpermission');
        Route::get('user/edit-role-in-permission/{id}', 'editRoleInPermission')->name('edit.roleinpermission');
        Route::post('user/update-role-in-permission/{id}', 'updateRoleInPermission')->name('update.roleinpermission');
        Route::delete('user/role-in-permission/delete/{id}', 'deleteRoleInPermission')->name('delete.rollinpermission');

        // Admin User
        Route::get('all/admin/user', 'listAllUser')->name('list.all.user');
        Route::get('add/user/create', 'createAllUser')->name('create.all.user');
        Route::post('add/user/store', 'storeUser')->name('store.user');
        Route::delete('add/user/delete/{id}', 'deleteUser')->name('delete.user');
        Route::get('add/user/edit/{id}', 'editUser')->name('edit.user');
        Route::put('add/user/update/{id}', 'updateUser')->name('update.user');

    });
});
