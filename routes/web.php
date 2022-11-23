<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\BayController;
use App\Http\Controllers\Admin\BinController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\CaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CoreController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\Admin\NotesController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\LookupController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\AisleController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\SampleController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\StockLogController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\CourrierController;
use App\Http\Controllers\Admin\CalenderController;
use App\Http\Controllers\Admin\SparePartController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\SentEmailController;
use App\Http\Controllers\Admin\JunkEmailController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\TrashEmailController;
use App\Http\Controllers\Admin\BeneficiaryController;
use App\Http\Controllers\Admin\IntermediaryController;
use App\Http\Controllers\Admin\ShipmentItemController;
use App\Http\Controllers\Admin\InvoiceItemsController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\Company\UserController;
use App\Http\Controllers\Admin\EmailSettingController;
use App\Http\Controllers\Admin\ProductStockController;
use App\Http\Controllers\Admin\ProductTitleController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\SalesChannel\EjoggaController;
use App\Http\Controllers\Admin\QuotationItemController;
use App\Http\Controllers\SalesChannel\AmazonController;
use App\Http\Controllers\SalesChannel\GrouponController;
use App\Http\Controllers\SalesChannel\WowcherController;
use App\Http\Controllers\Admin\WarehouseStockController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\FulfilmentOrderController;
use App\Http\Controllers\Admin\QuotationRequestController;
use App\Http\Controllers\SalesChannel\GogroopieController;
use App\Http\Controllers\Admin\CurrencyExchangesController;
use App\Http\Controllers\Admin\AttendencesImportController;
use App\Http\Controllers\Admin\warehouseShipmentController;
use App\Http\Controllers\SalesChannel\XstreamgymController;
use App\Http\Controllers\Admin\WarehouseContainerController;
use App\Http\Controllers\Admin\BuildingImportExportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Fulfilment\CaseController as FulfimentCaseController;
use App\Http\Controllers\Fulfilment\NotesController as FulfilmentNotesController;
use App\Http\Controllers\Fulfilment\StockLogController as FulfilmentStockController;
use App\Http\Controllers\Fulfilment\CompanyController as FulfilmentCompanyController;
use App\Http\Controllers\SuperAdmin\CompanyController as SuperAdminCompanyController;
use App\Http\Controllers\Fulfilment\Company\UserController as FulfilmentUserController;
use App\Http\Controllers\Fulfilment\DeliveryController as FulfilmentDeliveryController;
use App\Http\Controllers\Fulfilment\BeneficiaryController as FulfilmentBeneficiaryController;
use App\Http\Controllers\SuperAdmin\BeneficiaryController as SuperAdminBeneficiaryController;
use App\Http\Controllers\Fulfilment\EmailSettingController as FulfilmentEmailSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('register'));
})->middleware('check_if_user_exists');

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'web'])->group(function () {

    Route::resource('dashboard', DashboardController::class);
    Route::get('order-summary-chart', [DashboardController::class, 'orderSummaryChart'])->name('order.summary.chart');
    Route::get('user/profile/edit/{id}', [AdminUserController::class, 'Editprofile'])->name('user.edit.profile');
    Route::put('user/profile/update/{id}', [AdminUserController::class, 'updateprofile'])->name('user.profile.update');
    Route::post('date-picker', [DashboardController::class, 'datePicker'])->name('date.picker');
    Route::post('dashboard-sorting', [DashboardController::class, 'sorting'])->name('dashboard.sorting');
    Route::get('stock-csv-download/{date}', [DashboardController::class, 'stockCsvDownload'])->name('stock.csv.download');
    // Subscription //
    Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('subscription/create/{id}', [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('subscription/start', [SubscriptionController::class, 'start'])->name('subscriptions.start');

    Route::get('customer/invoices/documents/{id}', [CustomerController::class, 'fileexport'])->name('customer.invoice.export');

    Route::resource('logs', LogsController::class);

    Route::resource('lookups', LookupController::class);
//    Route::get('/logs/show', [LogsController::class, 'show'])->name('logs.show');

//    Route::get('/logs/show/{id}/', [LogsController::class, 'show'])->name('logs.show');

// <-----ERP Start----->
    Route::prefix('erp')->group(function () {
        //<--Manufacturer Start-->
        Route::get('/search-email-case', [EmailController::class, 'searchEmailCases']);
        Route::resource('scm/suppliers', SupplierController::class);
        Route::get('suppliers/files/create/{id}', [SupplierController::class, 'createDocuments'])->name('supplier.file.create');
        Route::get('suppliers/files/edit/{id}', [SupplierController::class, 'editDocuments'])->name('supplier.file.edit');
        Route::post('/suppliers/files/store', [SupplierController::class, 'documentStore'])->name('store.suppliers.files');
        Route::put('/suppliers/document/{id}', [SupplierController::class, 'documentUpdate'])->name('suppliers.document');
        Route::get('supplier/view/files/{id}', [SupplierController::class, 'viewSupplierFile'])->name('supplier.view.files');
        Route::get('supplier/export/files/{id}', [SupplierController::class, 'exportSupplierFile'])->name('supplier.export.files');
        Route::delete('document/delete/{id}', [SupplierController::class, 'delete'])->name('document.delete');

        // Shipments
        Route::resource('shipments', ShipmentController::class);
        // shipment modals
        Route::post('shipments/datesUpdate/{id}', [ShipmentController::class, 'datesUpdate'])->name("dates.update");
        Route::post('shipments/supplierUpdate/{id}', [ShipmentController::class, 'supplierUpdate'])->name("supplier.update");
        Route::put('shipments/addressUpdate/{id}', [ShipmentController::class, 'addressUpdate'])->name("address.update");
        Route::post('shipments/freightUpdate/{id}', [ShipmentController::class, 'freightUpdate'])->name("freight.update");
        Route::post('shipments/shipmentUpdate/{id}', [ShipmentController::class, 'shipmentUpdate'])->name("shipment.update");
        // shipment document
        Route::get('shipments/{id}/file/create', [ShipmentController::class, 'createShipmentDocument'])->name('shipment.document.create');
        Route::post('/shipments/files/store', [ShipmentController::class, 'storeShipmentDocument'])->name('store.shipments.files');
        Route::get('/shipments/files/edit{id}', [ShipmentController::class, 'editShipmentDocument'])->name('edit.shipments.files');
        Route::get('/shipments/files/show{id}', [ShipmentController::class, 'viewFile'])->name('show.shipments.files');
        Route::put('/shipments/files/update{id}', [ShipmentController::class, 'updateShipmentDocument'])->name('update.document');
        Route::delete('/deleteShipmentDocument/{id}', [ShipmentController::class, 'deleteShipmentDocument'])->name('deleteShipmentDocument.delete');
        Route::delete('/shipments/item/delete/{id}', [ShipmentController::class, 'itemDelete'])->name('shipment.item.delete');
        Route::delete('/shipments/doc/delete/{id}', [ShipmentController::class, 'docDelete'])->name('shipment.doc.delete');
        Route::get('/shipments/delete/{id}', [ShipmentController::class, 'destroy'])->name('shipment.delete');

        Route::get('export/shipment/files/{id}', [ShipmentController::class, 'shipmentExportFile'])->name('export.shipments.files');

        // shipmentitem
        Route::resource('shipmentitems', ShipmentItemController::class);
        Route::get('shipments/{shipmentId}/shipmentitems/create', [ShipmentItemController::class, 'create'])->name('shipmentitem.create');
        Route::get('shipments/{shipmentId}/shipmentitems/{shipmentItemId}/edit', [ShipmentItemController::class, 'edit'])->name('shipmentitem.edit');


        // Products
        Route::resource('product-details', ProductController::class);
        Route::resource('products', ProductsController::class);
        Route::get('add/product/title/{id}', [ProductTitleController::class, 'create'])->name('add.product.title');
        Route::get('del/product/title/{id}', [ProductTitleController::class, 'destroy'])->name('delete.product.title');
        Route::get('edit/product/title/{id}', [ProductTitleController::class, 'edit'])->name('edit.product.title');
        Route::resource('product-titles', ProductTitleController::class);

        //Purchase Order Route
        Route::resource('/{section}/purchaseorders', PurchaseOrderController::class);

        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::get('/search-supplier-purchase-orders', [PurchaseOrderController::class, 'searchSupplier']);
        Route::get('/search-customer-purchase-orders', [PurchaseOrderController::class, 'searchCustomer']);
        Route::get('/delete-purchase-order-item', [PurchaseOrderController::class, 'deletePurchaseOrderItem']);
        Route::get('/search-invoices-purchase-orders', [PurchaseOrderController::class, 'searchInvoices']);
        Route::post('/purchase-orders/save-invoices', [PurchaseOrderController::class, 'saveInvoices'])->name('purchase.order.save.invoices');
        Route::get('/{urlName}/{purchaseId}/invoices/edit/{id}', [PurchaseOrderController::class, 'editInvoice'])->name('purchase.order.edit.invoice');
        Route::post('/purchase-orders/invoices/delete', [PurchaseOrderController::class, 'deleteInvoice'])->name('purchase.order.delete.invoice');
        Route::get('/{urlName}/{purchaseId}/{urlNextName}/{invoiceId}/payments/create', [PurchaseOrderController::class, 'createPayment'])->name('purchase.order.create.payment');
        Route::get('/{urlName}/{purchaseId}/{urlNextName}/{invoiceId}/payments/{paymentId}/edit', [PurchaseOrderController::class, 'editPayment'])->name('purchase.order.edit.payment');
        Route::post('/payments/delete', [PurchaseOrderController::class, 'deletePayment'])->name('purchase.order.delete.payment');

        //<--product route-->//
        Route::get('res-search', [ProductTitleController::class, 'search']);
        Route::get('product-search', [ProductTitleController::class, 'getProductName']);

        //<--Manufacturer END-->

        //<--CRM Start-->
        Route::resource('customers', CustomerController::class);
        Route::get('customer/{cid}/order/{id}', [OrderController::class, 'showOrder'])->name('customer.order.show');
        Route::get('customer/del/{id}', [CustomerController::class, 'destroy'])->name('customer.del');
        Route::get('customer/invoice/create/{id}', [CustomerController::class, 'createInvoice'])->name('customer.invoice.create');
        Route::post('customer/create/invoice', [CustomerController::class, 'store']);
        Route::get('customer/{cid}/invoice/{iid}', [CustomerController::class, 'editinvoice'])->name('customer.invoice.edit');
        Route::put('customer/update/invoice/{id}', [CustomerController::class,'updateInvoice'])->name('customer.invoices.update');
        Route::get('/customer/del/invoice/{id}', [CustomerController::class, 'destroyinvoice'])->name('customer.invoice.del');

        Route::get('customer/dowmnload/{id}', [CustomerController::class, 'ExportDocu'])->name('customer.document.export');
        Route::get('customer/doucment/del/{id}', [CustomerController::class, 'DeleteDocu'])->name('customer.document.delete');
        Route::get('customer/invoices/documents/{id}', [CustomerController::class, 'fileexport'])->name('customer.invoice.export');

        Route::get('customer/{cid}/invoices/{iid}/payment/create', [CustomerController::class, 'createPayment'])->name('customer.payments.create');
        Route::post('customer/invoices/payment/store', [CustomerController::class, 'storePayment'])->name('customer.payments.store');
        Route::get('customer/{cid}/invoice/{iid}/payment/edit/{id}', [CustomerController::class, 'editPayment'])->name('customer.payments.edit');
        Route::put('customer/payment/update/{id}', [CustomerController::class, 'updatePayment'])->name('customer.payments.update');
        Route::post('customer/document/store', [CustomerController::class, 'storeDocument'])->name('customer.document.store');

        Route::get('customer/{id}/reviews/create', [CustomerController::class, 'createReview'])->name('customer.create.review');
        Route::post('customer/{id}/reviews/store', [CustomerController::class, 'storeReview'])->name('customer.store.review');
        Route::get('customer/{cid}/reviews/{id}/del', [CustomerController::class, 'destroyReview'])->name('customer.reviews.delete');
        Route::get('customer/{cid}/reviews/view/{id}', [ReviewsController::class, 'show'])->name('customer.reviews.view');
        Route::get('customer/{cid}/reviews/edit/{id}', [CustomerController::class, 'editReview'])->name('customer.reviews.edit');
        Route::put('customer/{cid}/reviews/update   ', [CustomerController::class, 'updateReview'])->name('customer.reviews.update');

        Route::get('customer/{id}/case/create', [CustomerController::class, 'createCase'])->name('customer.case.create');
        Route::post('/customer/case/store/{id}', [CustomerController::class, 'storeCase'])->name('customer.case.store');
        Route::get('/customer/case/del/{id}', [CustomerController::class, 'delcase'])->name('customer.case.del');
        Route::get('/customer/{cid}/case/show/{caseid}', [CustomerController::class, 'showcase'])->name('customer.case.show');


        //<--Order Start-->
        Route::resource('orders', OrderController::class);
        Route::put('order/product/update/{id}', [OrderController::class, 'productUpdate'])->name('product.update');
        Route::put('order/update/{id}', [OrderController::class, 'orderUpdate'])->name('order.update');
        Route::put('status/update/{id}', [OrderController::class, 'statusUpdate'])->name('order.status.update');

        //<--Channels-->//
        Route::resource('wowchers', WowcherController::class);
        Route::resource('groupons', GrouponController::class);
        Route::resource('xstreamgyms', XstreamgymController::class);
        Route::resource('gogroopies', GogroopieController::class);
        Route::resource('ejoggas', EjoggaController::class);
        Route::resource('amazons', AmazonController::class);
        Route::get('imports', [ImportController::class, 'index'])->name('imports.index');
        Route::get('imports/create', [ImportController::class, 'create'])->name('imports.create');
        Route::post('/imports/store', [ImportController::class, 'store'])->name('imports.store');
        Route::get('/export/orders', [ImportController::class, 'exportOrders'])->name('export.orders');
        Route::get('multiple/imports', [ImportController::class, 'multipleImport'])->name('multiple.imports');
        Route::get('export/import/files/{id}', [ImportController::class, 'export'])->name('export.import.files');

        //Deliveries//
        Route::get('deliveries', [DeliveryController::class, 'Index'])->name('deliveries.index');
        Route::put('deliveries/{id}', [DeliveryController::class, 'update'])->name('deliveries.update');
        // Route::put('deliveriesStatus', [DeliveryController::class, 'updateStatus'])->name('deliveriesStatus.updateStatus');
        Route::get('tuffnell/file', [DeliveryController::class, 'tuffnellTxt'])->name('tuffnell.file');
        Route::get('export/tuffnell/file/{id}', [DeliveryController::class, 'export'])->name('export.tuffnell.file');
        Route::get('create/Manifest/file/{id}', [DeliveryController::class, 'createManifests'])->name('upload.manifest.file');
        Route::post('importfile/manifest/file', [DeliveryController::class, 'importManifests'])->name('import.manifest.file');
        Route::get('export/manifest/data/file/{id}', [DeliveryController::class, 'exportManifests'])->name('export.manifest.data.file');
        Route::get('view/manifest', [DeliveryController::class, 'viewManifest'])->name('manifest.view');
        // Route::get('export/tuffnell/file/{id}', [DeliveryController::class, 'export'])->name('export.tuffnell.file');
        // Route::put('deliveriesStatus', [DeliveryController::class, 'updateStatus'])->name('deliveriesStatus.updateStatus');
        Route::delete('/del/manifest/{id}', [DeliveryController::class, 'delManifest'])->name('del.manifest.data');
        Route::get('/edit/manifest/{id}', [DeliveryController::class, 'editManifest'])->name('edit.manifest.data');
        Route::put('manifest/update/{id}', [DeliveryController::class, 'updateManifest'])->name('manifestUpdate');

        // Label Delivery
        Route::resource('label-deliveries', LabelDeliveryController::class);
        // Spare Part
        Route::resource('spare-parts', SparePartController::class);

        // Fetch Email //
        Route::get('delivery/show/{id}', [DeliveryController::class, 'show'])->name('delivery.show');
        // picking list
        Route::get('/pickingList/{id}', [DeliveryController::class, 'pickingListIndex'])->name('picking.list');
        // delivery-inspection
        Route::get('/delivery-inspection/{id}', [DeliveryController::class, 'deliveryInspection'])->name('delivery.inspection');
        Route::post('/delivery/inspected/store', [DeliveryController::class, 'deliveryInspected'])->name('delivery.inspected');
        Route::get('export/import/files/{id}', [ImportController::class, 'export'])->name('export.import.files');


        // Cases //

        Route::resource('cases', CaseController::class);
        Route::get('cases/{id}/document/create', [CaseController::class, 'createDocuments'])->name('cases.document.create');
        Route::post('/cases/document/store', [CaseController::class, 'documentStore'])->name('store.cases.document');
        Route::get('cases/documents/{id}/edit', [CaseController::class, 'editDocuments'])->name('cases.document.edit');

        Route::put('/cases/document/{id}', [CaseController::class, 'documentUpdate'])->name('cases.document');
        Route::delete('/cases/document/delete/{id}', [CaseController::class, 'delete'])->name('cases.document.delete');
        Route::get('view/cases/document/{id}', [CaseController::class, 'viewFile'])->name('view.cases.document');
        Route::get('export/cases/document/{id}', [CaseController::class, 'exportFile'])->name('export.cases.document');
        
        Route::post('/new/cases/store', [CaseController::class, 'newCustomer'])->name('new.customer.case.store');

        Route::get('cases/{id}/notes/create', [NotesController::class, 'create'])->name('cases.notes.create');
        Route::post('/cases/notes/store', [NotesController::class, 'store'])->name('store.cases.notes');
        Route::get('cases/notes/{id}/edit', [NotesController::class, 'edit'])->name('cases.notes.edit');
        Route::put('/cases/notes/{id}', [NotesController::class, 'update'])->name('cases.notes.update');
        Route::delete('/cases/notes/{id}/delete', [NotesController::class, 'destroy'])->name('cases.notes.delete');

        Route::post('/cases/type/store', [CaseController::class, 'typeStore'])->name('cases.type.store');
        Route::put('/cases/type/{id}', [CaseController::class, 'typeUpdate'])->name('cases.type.update');
        Route::delete('/cases/type/{id}/delete', [CaseController::class, 'typeDestroy'])->name('cases.type.delete');
        Route::delete('/cases/spare-part/{id}/delete', [CaseController::class, 'sparepartDestroy'])->name('cases.sparepart.delete');
        //Fetch Email
        Route::resource('fetch-email', EmailController::class);
        Route::post('email/reply', [EmailController::class, 'reply'])->name('email.reply');
        Route::post('email-status', [EmailController::class, 'status'])->name('email.status');
        Route::post('email-mark', [EmailController::class, 'emailMark'])->name('email.mark');
        Route::get('/search-email-case', [EmailController::class, 'searchEmailCases']);
        Route::get('trash-email', [TrashEmailController::class, 'index'])->name('trash-email.index');
        Route::get('junk-email', [JunkEmailController::class, 'index'])->name('junk-email.index');
        Route::get('sent-email', [SentEmailController::class, 'index'])->name('sent-email.index');

        Route::resource('fetch-email', EmailController::class);
        Route::get('all-mail', [EmailController::class, 'allEmail'])->name('all.mail');
        Route::resource('archive-email', ArchiveController::class);
        Route::get('fetch-specific-email', [EmailController::class, 'fetchSpecificEmail'])->name('fetch.specific.email');
        Route::post('email/reply', [EmailController::class, 'reply'])->name('email.reply');
        Route::get('/search-email-case', [EmailController::class, 'searchEmailCases']);
        Route::post('email/compose', [EmailController::class, 'composeEmailSend'])->name('email.compose');
        Route::get('email/{id}/{active_email}/{original_folder}/{move_to_folder}', [EmailController::class, 'changeFolder'])->name('change.folder');
        Route::get('email-star-status', [EmailController::class, 'emailStarStatus'])->name('email.star.status');
        Route::post('drafts-email', [EmailController::class, 'draftsEmail'])->name('drafts.email');
        Route::post('email/forward', [EmailController::class, 'forwardEmailSend'])->name('email.forward');
        Route::get('email/{id}/{active_email}/{folder}', [EmailController::class, 'permanentDeleteEmail'])->name('permanent.delete.email');
        Route::get('fetching-email-detail', [EmailController::class, 'fetchingEmailDetail'])->name('fetching.email.detail');

        Route::post('email-status', [EmailController::class, 'status'])->name('email.status');
        Route::get('trash-email', [TrashEmailController::class, 'index'])->name('trash-email.index');
        Route::get('junk-email', [JunkEmailController::class, 'index'])->name('junk-email.index');
        Route::get('sent-email', [SentEmailController::class, 'index'])->name('sent-email.index');


        // Review
        Route::resource('reviews', ReviewsController::class);

        //<--CRM End-->

        //<--Finance Start-->

        // deal route
        Route::resource('deals', DealController::class);
        Route::get('deals/{id}/documents/create', [DealController::class, 'createDocuments'])->name('deal.document.create');
        Route::get('deals/{id}/documents/edit', [DealController::class, 'editDocuments'])->name('deal.document.edit');
        Route::post('/deals/files/store', [DealController::class, 'documentStore'])->name('store.deals.document');
        Route::put('/deals/{id}/document', [DealController::class, 'documentUpdate'])->name('deals.document');
        Route::post('/deals/rate/create', [DealController::class, 'dealRateCreate'])->name('deals.rate.create');
        Route::post('/deals/item/create', [DealController::class, 'dealItemCreate'])->name('deals.items.create');
        Route::put('/deals/{id}/rate/update', [DealController::class, 'dealRateUpdate'])->name('deals.rate.update');
        Route::delete('deal/{id}/document/delete', [DealController::class, 'delete'])->name('document.deal.delete');
        Route::get('view/deals/{id}/documents', [DealController::class, 'viewFile'])->name('view.deals.document');
        Route::get('export/deals/{id}/documents', [DealController::class, 'exportFile'])->name('export.deals.document');
        Route::get('deals/{id}/add-payments', [DealController::class, 'addPayments'])->name('deal-addPayments');
        Route::post('/deals/payment/store', [DealController::class, 'paymentStore'])->name('store.deals.payment');
        Route::post('deals/invoice/create', [DealController::class, 'invoiceCreate'])->name('deals.invoice.create');
        Route::get('/deals/invoice/view/{id}', [DealController::class, 'invoiceView'])->name('deals.invoice.view');
        Route::get('/orders/invoice/view/{id}', [DealController::class, 'ordersInvoiceView'])->name('orders.invoice.view');
        Route::get('/deal/product/rate/show/{id}', [DealController::class, 'ratesShow'])->name('deal.product.rates');
        Route::delete('/deals/invoice/delete/{id}', [DealController::class, 'invoiceDelete'])->name('deals.invoice.delete');
        Route::delete('/deals/products/delete/{id}', [DealController::class, 'dealProductDelete'])->name('deal.product.delete');
        Route::delete('/deals/products/ratea/delete/{id}', [DealController::class, 'dealProductRateDelete'])->name('deal.product.rate.delete');
        // Payment
        Route::resource('payments', PaymentController::class);
        Route::delete('payments/delete/{id}', [PaymentController::class , 'destroy'])->name('payments.delete');
        Route::get('payments/{id}/files/create/', [PaymentController::class, 'addDocuments'])->name('payment.file.create');
        Route::post('/payments/{id}/files/store/', [PaymentController::class, 'documentStore'])->name('document.store');
        Route::get('/payments/{id}/files/edit/{id2}', [PaymentController::class, 'editDocuments'])->name('payment.file.edit');
        Route::put('/payments/{id}/files/update', [PaymentController::class, 'documentUpdate'])->name('payment.document.update');
        Route::delete('/payments/{id}/doc/delete/{id2}', [PaymentController::class, 'docDelete'])->name('payment-doc-delete');
        Route::get('/payments/{id}/files/view/{id2}', [PaymentController::class, 'viewFile'])->name('view.payment.file');
        Route::get('/payments/{id}/files/export/{id2}', [PaymentController::class, 'exportFile'])->name('export.payment.file');

        // Invoice routes
        Route::resource('invoices', InvoiceController::class);
        Route::post('customer/{id}/invoice/store', [CustomerController::class , 'InvoiceStore'])->name('invoice.store');
        Route::delete('/invoices/item/delete/{id}', [InvoiceController::class, 'itemDelete'])->name('invoice.item.delete');
        Route::delete('/invoices/doc/delete/{id}', [InvoiceController::class, 'docDelete'])->name('invoice.doc.delete');
        Route::get('{name}/{id}/invoices/create', [InvoiceController::class, 'create'])->name('invoice.create');
//    Route::get('{name}/{id}/invoices/{invoiceId}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');

        Route::get('invoice/{id}/exportpdf', [InvoiceController::class, 'invoiceReportExport'])->name('invoice.export.pdf');

        // Invoice Items routes
        Route::resource('invoiceitems', InvoiceItemsController::class);
        Route::get('{name}/{id}/invoices/{invoiceId}/invoice-items/create', [InvoiceItemsController::class, 'create'])->name('invoice-item.create');
        Route::get('{name}/{id}/invoices/{invoiceId}/invoice-items/{invoiceItemId}/edit', [InvoiceItemsController::class, 'edit'])->name('invoice-item.edit');

        //<--Finance End-->//

        //<--Reports Start-->//

        //Sales Report
        Route::get('sale-reports', [OrderController::class, 'reportCreate'])->name('sale.report.create');
        Route::get('sale-reports/exportcsv', [OrderController::class, 'orderReportExport'])->name('sale.report.export.csv');
        Route::get('sale-reports/exportpdf', [OrderController::class, 'orderReportExportPDF'])->name('sale.report.export.pdf');

        //Stock Report
        Route::get('stock-reports', [ProductStockController::class, 'reportCreate'])->name('stock.report.create');
        Route::get('stock-reports/exportcsv', [ProductStockController::class, 'stockReportExport'])->name('stock.report.export.csv');
        Route::get('stock-reports/exportpdf', [ProductStockController::class, 'stockReportExportPDF'])->name('stock.report.export.pdf');
        //<--Reports End-->//

        //<--Stock Start-->//
        Route::resource('stock-logs', StockLogController::class);

        //<<--Warehouse-->

        Route::resource('employees', EmployeeController::class);
        Route::get('/search-employee-record', [PayrollController::class, 'searchEmployee']);
        Route::delete('/employees-record/{id}', [EmployeeController::class, 'delete']);
        Route::delete('/document/delete/{id}', [EmployeeController::class, 'deleteDocument'])->name('document.delete');
        Route::get('employees/{id}/employees-record/{erid}/edit', [EmployeeController::class, 'attendenceEdit'])->name('attendence.edit');
        Route::put('/employees-record/{id}', [EmployeeController::class, 'attendenceUpdate'])->name('attendence.update');
        Route::get('employee-cv-export/{id}', [EmployeeController::class, 'fileExport'])->name('employee.cv.export');
        Route::get('view/employee/{id}/documents', [EmployeeController::class, 'viewFile'])->name('view.employee.document');
        Route::get('/employees/{id}/document', [EmployeeController::class, 'createDocument'])->name('employee.document');
        Route::post('/employees/document/store', [EmployeeController::class, 'docStore'])->name('employee.store.document');
        Route::get('employees/documents/{id}/edit', [EmployeeController::class, 'editDocuments'])->name('employees.document.edit');
        Route::put('/employee/document/{id}', [EmployeeController::class, 'documentUpdate'])->name('employee.document.update');

        Route::get('attendance/import/', [AttendencesImportController::class, 'createAttendence'])->name('attendence.import.create');
        Route::delete('attendence-file-delete/{id}', [AttendencesImportController::class, 'destroy'])->name('attendence.file.delete');
        Route::get('attendence-file-export/{id}', [AttendencesImportController::class, 'fileExport'])->name('attendence.file.export');
         Route::post('attendence-store', [AttendencesImportController::class, 'fileImport'])->name('attendence.store');
         Route::get('employee/attendence/{id}', [EmployeeController::class, 'exportAttendence'])->name('export.attendence.file');

        Route::get('attendance-import', [AttendencesImportController::class, 'attendenceImport'])->name('attendence.import');
        Route::get('attendance-report', [AttendencesImportController::class, 'show'])->name('attendence.show');

        Route::post('attendence-store', [AttendencesImportController::class, 'fileImport'])->name('attendence.store');
        Route::get('/search_events', [CalenderController::class, 'searchEvent']);

        Route::resource('payrolls', PayrollController::class);
        Route::post('/store-payroll-item/{id}', [PayrollController::class, 'storePayrollItem'])->name('store.payroll.item');
        Route::get('bankorder/{id}', [PayrollController::class, 'bankOrderLetter'])->name('bankorder.bankOrderLetter');
        Route::get('Employee/PaySlip/{id}', [PayrollController::class, 'Payslips'])->name('export.employee.payslip');
        Route::get('cashorder/{id}', [PayrollController::class, 'cashOrderLetter'])->name('cashorder.cashOrderLetter');
        Route::put('/adjustment-update/{id}', [PayrollController::class, 'adjustment'])->name('adjustment.update');
        Route::delete('/salary/delete/{id}', [PayrollController::class, 'deleteSalary'])->name('salary.delete');
        Route::resource('salaries', SalaryController::class);


    });
//<-----ERP End----->//
    Route::prefix('fulfilment')->group(function () {
//<----Fulfilment Start---->//

        //<--Calender Start-->//
        Route::resource('calendar', CalenderController::class);
        Route::get('calendar/orders', [CalenderController::class, 'orders'])->name('calender.orders');
        Route::get('/search_events', [CalenderController::class, 'searchEvent']);
        Route::get('/search-orders', [CalenderController::class, 'searchOrder']);
        Route::get('/search-order-events', [CalenderController::class, 'searchOrderEvent']);
        Route::get('/search-delivery-events', [CalenderController::class, 'searchDeliveryEvent']);
        Route::get('/search-collection-events', [CalenderController::class, 'searchCollectionEvent'])->name('search-collection-events');
        Route::get('/search-shipment-events', [CalenderController::class, 'searchShipmentEvent'])->name('search-shipment-events');
        Route::get('/order-events', [CalenderController::class, 'orderEvent'])->name('order-events');
        Route::get('/delivery-events', [CalenderController::class, 'deliveryEvent'])->name('delivery-events');
        Route::get('/collection-events', [CalenderController::class, 'collectionEvent'])->name('collection-events');
        Route::get('/shipment-events', [CalenderController::class, 'shipmentEvent'])->name('shipment-events');
        Route::get('myCalender', [CalenderController::class, 'myClender'])->name('my.calender');

        //<--Calendar End-->//

        //<--Stock Start-->//

        Route::resource('stocks', StockController::class);
        Route::resource('stock-log', FulfilmentStockController::class);
        Route::resource('product-stocks', ProductStockController::class);
        Route::resource('warehouse-stocks', WarehouseStockController::class);

        //<--Stock End-->//

        //<--Goods In Start-->//

        //Containers//
        Route::resource('containers', WarehouseContainerController::class);
        Route::get('/containers/{id}/content/create', [WarehouseContainerController::class, 'addContext'])->name('containers.addcontext');
        Route::post('/containers/{id}/content/Store', [WarehouseContainerController::class, 'contextStore'])->name('container.context.store');
        Route::get('/containers/{id}/content/edit/{id2}', [WarehouseContainerController::class, 'editContext'])->name('container.context.edit');
        Route::put('/containers/{id}/content/update', [WarehouseContainerController::class, 'updateContext'])->name('context-update');
        Route::delete('/containers/{id}/content/delete/{id2}', [WarehouseContainerController::class, 'delete'])->name('container.delete');
        Route::get('/containers/{id}/files/create', [WarehouseContainerController::class, 'addDocuments'])->name('container.file.create');
        Route::post('/containers/{id}/files/store', [WarehouseContainerController::class, 'documentStore'])->name('document-store');
        Route::get('/containers/{id}/files/edit/{id2}', [WarehouseContainerController::class, 'editDocuments'])->name('container.file.edit');
        Route::put('/containers/{id}/files/update', [WarehouseContainerController::class, 'documentUpdate'])->name('container.document.update');
        Route::delete('/containers/{id}/files/delete/{id2}', [WarehouseContainerController::class, 'docDelete'])->name('container-doc-delete');
        Route::get('/containers/{id}/files/view/{id2}', [WarehouseContainerController::class, 'viewFile'])->name('view.container.file');
        Route::get('/containers/{id}/files/export/{id2}', [WarehouseContainerController::class, 'exportFile'])->name('export.container.file');

        //Warehousse Shipment//
        Route::resource('warehouse-shipments', warehouseShipmentController::class);

        //Collections//
        Route::resource('collections', CollectionController::class);

        //<--Goods In End-->//

        //<--Goods Out Start-->//

        // Fulfilment order
        Route::resource('order', FulfilmentOrderController::class);

        // warehouse shipment

        Route::get('export/import/files/{id}', [ImportController::class, 'export'])->name('export.import.files');

        //<--Cases-->//
        Route::resource('case', FulfimentCaseController::class);
        Route::get('cases/{id}/document/create', [FulfimentCaseController::class, 'createDocuments'])->name('case.document.create');
        Route::post('/cases/document/store', [FulfimentCaseController::class, 'documentStore'])->name('store.case.document');
        Route::get('cases/documents/{id}/edit', [FulfimentCaseController::class, 'editDocuments'])->name('case.document.edit');
        Route::put('/cases/document/{id}', [FulfimentCaseController::class, 'documentUpdate'])->name('case.document');
        Route::delete('/cases/document/delete/{id}', [FulfimentCaseController::class, 'delete'])->name('case.document.delete');
        Route::get('view/cases/document/{id}', [FulfimentCaseController::class, 'viewFile'])->name('view.case.document');
        Route::get('export/cases/document/{id}', [FulfimentCaseController::class, 'exportFile'])->name('export.case.document');
        Route::get('cases/{id}/notes/create', [FulfilmentNotesController::class, 'create'])->name('case.notes.create');
        Route::post('/cases/notes/store', [FulfilmentNotesController::class, 'store'])->name('store.case.notes');
        Route::get('cases/notes/{id}/edit', [FulfilmentNotesController::class, 'edit'])->name('case.notes.edit');
        Route::put('/cases/notes/{id}', [FulfilmentNotesController::class, 'update'])->name('case.notes.update');
        Route::delete('/cases/notes/{id}/delete', [FulfilmentNotesController::class, 'destroy'])->name('case.notes.delete');

    }); // <<--Fulfilment End-->

    //<----ERP Admin Start---->//
    Route::prefix('erp/admin')->group(function () {

        //<--Users-->//
        Route::get('/company/users/index', [UserController::class, 'companyUser'])->name('company.users.index');
        Route::get('/company/users', [UserController::class, 'userCreate'])->name('company.users');
        Route::post('/company/users/store', [UserController::class, 'userStore'])->name('company.users.store');
        Route::get('/company/users/detail/{id}', [UserController::class, 'companyUserDetail'])->name('company.user.detail');
        Route::post('/allow/permisssions', [UserController::class, 'allowPermission'])->name('allow.permissions');
        Route::post('/add/role', [UserController::class, 'addRole'])->name('add.role');
        Route::delete('/company/user/delete/{id}', [UserController::class, 'delete'])->name('company-user-delete');
        Route::get('create/password', [UserController::class, 'createPassword'])->name('create-password');
        Route::post('update/password', [UserController::class, 'updatePassword'])->name('update-password');

        //<--Sale channel route-->//
        Route::resource('channels', SalesController::class);

        //<--Email Setting-->//
        Route::resource('email-settings', EmailSettingController::class);

        //<--Company-->//
        Route::resource('companies', CompanyController::class);
        Route::put('/company-address/{id}', [CompanyController::class, 'updateAddress'])->name('company-addresses.update');
        Route::get('/Supplier/Company/create', [CompanyController::class, 'createSupplierCompany'])->name('supplier.create');
        Route::get('/addressedit/{id}', [CompanyController::class, 'editAddress'])->name('company.addresss.edit');
        Route::delete('/addressdelete/{id}', [CompanyController::class, 'addressDelete'])->name('addresss.delete');
        Route::post('company-address', [CompanyController::class, 'addCompanyAddress'])->name('company-addresss.store');
        Route::get('/company/modules/permissions/{id}', [CompanyController::class, 'companyModulesPermissions'])->name('companies.modules.permissions');
        Route::post('/allow/company/permissions', [CompanyController::class, 'allowCompanyModulesPermission'])->name('allow.companies.modules.permissions');
        Route::get('companies/{id}/address/create', [CompanyController::class, 'createAddress'])->name('addresss.create');
        Route::get('company/roles/{id}', [CompanyController::class, 'CompanyRoles'])->name('companies.roles');
        Route::put('/address-update/{id}', [CompanyController::class, 'updateAddress'])->name('address.update');

        // beneficiary
        Route::resource('beneficiary', BeneficiaryController::class);
        Route::get('companies/{id}/beneficiary/create', [BeneficiaryController::class, 'create'])->name('beneficiary.create');
        Route::get('companies/{id}/beneficiary/{beneficiaryId}/edit', [BeneficiaryController::class, 'edit'])->name('beneficiary.edit');

        // intermediary
        Route::resource('intermediary', IntermediaryController::class);
        Route::get('companies/{id}/intermediary/create', [IntermediaryController::class, 'create'])->name('intermediary.create');
        Route::get('companies/{id}/intermediary/{intermediaryId}/edit', [IntermediaryController::class, 'edit'])->name('intermediary.edit');
        //<--Payment Gateway-->//
        Route::resource('payment-gateways', PaymentGatewayController::class);


        //<--Currency Conversion-->//
        Route::get('/currency-converters', [CurrencyExchangesController::class, 'conversionCreate'])->name('currency-converters');
    }); //<----ERP Admin End---->//

    //<----Fulfilment Admin Start---->//
    Route::prefix('fulfilment/admin')->group(function () {

        //Deliveries//
        Route::get('deliveries', [FulfilmentDeliveryController::class, 'Index'])->name('delivery.index');
        Route::put('deliveries/{id}', [FulfilmentDeliveryController::class, 'update'])->name('delivery.update');
        // Route::put('deliveriesStatus', [FulfilmentDeliveryController::class, 'updateStatus'])->name('deliveriesStatus.updateStatus');
        Route::get('tuffnell/file', [FulfilmentDeliveryController::class, 'tuffnellTxt'])->name('tuffnells.file');
        Route::get('export/tuffnell/file/{id}', [FulfilmentDeliveryController::class, 'export'])->name('export.tuffnells.file');
        Route::get('create/Manifest/file/{id}', [FulfilmentDeliveryController::class, 'createManifests'])->name('upload.manifests.file');
        Route::post('importfile/manifest/file', [FulfilmentDeliveryController::class, 'importManifests'])->name('import.manifest.file');
        Route::get('export/manifest/data/file/{id}', [FulfilmentDeliveryController::class, 'exportManifests'])->name('export.manifests.data.file');
        Route::get('view/manifest', [FulfilmentDeliveryController::class, 'viewManifest'])->name('manifests.view');
        // Route::get('export/tuffnell/file/{id}', [FulfilmentDeliveryController::class, 'export'])->name('export.tuffnells.file');
        // Route::put('deliveriesStatus', [FulfilmentDeliveryController::class, 'updateStatus'])->name('deliveriesStatus.updateStatus');
        Route::delete('/del/manifest/{id}', [FulfilmentDeliveryController::class, 'delManifest'])->name('del.manifest.data');
        Route::get('/edit/manifest/{id}', [FulfilmentDeliveryController::class, 'editManifest'])->name('edit.manifest.data');
        Route::put('manifest/update/{id}', [FulfilmentDeliveryController::class, 'updateManifest'])->name('manifestsUpdate');
        Route::get('delivery/show/{id}', [FulfilmentDeliveryController::class, 'show'])->name('deliveries.show');
        // picking list
        Route::get('/pickingList/{id}', [FulfilmentDeliveryController::class, 'pickingListIndex'])->name('pickings.list');

        Route::get('/pickingList/file/{id}', [FulfilmentDeliveryController::class, 'pickingListfile'])->name('picking.list.file');
        // delivery-inspection
        Route::get('/delivery-inspection/{id}', [FulfilmentDeliveryController::class, 'deliveryInspection'])->name('deliveries.inspection');
        Route::get('/delivery-inspection/file/export/{id}', [FulfilmentDeliveryController::class, 'DeliveryInspectionpdf'])->name('inspection.export.pdf');
        Route::get('/delivery-inspection/file/{id}', [FulfilmentDeliveryController::class, 'DeliveryInspectioncsv'])->name('inspection.export.csv');
        Route::post('/delivery/inspected/store', [FulfilmentDeliveryController::class, 'deliveryInspected'])->name('delivery.inspected');

        //<--Users-->//
        Route::get('/company/users/index', [FulfilmentUserController::class, 'companyUser'])->name('companys.users.index');
        Route::get('/company/users', [FulfilmentUserController::class, 'userCreate'])->name('companys.users');
        Route::post('/company/users/store', [FulfilmentUserController::class, 'userStore'])->name('companys.users.store');
        Route::get('/company/users/detail/{id}', [FulfilmentUserController::class, 'companyUserDetail'])->name('companys.user.detail');
        Route::post('/allow/permisssions', [FulfilmentUserController::class, 'allowPermission'])->name('allow.permissions');
        Route::post('/add/role', [FulfilmentUserController::class, 'addRole'])->name('add.role');
        Route::delete('/company/user/delete/{id}', [FulfilmentUserController::class, 'delete'])->name('company-user-delete');
        Route::get('create/password', [FulfilmentUserController::class, 'createPassword'])->name('create-password');
        Route::post('update/password', [FulfilmentUserController::class, 'updatePassword'])->name('update-password');
        //<--warehouse-->//
        //<--Building Routes-->//
        Route::resource('building', BuildingController::class);
        Route::get('building/{building}', [BuildingController::class, 'show'])->name('building.show');
        Route::resource('section', SectionController::class);
        Route::get('building/{building}/section/{section}', [SectionController::class, 'show'])->name('section.show');
        Route::get('/section/destroy/{id}', [SectionController::class, 'destroy'])->name('section.destroy');
        Route::resource('aisle', AisleController::class);
        Route::get('building/{building}/section/{section}/aisle/{aisle}', [AisleController::class, 'show'])->name('aisle.show');
        Route::get('/aisle/destroy/{id}', [AisleController::class, 'destroy'])->name('aisle.destroy');
        Route::resource('bay', BayController::class);
        Route::get('building/{building}/section/{section}/aisle/{aisle}/bay/{bay}', [BayController::class, 'show'])->name('bay.show');
        Route::get('/bay/destroy/{id}', [BayController::class, 'destroy'])->name('bay.destroy');
        Route::resource('level', LevelController::class);
        Route::get('building/{building}/section/{section}/aisle/{aisle}/bay/{bay}/level/{level}', [LevelController::class, 'show'])->name('level.show');
        Route::get('/level/destroy/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
        Route::resource('bin', BinController::class);
        Route::get('building/{building}/section/{section}/aisle/{aisle}/bay/{bay}/level/{level}/bin/{bin}', [BinController::class, 'show'])->name('bin.show');
        Route::get('/bin/destroy/{id}', [BinController::class, 'destroy'])->name('bin.destroy');
        Route::get('building-import-export', [BuildingImportExportController::class, 'buildingImportExport'])->name('building.import.export');
        Route::post('building-file-import', [BuildingImportExportController::class, 'fileImport'])->name('building.file.import');
        Route::get('building-all-export', [BuildingImportExportController::class, 'buildingAllExport'])->name('building.all.export');

        // imports

        Route::resource('stocks', StockController::class);
        Route::get('products/exportcsv', [ProductController::class, 'productExport'])->name('product.export.csv');
        Route::get('products/exportcsv', [ProductController::class, 'productExport'])->name('product.export.csv');

        //<--Email Setting-->//
        Route::resource('email-setting', FulfilmentEmailSettingController::class);

        //<--Company-->//
        Route::resource('company', FulfilmentCompanyController::class);
        Route::put('/company-address/{id}', [FulfilmentCompanyController::class, 'updateAddress'])->name('company-addresss.update');
        Route::get('/addressedit/{id}', [FulfilmentCompanyController::class, 'editAddress'])->name('company.addresses.edit');
        Route::delete('/addressdelete/{id}', [FulfilmentCompanyController::class, 'addressDelete'])->name('address.delete');
        Route::post('company-address', [FulfilmentCompanyController::class, 'addCompanyAddress'])->name('company-addresses.store');
        Route::get('/company/modules/permissions/{id}', [FulfilmentCompanyController::class, 'companyModulesPermissions'])->name('company.modules.permissions');
        Route::post('/allow/company/permissions', [FulfilmentCompanyController::class, 'allowCompanyModulesPermission'])->name('allow.company.modules.permissions');
        Route::get('companies/{id}/address/create', [FulfilmentCompanyController::class, 'createAddress'])->name('address.create');
        Route::get('company/roles/{id}', [FulfilmentCompanyController::class, 'CompanyRoles'])->name('company.roles');
        // beneficiary
        Route::resource('beneficiarys', FulfilmentBeneficiaryController::class);
        Route::get('companies/{id}/beneficiary/create', [FulfilmentBeneficiaryController::class, 'create'])->name('beneficiarys.create');
        Route::get('companies/{id}/beneficiary/{beneficiaryId}/edit', [FulfilmentBeneficiaryController::class, 'edit'])->name('beneficiarys.edit');
        // intermediary
        Route::resource('intermediary', IntermediaryController::class);
        Route::get('companies/{id}/intermediary/create', [IntermediaryController::class, 'create'])->name('intermediary.create');
        Route::get('companies/{id}/intermediary/{intermediaryId}/edit', [IntermediaryController::class, 'edit'])->name('intermediary.edit');


        //<---Quotes Start--->//

        //<--Quote Request-->//
        Route::resource('quotation-requests', QuotationRequestController::class);

        //<--Quote Response-->//
        Route::resource('quotations', QuotationController::class);
        Route::resource('quotationItem', QuotationItemController::class);
        Route::get('quotation/item/{id}', [QuotationItemController::class, 'create'])->name('quotationItem.create');

        //<---Quote Question-->//
        Route::resource('questionnaires', QuestionnaireController::class);

        // Label Delivery
        Route::resource('label-deliveries', LabelDeliveryController::class);
        // Review
        Route::resource('reviews', ReviewsController::class);
        Route::get('export/reviews', [ReviewsController::class, 'export'])->name('reviews.export');

        //    product route
        Route::get('res-search', [ProductTitleController::class, 'search']);
        Route::get('product-search', [ProductTitleController::class, 'getProductName']);

        Route::resource('warehouse-stocks', WarehouseStockController::class);
        Route::resource('product-stocks', ProductStockController::class);

    });  //<----Fulfilment Admin End---->//

    //<--Super Admin Start-->//
    Route::prefix('super/admin')->group(function () {
        //<--Company-->//
        Route::resource('companys', SuperAdminCompanyController::class);
        Route::put('/company-address/{id}', [SuperAdminCompanyController::class, 'updateAddress'])->name('company-address.update');
        Route::get('companys/{id}/address/create', [SuperAdminCompanyController::class, 'createAddress'])->name('addresses.create');
        Route::post('company-address', [SuperAdminCompanyController::class, 'addCompanyAddress'])->name('company-address.store');
        Route::get('/addressedit/{id}', [SuperAdminCompanyController::class, 'editAddress'])->name('companys.address.edit');
        Route::delete('/addressesdelete/{id}', [SuperAdminCompanyController::class, 'addressDelete'])->name('address.delete');
        Route::get('/company/modules/permissions/{id}', [SuperAdminCompanyController::class, 'companyModulesPermissions'])->name('companys.modules.permissions');
        Route::post('/allow/company/permissions', [SuperAdminCompanyController::class, 'allowCompanyModulesPermission'])->name('allow.companys.modules.permissions');
        Route::get('company/roles/{id}', [SuperAdminCompanyController::class, 'CompanyRoles'])->name('companys.roles');
        // beneficiary
        Route::resource('beneficiaries', SuperAdminBeneficiaryController::class);
        Route::get('companies/{id}/beneficiary/create', [SuperAdminBeneficiaryController::class, 'create'])->name('beneficiaries.create');
        Route::get('companies/{id}/beneficiary/{beneficiaryId}/edit', [SuperAdminBeneficiaryController::class, 'edit'])->name('beneficiaries.edit');
        // intermediary
        Route::resource('intermediary', IntermediaryController::class);
        Route::get('companies/{id}/intermediary/create', [IntermediaryController::class, 'create'])->name('intermediaries.create');
        Route::get('companies/{id}/intermediary/{intermediaryId}/edit', [IntermediaryController::class, 'edit'])->name('intermediaries.edit');

        //<--Modules-->//
        Route::resource('modules', ModuleController::class);

        //<--Packages-->//
        Route::resource('packages', PackageController::class);

        //<--Roles-->//
        Route::resource('roles', RoleController::class);

        //<--Exchange Rate-->//
        Route::resource('exchanges-rates', CurrencyExchangesController::class);
        Route::get('/search-rate', [CurrencyExchangesController::class, 'rate']);

        // Courriers
        Route::resource('courriers', CourrierController::class);
        Route::get('courrier-address/{id}', [CourrierController::class, 'createCourrierAddress'])->name('courrier.address.create');
        Route::post('/courrier-address/addressstore', [CourrierController::class, 'addressStore'])->name('address-store');
        Route::get('/address/edit/{id}', [CourrierController::class, 'editAddress'])->name('address.edit');
        Route::delete('/addressdelete/{id}', [CourrierController::class, 'addressDelete'])->name('address.delete');
    }); //<---Super Admin End--->//

    //<--Cores-->//
    Route::resource('cores', CoreController::class);

    // Route::namespace('company')->prefix('company')->group(function () {
    // });


    // Document routes
    Route::resource('documents', DocumentController::class);

    // Collection Route
    Route::resource('collections', CollectionController::class);

//    Route::put('update/feedback/{id}', [FeedbackController::class, 'subscription'])->name('feedback.update');

    //  Sample
    Route::resource('sample', SampleController::class);
    Route::get('export/attachment/{id}', [EmailController::class, 'export'])->name('export.attachment');
    Route::resource('calendar', CalenderController::class);

    Route::get('calendar/orders', [CalenderController::class, 'orders'])->name('calender.orders');


    // Route::get('/search_events', [CalenderController::class, 'searchEvent']);


    Route::get('attendence-file-export/{id}', [AttendencesImportController::class, 'fileExport'])->name('attendence.file.export');
    // Route::get('export', [MyController::class, 'export'])->name('export');
    Route::delete('attendence-file-delete/{id}', [AttendencesImportController::class, 'destroy'])->name('attendence.file.delete');
    Route::get('/search_events', [CalenderController::class, 'searchEvent']);



    // Route::get('/search-orders', [CalenderController::class, 'searchOrder']);

    // Route::get('/search-order-events', [CalenderController::class, 'searchOrderEvent']);

    // Route::get('/search-delivery-events', [CalenderController::class, 'searchDeliveryEvent']);

    // Route::get('/search-collection-events', [CalenderController::class, 'searchCollectionEvent'])->name('search-collection-events');

    // Route::get('/search-container-events', [CalenderController::class, 'searchContainerEvent'])->name('search-container-events');


    // Route::get('/order-events', [CalenderController::class, 'orderEvent'])->name('order-events');

    // Route::get('/delivery-events', [CalenderController::class, 'deliveryEvent'])->name('delivery-events');

    // Route::get('/collection-events', [CalenderController::class, 'collectionEvent'])->name('collection-events');

    // Route::get('/container-events', [CalenderController::class, 'containerEvent'])->name('container-events');

//    Route::get('export', [MyController::class, 'export'])->name('export');

});
