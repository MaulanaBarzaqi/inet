<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Laravel\Firebase\Facades\Firebase;

class TestFirebaseConfig extends Command
{   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Firebase configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Firebase configuration...');

        try {
            // Test Authentication
            $auth = Firebase::auth();
            $users = $auth->listUsers(1);
            $this->info('✅ Firebase Auth connected successfully!');
            
            // Test Project Info
            $projectId = config('firebase.projects.app.credentials.project_id');
            $this->info("✅ Project ID: {$projectId}");
            $this->info('✅ All configurations are correct!');
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('❌ Please check your Firebase configuration.');
        }
    }
}

