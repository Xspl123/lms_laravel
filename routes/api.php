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
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;

// Public Routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
    Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);
    Route::get('/getcity/{id}', [Contact::class, 'getcity']);
    

// Protected Routes

Route::middleware(['auth:sanctum'])->group(function(){
    //user logged and logout route
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/loggeduser', [UserController::class, 'logged_user']);
    //lead route
    Route::get('/leadList', [CreateLeadController::class, 'userLead']);
    Route::get('/showSingleLead/{uuid}', [CreateLeadController::class, 'showSingleLead']);
    Route::post('/CreateLead', [CreateLeadController::class, 'CreateUserLead']);
    Route::delete('/destroyLead/{id}', [CreateLeadController::class, 'destroyLead']);
    Route::put('/updateLead/{id}', [CreateLeadController::class, 'updateLead']);
    //change password route
    Route::post('/changepassword', [UserController::class, 'change_password']);
    //company route
    Route::post('/addCompany', [CompanyController::class, 'addCompany']);
    Route::get('/showCompanyList', [CompanyController::class, 'showCompany']);
    Route::delete('/deleteCompany/{id}', [CompanyController::class, 'deleteCompany']);
    Route::put('/updateCompany/{id}',[CompanyController::class,'updateCompany']);
    //contact route
    Route::post('/addContact', [Contact::class, 'addContact']);
    Route::get('/showContactList', [Contact::class, 'showContactList']);
    Route::delete('/deleteContactbyId/{id}', [Contact::class, 'deleteContactbyId']);
    Route::put('/updateContact/{id}', [Contact::class, 'updateContact']);
    //deal route
    Route::post('/storeDeal', [DealController::class, 'storeDeal']);
    Route::get('/showDealList', [DealController::class, 'showDealList']);
    Route::delete('/deleteDeal/{id}', [DealController::class, 'deleteDeal']);
    Route::put('/updateDeal/{id}', [DealController::class, 'updateDeal']);
    // client route
    Route::get('/showClientList', [ClientController::class, 'showClientList']);
    Route::post('/addClient', [ClientController::class, 'addClient']);
    Route::delete('/destroyClient/{id}',[ClientController::class,'destroyClient']);
    Route::put('/updateClient/{id}',[ClientController::class,'updateClient']);
    //task route
    Route::post('/createTask', [TaskController::class, 'createTask']);
    Route::get('/showTaskList', [TaskController::class, 'showTaskList']);
    Route::put('/updateTask/{id}', [TaskController::class, 'updateTask']);
    Route::delete('/deleteTask/{id}', [TaskController::class, 'deleteTask']);
    //role and permission route
    Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'givePermissionToRole'])
    ->name('roles.givePermissionToRole');

    //product route
    Route::post('/createProduct', [ProductController::class, 'createProduct']);
    Route::get('/showProductList', [ProductController::class, 'showProductList']);
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/updateProduct/{id}', [ProductController::class, 'updateProduct']);
});