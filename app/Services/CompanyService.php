<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Mail;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class CompanyService
    {
        public function insertData($data)
        {
            $company = new Company($data);
            $company->uuid = mt_rand(10000000, 99999999);
            $company->save();
            $cid = $company->id;

            // Save role entry in the role table
            Role::create([
                'company_id' => $cid,
                'role_name' => 'CEO',
                'p_id' => 0,
            ]);
            // Save user entry in the user table
            $user = User::create([
                'uname' => $data['cname'] ?? null,
                'email' => $data['email'] ?? null,
                'password' => Hash::make('xspl@123'),
                'uphone' => $data['cphone'] ?? null,
                'urole' => 'CEO',
                'company_id' => $cid,
                'role_id' => Role::latest('created_at')->value('id'),
            ]);

            // Save email entry in the mail table
            event(new \App\Events\CompanyCreated($company, $cid));
            Log::channel('create_company')->info('A new company has been created. company data: '.$company);

            return $company;
        }

        
    }      
    

    


    