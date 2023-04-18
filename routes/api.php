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
use App\Http\Controllers\AllFieldsColumnController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\EmailController;

// Public Routes
    
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
    Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);
    Route::get('/getcity/{id}', [Contact::class, 'getcity']);
    Route::get('/userList', [UserController::class, 'userList']);
    Route::post('/addCompany', [CompanyController::class, 'addCompany']);
    Route::get('/roles', [RoleController::class,'index']);
    Route::post('/roles', [RoleController::class,'store']);
    Route::put('/roles/{id}', [RoleController::class,'update']);
    Route::delete('/roles/{id}', [RoleController::class,'destroy']);
    
// Protected Routes

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/register', [UserController::class, 'register_user']);
    //user logged and logout route
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/loggeduser', [UserController::class, 'logged_user']);

    //lead route
    Route::post('/import-leads',[ExcelController::class,'fileImport']);
    Route::get('/export-leads',[ExcelController::class,'fileExport']);
    Route::get('/leadList', [CreateLeadController::class, 'userLead']);
    Route::get('/showSingleLead/{uuid}', [CreateLeadController::class, 'showSingleLead']);
    Route::post('/CreateLead', [CreateLeadController::class, 'CreateUserLead']);
    Route::delete('/destroyLead/{id}', [CreateLeadController::class, 'destroyLead']);
    Route::put('/updateLead/{uuid}', [CreateLeadController::class, 'updateLead']);
    Route::delete('/deleteAllLeads', [CreateLeadController::class, 'deleteAllLeads']);
    Route::get('/searchlead', [CreateLeadController::class, 'searchlead']);
    Route::get('/paginateData', [CreateLeadController::class, 'paginateData']);
    
    //change password route
    Route::post('/changepassword', [UserController::class, 'change_password']);
    //company route
    
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
    Route::delete('/deleteAllTasks', [TaskController::class, 'deleteAllTasks']);
    //role and permission route
    Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'givePermissionToRole'])
    ->name('roles.givePermissionToRole');

    //product route
    Route::post('/createProduct', [ProductController::class, 'createProduct']);
    Route::get('/showProductList', [ProductController::class, 'showProductList']);
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/updateProduct/{id}', [ProductController::class, 'updateProduct']);

    //AllFieldColumns

    Route::post('/showallfieldcolumns',[AllFieldsColumnController::class,'showallfieldcolumns']);
    Route::post('/Createallfieldcolumns',[AllFieldsColumnController::class,'Createallfieldcolumns']);

    //Role Route

    Route::post('/createRole',[RoleController::class,'createRole']);
    Route::get('/showRole',[RoleController::class,'showRole']);
    Route::get('/getRolesHierarchy',[RoleController::class,'getRolesHierarchy']);

    //Employee Route
    Route::post('/storeEmployee', [EmployeeController::class, 'storeEmployee']);
    Route::get('/empsearchdata', [EmployeeController::class, 'index']);
    Route::get('/getemployee', [EmployeeController::class, 'getemp']);
    Route::put('/updateEmployee/{id}', [EmployeeController::class, 'updateEmployee']);

    //History Route 
    Route::get('/getHistory/{uuid}', [HistoryController::class, 'getHistory']);

    //Meeting Route
    Route::post('/createMeeting', [MeetingController::class, 'createMeeting']);
    Route::get('/showMeetings', [MeetingController::class,'showMeetings']);
    Route::put('/updateMeetings/{id}', [MeetingController::class, 'updateMeetings']);
    Route::delete('/deleteMeetings/{id}', [MeetingController::class, 'deleteMeetings']);
    Route::get('/showSingMeetings/{id}', [MeetingController::class, 'showSingMeetings']);
    Route::get('/getMeetingsHierarchy', [MeetingController::class, 'getMeetingsHierarchy']);
    Route::get('/getMeetingsByDepartment', [MeetingController::class, 'getMeetingsByDepartment']);
    Route::get('/getMeetingsByDepartmentHierarchy', [MeetingController::class, 'getMeetingsByDepartmentHierarchy']);
    Route::get('/getMeetingsByStatus', [MeetingController::class, 'getMeetingsByStatus']);
     
    //Mailling route
      Route::post('/send-email', [EmailController::class, 'sendEmail']);
     //Route::post('/send-email/{recipient}', [EmailController::class,'sendEmail']);


});