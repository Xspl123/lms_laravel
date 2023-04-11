<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class CompanyService {

        public function insertData($data) {
            
            
           
            $uuid = mt_rand(10000000, 99999999);
          
            
            $company = new Company;
            $company->uuid = $uuid;
            $company->cname = $data['cname'] ?? null;
            $company->company = isset($data['company']) ? $data['company'] : null;
            $company->cemail = $data['cemail'] ?? null;
            $company->ctax_number = $data['ctax_number'] ?? null;
            $company->cphone = $data['cphone'] ?? null;
            //$company->lead_Owner = $lead_Owner;
            //$company->created_by = $username;
            $company->ccity = $data['ccity'] ?? null;
            $company->cbilling_address = $data['cbilling_address'] ?? null;
            $company->ccountry = $data['ccountry'] ?? null;
            $company->cpostal_code = $data['cpostal_code'] ?? null;
            $company->cemployees_size = $data['cemployees_size'] ?? null;
            $company->cfax = $data['cfax'] ?? null;
            $company->cdescription = $data['cdescription'] ?? null;
            $company->domain_name = $data['domain_name'] ?? null;
            $company->cis_active = $data['cis_active'] ?? null;
            
            $company->save();

            Log::channel('create_leads')->info('A new company has been created. company data: '.$company);
            
            $cid = $company->id;

            //print_r ($cid);exit;

            $ceo = Role::create([
                'company_id' => $cid,
                'role_name' => 'CEO',
                'p_id' => 0,
            ]);
    
            $ceo->save();
            $roleId=$ceo->id;

            $user = new User;
            $user->uname = isset($data['cname']) ? $data['cname'] : null;
            $user->email = $data['cemail'] ?? null;
            $user->password = Hash::make('xspl@123');
            $user->uphone = $data['cphone'] ?? null;
            $user->urole = 'CEO';
            $user->company_id = $cid;
            $user->role_id = $roleId;
            $user->save();

        
            return $company;
            
    
        }
    
        private function createChildRoles(Role $parentRole, array $childRoles)
        {
            foreach ($childRoles as $childRoleData) {
                $childRole = Role::create([
                    'role_name' => $childRoleData['role_name'],
                    'p_id' => $parentRole->id,
                ]);
    
                $parentRole->childRoles()->save($childRole);
    
                if (isset($childRoleData['child_roles'])) {
                    $this->createChildRoles($childRole, $childRoleData['child_roles']);
                }
            }
        
            

        }
    
    }      
    

    


    