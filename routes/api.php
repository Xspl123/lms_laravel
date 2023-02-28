<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CreateLeadController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Contact;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\DealController;


// Public Routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
    Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/showCompanyList', [CompanyController::class, 'showCompany']);
    Route::get('/getcity/{id}', [Contact::class, 'getcity']);
    //Route::get('/showDealList', [DealController::class, 'showDealList']);

// Protected Routes

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/loggeduser', [UserController::class, 'logged_user']);
    Route::get('/ShowUserLead', [CreateLeadController::class, 'userLead']);
    Route::post('/CreateUserLead', [CreateLeadController::class, 'CreateUserLead']);
    Route::delete('/destroyLead/{id}', [CreateLeadController::class, 'destroyLead']);
    Route::put('/updateLead/{id}', [CreateLeadController::class, 'updateLead']);
    Route::post('/changepassword', [UserController::class, 'change_password']);
    Route::post('/addCompany', [CompanyController::class, 'addCompany']);
    Route::get('/showCompanyList', [CompanyController::class, 'showCompany']);
    Route::post('/addContact', [Contact::class, 'addContact']);
    Route::get('/showContactList', [Contact::class, 'showContactList']);
    Route::delete('/deleteContactbyId/{id}', [Contact::class, 'deleteContactbyId']);
    Route::put('/updateContact/{id}', [Contact::class, 'updateContact']);
    Route::post('/storeDeal', [DealController::class, 'storeDeal']);
    Route::get('/showDealList', [DealController::class, 'showDealList']);
    Route::get('/showClientList', [ClientController::class, 'showClientList']);
    Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'givePermissionToRole'])
    ->name('roles.givePermissionToRole');
    
});