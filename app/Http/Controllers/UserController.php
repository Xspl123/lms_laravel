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

        // $campany_id = auth()->user()->company_id;
       
        $request->validate([
            'uname' => 'required|string',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'uphone' => 'required|string',
            'role_id' => 'required|numeric',
            'domain_name' =>'nullable',
            'uexperience' => 'required|string',
            'status' => 'nullable|in:activate,deactivate',
            'profile_id' => 'nullable',
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
            'status' => $request->status,
            // 'company_id' => $campany_id,
            'role_id' =>  $request->role_id,
            'profile_id' =>  $request->profile_id,
        ]);

        $token = $user->createToken($request->email)->plainTextToken;
        return response([
            'token'=>$token,
            'message' => 'Registration Success',
            'status'=>'success'
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'The provided credentials are incorrect.',
                'status' => 'failed',
            ], 401);
        }
        
        if ($user->status === 'deactivate') {
            return response([
                'message' => 'Account is deactivated. Please contact the Administrator.',
                'status' => 'failed',
            ], 401);
        }
        
        $token = $user->createToken($request->email)->plainTextToken;
        $profile = DB::table('profiles')->select('*')->get();
        $module = DB::table('modules')->select('*')->get();
        return response([
            'token' => $token,
            'message' => 'Login Success',
            'status' => 'success',
            'user' => $user,
            'profile' => $profile,
            'module' => $module,
        ], 200);        
        
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
    
    public function change_password(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        
        $loggeduser = auth()->user();
        
        if (!$loggeduser) {
            return response([
                'message' => 'User not found',
                'status' => 'error'
            ], 404);
        }
        
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        
        return response([
            'message' => 'Password Changed Successfully',
            'status' => 'success'
        ], 200);
    }

    // public function userList()
    // {   
    //     $users = DB::table('users')
    //         ->join('roles', 'users.role_id', '=', 'roles.id')// Joining with roles table
    //         ->join('profiles', 'users.profile_id', '=', 'profiles.id') // Joining with profiles table
    //         ->select('users.id','users.uname','users.email','users.uphone','users.status','profiles.profile_name', 'roles.role_name')->get();

    //     return response([
    //         'userlist' => $users,
    //         'status' => 'success'
    //     ], 200);
        
    //     return response([
    //         'message' => 'User not authenticated',
    //         'status' => 'error'
    //     ], 401);
       
    // }

    public function userList()
    {
        $users = User::with('role:id,role_name', 'profile:id,profile_name')->get();

        return response([
            'userlist' => $users,
            'status' => 'success'
        ], 200);
    }

    public function updateUser(Request $request, $userId)
    {
        try {
                $user = User::findOrFail($userId);
        
                // Update fields one by one
                if ($request->has('uname')) {
                    $user->uname = $request->input('uname');
                }
                if ($request->has('email')) {
                    $user->email = $request->input('email');
                }
                if ($request->has('password')) {
                    $user->password = Hash::make($request->input('password'));
                }
                if ($request->has('uphone')) {
                    $user->uphone = $request->input('uphone');
                }
                if ($request->has('urole')) {
                    $user->urole = $request->input('urole');
                }
                if ($request->has('domain_name')) {
                    $user->domain_name = $request->input('domain_name');
                }
                if ($request->has('uexperience')) {
                    $user->uexperience = $request->input('uexperience');
                }
                if ($request->has('status')) {
                    $user->status = $request->input('status');
                }
        
                $user->save();
    
                return response()->json(['message' => 'User updated successfully']);
            }   catch (ModelNotFoundException $e) {
                return response()->json(['message' => 'User not found'], 404);
         }
    }
    

    public function singleUser($id) {
        $user = User::with('role:id,role_name', 'profile:id,profile_name')->find($id);
        
        if ($user) {
            return response([
                'user' => $user,
                'status' => 'success'
            ], 200);
        } else {
            return response([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
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

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
