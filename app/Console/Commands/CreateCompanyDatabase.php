<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDatabase extends Command
{
    protected $signature = 'company:create-database {name}';
    
    protected $description = 'Create a database for a new company';
    
    public function handle()
    {
        $name = $this->argument('name');
        
        // Create a new database
        DB::statement("CREATE DATABASE IF NOT EXISTS $name");
        
        // Update the database connection configuration dynamically
        config([
            'database.connections.company.database' => $name,
        ]);
        
        // Run migrations on the new database
        $this->call('migrate', [
            '--database' => 'company',
            '--path' => 'database/migrations/company',
        ]);
        
        $this->info("Database $name created and migrated successfully");
    }
}
