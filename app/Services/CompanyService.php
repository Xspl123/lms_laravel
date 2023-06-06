<?php

    namespace App\Services;
    use App\Models\Company;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Mail;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Http;

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

    
    // public function insertData($data)
    // {
    //     $company = new Company($data);
    //     $company->uuid = mt_rand(10000000, 99999999);
    //     $company->save();
    //     $cid = $company->id;
    
    //     // Save role entry in the role table
    //     Role::create([
    //         'company_id' => $cid,
    //         'role_name' => 'CEO',
    //         'p_id' => 0,
    //     ]);
    
    //     // Save user entry in the user table
    //     $user = User::create([
    //         'uname' => $data['cname'] ?? null,
    //         'email' => $data['email'] ?? null,
    //         'password' => Hash::make('xspl@123'),
    //         'uphone' => $data['cphone'] ?? null,
    //         'urole' => 'CEO',
    //         'company_id' => $cid,
    //         'role_id' => Role::latest('created_at')->value('id'),
    //     ]);
    
    //     // Save email entry in the mail table
    //     event(new \App\Events\CompanyCreated($company, $cid));
    //     Log::channel('create_company')->info('A new company has been created. company data: '.$company);
    
    //     // Copy project folder and database
    //     $newCompanyName = str_replace(' ', '_', $company->cname); // Convert company name to folder/database name-friendly format
    //     $sourceFolderPath = '/var/www/html/Abhishek/lms_laravel'; // Specify the source project folder path
    //     $destinationFolderPath = '/var/www/html/Abhishek/'.$newCompanyName; // Specify the destination folder path with the new company name
    
    //     // Copy the project folder recursively
    //     if (file_exists($sourceFolderPath)) {
    //         if (!file_exists($destinationFolderPath)) {
    //             mkdir($destinationFolderPath, 0755, true);
    //         }
    //         $this->recursiveCopy($sourceFolderPath, $destinationFolderPath);
    //     }
    
    //     // Create a new database for the company
    //     $databaseName = str_replace(' ', '_', strtolower($company->cname));
    //     DB::statement('CREATE DATABASE IF NOT EXISTS ' . $databaseName);
    
    //     // Get the current database connection details
    //     $currentConnection = config('database.default');
    //     $currentConfig = config("database.connections.{$currentConnection}");
    //     $currentDatabase = $currentConfig['database'];
    
    //     // Switch to the new database connection
    //     config(["database.connections.{$currentConnection}.database" => $databaseName]);
    //     DB::reconnect();
    
    //     // Get all tables from the current database
    //     $tables = DB::select('SHOW TABLES');
    
    //     // Iterate over each table and replicate the structure
    //     foreach ($tables as $table) {
    //         $tableName = reset($table);
    
    //         // Get the table structure
    //         $tableStructure = DB::select("SHOW CREATE TABLE `{$tableName}`");
    //         $createTableStatement = reset($tableStructure);
    //         $createTableQuery = $createTableStatement->{'Create Table'};
    
    //         // Execute the create table query in the new database
    //         DB::statement($createTableQuery);
    
    //         // Copy table data to the new database
    //         DB::insert("INSERT INTO {$tableName} SELECT * FROM {$currentDatabase}.{$tableName}");
    //     }
    
    //     // Switch back to the original database connection
    //     config(["database.connections.{$currentConnection}.database" => $currentDatabase]);
    //     DB::reconnect();
    
    //     return $company;
    // }
    
    // Helper function to recursively copy files and folders
    // private function recursiveCopy($source, $destination)
    // {
    //     $dir = opendir($source);
    //     @mkdir($destination);
    
    //     while (($file = readdir($dir))) {
    //         if ($file != '.' && $file != '..') {
    //             if (is_dir($source.'/'.$file)) {
    //                 $this->recursiveCopy($source.'/'.$file, $destination.'/'.$file);
    //             } else {
    //                 copy($source.'/'.$file, $destination.'/'.$file);
    //             }
    //         }
    //     }
    
    //     closedir($dir); 
    // }
    
   

}  


    