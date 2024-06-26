<?php

use App\Http\Controllers\Admin\AgentCarTranferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YardController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BankTransactionController;
use App\Http\Controllers\Admin\VaultController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\companyInvoiceController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SuperagentController;
use App\Http\Controllers\Admin\MoneyTransferController;
use App\Http\Controllers\Admin\CompanyServicesController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\CompanyTransportationController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\ShipmentController;

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


Route::get('test', function () {
    // return adminDbTablesPermissions();
});

Route::get('/index', function () {

    return view('welcome');
});

Auth::routes();


// ----------------- companyInvoice -----------------
Route::prefix('companyInvoice')->group(function () {
    Route::get('/{id}', [companyInvoiceController::class, 'index'])->name('companyInvoice.index');
    Route::get('/{id}/create', [companyInvoiceController::class, 'create'])->name('companyInvoice.create');
    Route::get('/{id}/edit', [companyInvoiceController::class, 'edit'])->name('companyInvoice.edit');
    Route::post('/store', [companyInvoiceController::class, 'store'])->name('companyInvoice.store');
    Route::put('/{id}/update', [companyInvoiceController::class, 'update'])->name('companyInvoice.update');
    Route::delete('/{id}/destroy', [companyInvoiceController::class, 'destroy'])->name('companyInvoice.destroy');
    Route::get('/export/{from}/{to}/{company_id}', [companyInvoiceController::class, 'export'])->name('companyInvoice.export');
});
// ----------------- companyInvoice -----------------

