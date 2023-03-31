<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\Role;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Auth;

    class CompanyService {

        public function insertData($data) {
            
            $lead_Owner = Auth::user()->uname;
            $userId = Auth::id();
            $uuid = mt_rand(10000000, 99999999);
            $username = Auth::user()->uname;
            
            $company = new Company;
            $company->uuid = $uuid;
            $company->cname = $data['cname'] ?? null;
            //$company->company = isset($data['company']) ? $data['company'] : null;
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
            $company->user_id = $userId;
            $company->save();
            Log::channel('create_leads')->info('A new company has been created. company data: '.$company);
            $cid=$company->id;

            //Insert data in role table
         
            $ceo = Role::create([
                'company_id' => $cid,
                'role_name' => 'CEO',
                'p_id' => 0,
            ]);
    
            $company->roles()->save($ceo);
    
            $this->createChildRoles($ceo, [
                [
                    'role_name' => 'Manager',
                    'child_roles' => [
                        ['role_name' => 'Team Lead'],
                        ['role_name' => 'Supervisor'],
                    ],
                ],
                [
                    'role_name' => 'Employee',
                    'child_roles' => [
                        ['role_name' => 'Staff'],
                        ['role_name' => 'Trainee'],
                    ],
                ],
            ]);

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
    

    


    