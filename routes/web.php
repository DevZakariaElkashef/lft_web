<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YardController;
use App\Http\Controllers\Admin\AgentController;
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

    // ----------------- yards -----------------
    Route::resource('yards', YardController::class);
    // ----------------- \yards -----------------

    // ----------------- financial_custody_agents -----------------
    Route::resource('financial_custody_agents', MoneyTransferController::class)->except('show', 'edit', 'update');
    // ----------------- \financial_custody_agents -----------------

    // ----------------- drivers -----------------
    Route::resource('drivers', DriverController::class);
    // ----------------- drivers -----------------

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