// ----------------- CarShipments -----------------
Route::prefix('car_shipments')->group(function () {
    Route::get('/{id}/car', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/{id}/create', [ShipmentController::class, 'create'])->name('shipments.create');
    Route::get('/{id}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
    Route::post('/store', [ShipmentController::class, 'store'])->name('shipments.store');
    Route::put('/{id}/update', [ShipmentController::class, 'update'])->name('shipments.update');
    Route::delete('/{id}/destroy', [ShipmentController::class, 'destroy'])->name('shipments.destroy');
    Route::get('/{id}/export', [ShipmentController::class, 'export'])->name('shipments.export');
});
// ----------------- CarShipments -----------------




// ----------------- Dashboard -----------------
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth'], 'prefix' => 'dashboard'], function () {

    Route::get('/language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    });

    Route::get('/', DashbaordController::class)->name('main');

    // ----------------- Permissions -----------------
    Route::resource('permissions', PermissionController::class);
    // ----------------- Permissions -----------------


    // ----------------- manageUsers -----------------
    Route::resource('users', UserController::class);
    // ----------------- manageUsers -----------------





    // ----------------- Containers -----------------
    Route::resource('containers', ContainerController::class);
    // ----------------- \Containers -----------------

    // ----------------- Companies -----------------
    Route::resource('companies', CompanyController::class);

    Route::get('company/employee/{company}', 'App\Http\Controllers\Admin\CompanyController@getEmployees')->name('company.employee');
    // ----------------- \Companies -----------------

    // ----------------- Cities & Regions -----------------
    Route::resource('citiesAndRegions', CitiesAndRegionsController::class);
    // ----------------- \Cities & Regions -----------------

    // ----------------- Employees -----------------
    Route::resource('employees', EmployeeController::class);
    // ----------------- \Employees -----------------

    // ----------------- Factories -----------------
    Route::resource('factories', FactoryController::class);
    Route::get('factories/branches/{factory}', 'App\Http\Controllers\Admin\FactoryController@getBranches')->name('factory.branches');
    // ----------------- \Factories -----------------

    // ----------------- Branches -----------------
    Route::resource('branches', BranchController::class);
    // ----------------- \Branches -----------------

    // ----------------- Bookings -----------------
    Route::resource('bookings', BookingController::class);

    // invoices ----------------------------------------------------------------
    Route::get('bookings-invoices/{id?}', [InvoicesController::class, 'index'])->name('bokkings.invoices');
    Route::get('bookings-invoices-exports/{id?}', [InvoicesController::class, 'export'])->name('bookings.invoices.exports');
    Route::get('/download-invoice/{companyId?}', [InvoicesController::class, 'downloadPDF'])->name('bookings.invoices.pdf');


    // invoices ----------------------------------------------------------------

    Route::get("booking_papers/{booking}", [BookingController::class, "booking_papers"])->name("bookings.booking_papers");
    // ----------------- Booking Containers -----------------
    Route::resource(
        'booking-containers',
        Booking\BookingContainerController::class,
        ['only' => ['edit', 'update', 'destroy']]
    );
    // ----------------- \Booking Containers -----------------
    Route::group(
        [
            'prefix' => 'bookings/{booking}',
        ],
        function () {
            // ----------------- Booking Containers -----------------
            Route::resource(
                'booking-containers',
                Booking\BookingContainerController::class,
                ['only' => ['create', 'store']]
            );
            // ----------------- \Booking Containers -----------------
            // ----------------- Booking Services -----------------
            Route::resource(
                'booking-services',
                Booking\BookingServiceController::class,
                ['only' => ['create', 'store']]
            );
            // ----------------- \Booking Services -----------------

            // ----------------- Booking Invoices -----------------
            Route::resource(
                'booking-invoices',
                Booking\BookingInvoiceController::class,
                [
                    'only' => ['create', 'store'],
                ]
            );
            // ----------------- \Booking Invoices -----------------
        }
    );

    Route::delete(
        'booking-services/{booking_service}',
        'Booking\BookingServiceController@destroy'
    )->name('booking-services.destroy');
    // ----------------- \Bookings -----------------

    // ----------------- Invoices -----------------
    Route::resource(
        'booking-invoices',
        Booking\BookingInvoiceController::class,
        [
            'only' => ['show', 'edit', 'update'],
        ]
    );
    // ----------------- \Invoices -----------------

    // ----------------- Transportation -----------------
    Route::resource('companyTransportations', CompanyTransportationController::class);
    Route::post('companyTransportations/import', [CompanyTransportationController::class, 'import'])->name('companyTransportations.import');
    Route::resource('{company}/companyServices', CompanyServicesController::class)->except('show');
    Route::post('{company}/companyServices/import', [CompanyServicesController::class, 'import'])->name('companyServices.import');
    // ----------------- \Transportation -----------------

    // ----------------- serviceCategories -----------------
    Route::resource('serviceCategories', ServiceCategoryController::class);
    // ----------------- \serviceCategories -----------------

    // ----------------- Services -----------------
    Route::resource('services', ServiceController::class);

    Route::post('services/import', [ServiceController::class, 'import'])->name('services.import');
    // ----------------- \Services -----------------

    // ----------------- StaticPages -----------------
    Route::resource('staticPages', StaticPageController::class);
    // ----------------- \StaticPages -----------------

    // ------------------ Our-Serivce ------------------
    Route::resource('ourServices', OurServiceController::class);

    // ------------------ Choose-Us ------------------
    Route::resource('chooseUs', ChooseUsController::class);

    // ------------------ Sponsers ------------------
    Route::resource('sponsers', SponserController::class);

    // ------------------ Reviews ------------------
    Route::resource('reviews', ReviewController::class);

    // ------------------ Settings ------------------
    Route::resource('settings', SettingController::class)->only('edit', 'update');

    // ------------------ shippingAgents ------------------
    Route::resource('shippingAgents', ShippingAgentController::class);

    // ------------------ Contact-Us ------------------
    Route::resource('contactUs', ContactUsController::class)->only('index', 'destroy');

    // ----------------- superagents -----------------
    Route::resource('superagents', SuperagentController::class);
    // ----------------- \superagents -----------------

    // ----------------- agents -----------------
    Route::resource('agents', AgentController::class);
    // ----------------- \agents -----------------

    // ----------------- \agent car tranfer -----------------
    Route::prefix('banktransactions')->group(function () {
        Route::post('/store', [BankTransactionController::class, 'store'])->name('banktransactions.store');
        Route::get('/{id}', [BankTransactionController::class, 'index'])->name('banktransactions.index');
        Route::get('/{id}/create', [BankTransactionController::class, 'create'])->name('banktransactions.create');
        Route::get('/{id}/edit', [BankTransactionController::class, 'edit'])->name('banktransactions.edit');
        Route::put('/{id}/update', [BankTransactionController::class, 'update'])->name('banktransactions.update');
        Route::delete('/{id}/destroy', [BankTransactionController::class, 'destroy'])->name('banktransactions.destroy');
        Route::get('/{id}/export', [BankTransactionController::class, 'export'])->name('banktransactions.export');
    });
    // ----------------- \agent car tranfer -----------------

    // ----------------- yards -----------------
    Route::resource('yards', YardController::class);
    // ----------------- \yards -----------------

    // ----------------- financial_custody_agents -----------------
    Route::resource('financial_custody_agents', MoneyTransferController::class)->except('show', 'edit', 'update');
    // ----------------- \financial_custody_agents -----------------

    // ----------------- drivers -----------------
    Route::resource('drivers', DriverController::class);
    // ----------------- drivers -----------------

    // ----------------- vaults -----------------
    Route::resource('vaults', VaultController::class);
    Route::get('vaults-exports', [VaultController::class, 'export'])->name('vaults.export');
    // ----------------- vaults -----------------


    // ----------------- banks -----------------
    Route::resource('banks', BankController::class);
    Route::prefix('agent_car_transfer')->group(function () {
        Route::post('/store', [AgentCarTranferController::class, 'store'])->name('agent_car_tranfer.store');
        Route::get('/{id}', [AgentCarTranferController::class, 'index'])->name('agent_car_tranfer.index');
        Route::get('/{id}/create', [AgentCarTranferController::class, 'create'])->name('agent_car_tranfer.create');
        Route::get('/{id}/edit', [AgentCarTranferController::class, 'edit'])->name('agent_car_tranfer.edit');
        Route::put('/{id}/update', [AgentCarTranferController::class, 'update'])->name('agent_car_tranfer.update');
        Route::delete('/{id}/destroy', [AgentCarTranferController::class, 'destroy'])->name('agent_car_tranfer.destroy');
        Route::get('/{id}/export', [AgentCarTranferController::class, 'export'])->name('agent_car_tranfer.export');
    });

    // ----------------- banks -----------------

    // ----------------- cars -----------------
    Route::resource('cars', CarController::class);
    // ----------------- cars -----------------

    Route::get('/agent_reports/{agent}', [ReportController::class, 'agent_reports'])->name('reports.agent_reports');
    Route::get('/agent_expenses/{agent}', [ExpenseController::class, 'agent_expenses'])->name('expenses.agent_expenses');

    Route::get('/daily_reports', [ReportController::class, 'daily_reports'])->name('reports.daily_reports');
});
// ----------------- \Dashboard -----------------


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('dashboard/get/services/{serviceCategories}', [ServiceController::class, 'getServices'])->name('services.getServices');
