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
    use App\Http\Controllers\IndustryController;
    use App\Http\Controllers\AccountController;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\EmailConfirmationController;
    use App\Http\Controllers\LicenceController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\LeadExportController;
    use App\Http\Controllers\LeadImportController;


// Public Routes
Route::get('/showProductList', [ProductController::class, 'showProductList']);

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
    Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);
    Route::get('/getcity/{id}', [Contact::class, 'getcity']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('/addCompany', [CompanyController::class, 'addCompany']);
    Route::get('/roles', [RoleController::class,'index']);
    Route::post('/roles', [RoleController::class,'store']);
    Route::put('/roles/{id}', [RoleController::class,'update']);
    Route::post('/register', [UserController::class, 'register_user']);

// Protected Routes

Route::middleware(['auth:sanctum'])->group(function(){
    //user logged and logout route
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/loggeduser', [UserController::class, 'logged_user']);
    Route::get('/userList', [UserController::class, 'userList']);
    Route::get('/singleUser/{id}', [UserController::class, 'singleUser']);
    Route::post('/change_password', 'App\Http\Controllers\UserController@change_password');
    Route::put('/update-users/{user}', [UserController::class,'updateUser']);
    Route::delete('/user/{id}', [UserController::class,'destroy']);
    Route::get('/token-basis-user-details', [UserController::class,'getUserDetails']);
    //lead route
    Route::post('/import-leads',[LeadImportController::class,'Import']);
    // Route::get('/export-leads',[ExcelController::class,'fileExport']);
    Route::get('/export-leads',[LeadExportController::class,'exportLeads']);
    Route::get('/leadList', [CreateLeadController::class, 'userLead']);
    
    Route::get('/showSingleLead/{uuid}', [CreateLeadController::class, 'showSingleLead']);
    Route::post('/CreateLead', [CreateLeadController::class, 'CreateUserLead']);
    Route::delete('/destroyLead/{uuid}', [CreateLeadController::class, 'destroyLead']);
    Route::put('/updateLead/{uuid}', [CreateLeadController::class, 'updateLead']);
    Route::delete('/deleteAllLeads', [CreateLeadController::class, 'deleteAllLeads']);
    // Route::get('/searchlead', [CreateLeadController::class, 'searchlead']);
    Route::get('/search_leads/search', [CreateLeadController::class, 'searchlead']);
    Route::get('/paginateData', [CreateLeadController::class, 'paginateData']);
    Route::get('/leadWithUserRole',[CreateLeadController::class,'leadWithUserRole']);
    Route::get('/leads/{leadId}', [CreateLeadController::class,'show']);
    Route::get('/getLeadCount', [CreateLeadController::class,'getLeadCount']);

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
    Route::get('/showSingTasks/{id}', [TaskController::class, 'showSingTasks']);
    Route::get('/searchTask/search', [TaskController::class, 'search']);

    //role and permission route
    Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'givePermissionToRole'])
    ->name('roles.givePermissionToRole');

    //product route
    Route::post('/createProduct', [ProductController::class, 'createProduct']);
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/updateProduct/{id}', [ProductController::class, 'updateProduct']);

    //AllFieldColumns

    Route::post('/showallfieldcolumns',[AllFieldsColumnController::class,'showallfieldcolumns']);
    Route::post('/Createallfieldcolumns',[AllFieldsColumnController::class,'Createallfieldcolumns']);

    //Role Route

    Route::post('/createRole',[RoleController::class,'createRole']);
    Route::get('/showRole',[RoleController::class,'showRole']);
    Route::get('/getRolesHierarchy',[RoleController::class,'getRolesHierarchy']);
    Route::delete('/roles/{id}', [RoleController::class,'destroy']);
    
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
    Route::delete('/deleteAllMeetings', [MeetingController::class, 'deleteAllMeetings']);
    Route::get('/searchMeeting/search', [MeetingController::class, 'search']);

    //Mailling routeṭ
      Route::post('/send-email', [EmailController::class, 'sendEmail']);
     //Route::post('/send-email/{recipient}', [EmailController::class,'sendEmail']);

    //Industry Route
    Route::post('/create-industry', [IndustryController::class,'createIndustry']);
    Route::get('/show-industry', [IndustryController::class,'showIndustry']);

    // Account route
    Route::post('/create-account', [AccountController::class,'createAccount']);
    Route::put('/updateAccount/{uuid}', [AccountController::class, 'updateAccount']);
    Route::get('/show-account-deatils', [AccountController::class, 'showAccount']);
    Route::delete('/delete-account/{id}', [AccountController::class, 'deleteAccount']);

    //Email confirmation route
    Route::get('/getEmailConfirmationDetails', [EmailConfirmationController::class,'getEmailConfirmationDetails']);
    Route::post('/send-email-confirmation', [EmailConfirmationController::class,'sendEmailConfirmation']);

    //Liences route
    Route::post('/createLience', [LicenceController::class, 'createLience']);
    Route::get('/showLiences', [LicenceController::class,'showLiences']);
    Route::delete('/deleteLience/{id}', [LicenceController::class, 'deleteLience']);
    Route::put('/updateLience/{id}', [LicenceController::class, 'updateLience']);
    Route::get('/getLiencesHierarchy', [LicenceController::class, 'getLiencesHierarchy']);
    Route::get('/getLiencesByStatus', [LicenceController::class, 'getLiencesByStatus']);
    Route::get('/getLiencesByDepartment', [LicenceController::class, 'getLiencesByDepartment']);
    Route::get('/getLiencesByDepartmentHierarchy', [LicenceController::class, 'getLiencesByDepartmentHierarchy']);


    //Profile
    Route::post('/createProfile', [ProfileController::class, 'createProfile']);
    Route::get('/showProfile', [ProfileController::class, 'showProfile']);
    Route::get('/singleProfile/{id}', [ProfileController::class, 'singleProfile']); 
    Route::put('/updateProfile/{id}', [ProfileController::class, 'updateProfile']);
    Route::delete('/delete-profile/{id}', [ProfileController::class, 'destroy']);

});