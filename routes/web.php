<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\HomePage;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;
use App\Http\Livewire\Customer;
use App\Http\Livewire\Operations;
use App\Http\Livewire\Finance;
use App\Http\Livewire\Jobstatus;
use App\Http\Livewire\Stations;
use App\Http\Livewire\Departments;
use App\Http\Livewire\Section;
use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\UserManagement;
use App\Http\Livewire\Service;
use App\Http\Livewire\Servicesgroups;
use App\Http\Livewire\Servicestypes;
use App\Http\Livewire\Brands;
use App\Http\Livewire\ItemCategories;
use App\Http\Livewire\ItemProductGroups;
use App\Http\Livewire\SalesItems;
use App\Http\Livewire\Checklists;
use App\Http\Livewire\Invoices;
use App\Http\Controllers\InvoiceExportPDFController;
use App\Http\Livewire\ServicesSectionGroup;
use App\Http\Livewire\ServicesMasterList;
use App\Http\Livewire\ServicesPriceList;
use App\Http\Livewire\CustomerTypes;
use App\Http\Livewire\Jobcard;
use App\Http\Livewire\Mechanical;
use App\Http\Livewire\CustomerCheckout;
use App\Http\Livewire\CarsTaxi;
use App\Http\Livewire\UpdateJobCards;
use App\Http\Livewire\VehicleSearchSave;
use App\Http\Livewire\CustomerServiceJob;
use App\Http\Livewire\SubmitCutomerServiceJob;
use App\Http\Livewire\UpdateJobCardSubmit;
use App\Http\Livewire\GatePasses;
use App\Http\Livewire\PackagesBookings;
use App\Http\Livewire\MaterialRequisition;
use App\Http\Livewire\Packages;
use App\Http\Livewire\CustomerServiceItems;
use App\Http\Livewire\Numberplates;

use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\UpdateJobCardsController;



use Illuminate\Http\Request;

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

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class);
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    //Job Start
    Route::get('job-start',VehicleSearchSave::class)->name('job-start');
    Route::get('customer-service-job/{customer_id}/{vehicle_id}',CustomerServiceJob::class)->name('customer-service-job');
    Route::get('submit-job/{customer_id}/{vehicle_id}', SubmitCutomerServiceJob::class)->name('submit-job');
    //UpdateCustomerJobs
    Route::get('customer-service-job/{customer_id}/{vehicle_id}/{job_number}',CustomerServiceJob::class)->name('customer-service-job-update');
    Route::get('submit-job-update/{customer_id}/{vehicle_id}/{job_number}', SubmitCutomerServiceJob::class)->name('submit-job-update');

    Route::get('customer-service-items/{customer_id}/{vehicle_id}', CustomerServiceItems::class)->name('customer-service-items');
    Route::get('customer-service-items/{customer_id}/{vehicle_id}/{job_number}', CustomerServiceItems::class)->name('customer-service-items-update');

    ;


    //PackagesBookings
    Route::get('submit-package/{customer_id}/{vehicle_id}/{package_id}', PackagesBookings::class)->name('submit-package');

    //oute::get('/', HomePage::class)->name('dashboard');
    //Route::get('/dashboard', HomePage::class)->name('dashboard');

    Route::get('/customer-job-update/{job_number}',Operations::class)->name('customer-jobs-update');
    Route::get('/jobs', Operations::class)->name('customer-jobs');
    Route::get('/jobs-filter/{filter}', Operations::class)->name('customer-job-filter');

    //Packages
    Route::get('/packages', Packages::class)->name('packages');



    Route::get('/job-accounts/{job_number}',Finance::class)->name('customer-jobs-report-details');
    Route::get('/jobs-report', Finance::class)->name('customer-jobs-reports');
    Route::get('/jobs-invoice', Invoices::class)->name('customer-jobs-invoices');
    Route::get('/invoice/{job_number}', [InvoiceExportPDFController::class, 'showinvoice'])->name('customer-jobs-invoice-details');
    Route::get('/jobs-accounts-filter/{filter}', Finance::class)->name('customer-job-account-filter');
    Route::get('/download-invoice/{job_number}', [InvoiceExportPDFController::class, 'invoiceExportPDF'])->name('invoiceexportPDF');


    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/stations',Stations::class)->name('stations-list');
    Route::get('/departments',Departments::class)->name('departments-list');
    Route::get('/sections',Section::class)->name('sections-list');
    Route::get('/gss-user-management', UserManagement::class)->name('user-management');
    Route::get('/vehiclestatus/{job_number}', Jobstatus::class)->name('vehicle-status');
    Route::get('/customers', Customer::class)->name('customers-list');

    Route::get('/services-prices-list',ServicesPriceList::class)->name('services-prices-list');
    Route::get('/services-master-list',ServicesMasterList::class)->name('services-master-list');
    Route::get('/services-section-group',ServicesSectionGroup::class)->name('services-section-group');
    Route::get('/services-groups',Servicesgroups::class)->name('services-groups');

    Route::get('/service-brand-list',Brands::class)->name('services-brands');
    Route::get('/item-categories-list',ItemCategories::class)->name('services-item-categories');
    Route::get('/item-product-group-list',ItemProductGroups::class)->name('item-product-groups');
    Route::get('/sales-items-list',SalesItems::class)->name('sales-items-list');
    
    Route::get('checklist',Checklists::class)->name('checklist');

    Route::get('customer-types',CustomerTypes::class)->name('customer-types');
    
    Route::get('job-card',Jobcard::class)->name('job-card');
    Route::get('/job-card/{customer_id}/{vehicle_id}',Jobcard::class)->name('pending-job-card-creation');
    Route::get('/job-card/{job_number}',Jobcard::class)->name('pending-job-card');
    Route::get('/customer-checkout/{customer_id}/{vehicle_id}',CustomerCheckout::class)->name('customer-checkout');
    Route::get('/customer-checkout/{job_details}',CustomerCheckout::class)->name('chustomer-checkout-job');

    //UpdateJobCardds
    Route::get('/update_jobcard/{job_number}',UpdateJobCards::class)->name('update_jobcard');
    Route::get('submit-jobcard-update/{job_number}', UpdateJobCardSubmit::class)->name('submit-jobcard-update');

    //GatePasses
    Route::get('gatepasses',GatePasses::class)->name('gatepasses');

    //Forman Material Requisition
    Route::get('material-requisition',MaterialRequisition::class)->name('material-requisition');


    //NumberPlate
    Route::get('number-plate-codes',Numberplates::class)->name('number-plate-codes');


    
    Route::get('mechanical',Mechanical::class)->name('mechanical');

    Route::get('kabil-llc', CarsTaxi::class)->name('kabil-llc');
});

Route::get('qr/{name}', [QrCodeController::class, 'qrcode']);

Route::get('/clear-all-cache',function(){
    Artisan::call('cache:clear');
    Artisan::call('storage:link');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    
    dd('cache clear all');
});