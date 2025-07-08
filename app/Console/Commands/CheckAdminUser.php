<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CheckAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and create admin user if needed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking admin user...');

        // Check if admin user exists
        $admin = User::where('email', 'admin@rubista.com')->first();

        if ($admin) {
            $this->info("✅ Admin user exists: {$admin->name}");
            $this->info("📧 Email: {$admin->email}");
            $this->info("🔐 Is Admin: " . ($admin->is_admin ? 'Yes' : 'No'));
            
            // Fix admin privileges if needed
            if (!$admin->is_admin) {
                $admin->update(['is_admin' => true]);
                $this->info("✅ Fixed: Admin privileges granted");
            }
        } else {
            // Create admin user
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@rubista.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
            $this->info("✅ Created admin user: {$admin->name}");
        }

        $this->info("\n🔑 Admin Login Credentials:");
        $this->info("📧 Email: admin@rubista.com");
        $this->info("🔒 Password: password");
        $this->info("\n🌐 Admin Panel URL: http://127.0.0.1:8000/admin");
        
        // Check all users
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        $regularUsers = User::where('is_admin', false)->count();
        
        $this->info("\n📊 User Statistics:");
        $this->info("👥 Total Users: {$totalUsers}");
        $this->info("👑 Admin Users: {$adminUsers}");
        $this->info("👤 Regular Users: {$regularUsers}");

        return 0;
    }
}
