<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Contact;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\LeadExportController;
use App\Http\Controllers\LeadImportController;



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

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/file-import',[ExcelController::class,'fileImportExport'])->name('import-view');
Route::post('/import',[LeadImportController::class,'import'])->name('import');
Route::post('/import-leads',[LeadImportController::class,'Import']);
Route::get('/export-users',[LeadExportController::class,'exportLeads'])->name('export-users');



//Route::get('/register', [UserController::class, 'register']);


Route::post('excel/upload', [ExcelController::class,'upload']);
Route::post('excel/download', [ExcelController::class,'download']);

Route::get('/showCompanyList', [CompanyController::class, 'showCompany']);

Route::get('/FunctionName', [Contact::class, 'FunctionName']);
Route::get('/FunctionName', [Contact::class, 'FunctionName']);

Route::get('/index', [ClientController::class, 'index']);

Route::get('country', [CountryStateCityController::class, 'index']);
Route::get('get-states', [CountryStateCityController::class, 'getState']);
Route::post('get-cities', [CountryStateCityController::class, 'getCity']);



Route::post('/send-mail', function (Request $request) {
    $to = $request->input('to');
    $cc = $request->input('cc');
    $bcc = $request->input('bcc');
    $subject = $request->input('subject');
    $body = $request->input('body');

    Mail::to($to)->cc($cc)->bcc($bcc)->send(new MailForm($subject, $body));

    return redirect('/mail-form')->with('success', 'Mail sent successfully!');
})->name('send-mail');
