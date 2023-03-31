<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AllInOneController;
use App\Helpers\TableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\CreateLeads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        //$uuid = Str::uuid();
        //print_r($uuid); exit;
        $companyId = DB::table('companies')->where('cname', 'Xenottabyte')->value('id');
        $pId = DB::table('roles')->where('p_id', 16)->value('id');
        print_r($pId); exit;
        $roleName = DB::table('roles')->where('id', 14)->value('role_name');
         //print_r($roleName); exit;
        $request->validate([
            'uname' => 'required|string',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'uphone' => 'required|string',
            // 'urole' => 'required|string',
            'domain_name' =>'required|unique:users,domain_name',
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
            'urole' => $roleName,
            'domain_name' => $request->domain_name,
            'uexperience' => $request->uexperience,
            'company_id' => $companyId,
            'role_id' => $roleId,
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
        $loggeduser = auth()->user();
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
        
        $users = TableHelper::getTableData('users', ['id','uname','email','urole']);
        
        return response([
            'userlist'=>$users,
            'status'=>'success'
        ], 200);
    }
}
