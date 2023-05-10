<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\Role;
    use App\Models\User;
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

            Role::create([
                'company_id' => $cid,
                'role_name' => 'CEO',
                'p_id' => 0,
            ]);

            User::create([
                'uname' => $data['cname'] ?? null,
                'email' => $data['email'] ?? null,
                'password' => Hash::make('xspl@123'),
                'uphone' => $data['cphone'] ?? null,
                'urole' => 'CEO',
                'company_id' => $cid,
                'role_id' => Role::latest('created_at')->value('id'),
            ]);

            Log::channel('create_company')->info('A new company has been created. company data: '.$company);

            return $company;
        }

        
    }      
    

    


    