<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AllInOneController;
use App\Helpers\TableHelper;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\User;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUser;
use App\Exports\ExportUser;
use App\Models\Role;
use App\Models\Company;
use App\Models\CreateLeads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function register_user(Request $request){

         $campany_id = auth()->user()->company_id;
       
        $request->validate([
            'uname' => 'required|string',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'uphone' => 'required|string',
            'role_id' => 'required|numeric',
            'domain_name' =>'required',
            'uexperience' => 'required|string',
            'tc'=>'required',
        ]);
        if(User::where('email', $request->email)->first()){
            return response([
                'message' => 'Email already exists',
                'status'=>'failed'
            ], 200);
        }

        $user = User::create([
            'uname' => $request->uname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'uphone' => $request->uphone,
            'urole' => $request->urole,
            'domain_name' => $request->domain_name,
            'uexperience' => $request->uexperience,
            'company_id' => $campany_id,
            'role_id' =>  $request->role_id,
            'tc'=>json_decode($request->tc),
        ]);
        $token = $user->createToken($request->email)->plainTextToken;
        return response([
            'token'=>$token,
            'message' => 'Registration Success',
            'status'=>'success'
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
            $token = $user->createToken($request->email)->plainTextToken;
            //$user_details = User::all();
            //print_r($user_details); exit; 
            return response([
                'token'=>$token,
                'message' => 'Login Success',
                'status'=>'success',
                'user' => $user
            ], 200);
        }
        return response([
            'message' => 'The Provided Credentials are incorrect',
            'status'=>'failed'
        ], 401);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout Success',
            'status'=>'success'
        ], 200);
    }

    public function logged_user(){
        $company_id = auth()->user()->company_id;
        $loggeduser = DB::table('users')->select('id','uname','email','uphone','urole')->where('company_id', $company_id)->get();

        return response([
            'loggeduser'=>$loggeduser,
            'message' => 'Logged User Data',
            'status'=>'success'
        ], 200);

    }
    
    public function change_password(Request $request){
       // echo "changepassword"; die;
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        $loggeduser = auth()->user();
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        return response([
            'message' => 'Password Changed Successfully',
            'status'=>'success'
        ], 200);
    }

    public function userList()
    {
        
        if (auth()->check()) {
            $company_id = auth()->user()->company_id;
            $users = DB::table('users')
                ->select('id','uname', 'email', 'uphone', 'urole')
                ->where('company_id', $company_id)
                ->get();
            return response([
                'userlist'=>$users,
                'status'=>'success'
            ], 200);
        } else {
            return response([
                'message' => 'User not authenticated',
                'status' => 'error'
            ], 401);
        }

    }

    public function importView(Request $request){
        return view('import');
    }

    public function import(Request $request){
        Excel::import(new ImportUser, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportUsers(Request $request){
        return Excel::download(new ExportUser, 'users.xlsx');
    }
}
