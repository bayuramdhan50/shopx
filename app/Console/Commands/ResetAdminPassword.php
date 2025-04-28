<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the admin user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@shopx.com';
        $password = $this->argument('password') ?? 'admin123';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            
            if ($this->confirm('Do you want to create a new admin user?')) {
                $user = new User();
                $user->name = 'Admin User';
                $user->email = $email;
                $user->is_admin = true;
                $user->password = Hash::make($password);
                $user->save();
                
                $this->info("Admin user created with email: {$email} and password: {$password}");
                return;
            }
            
            return;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("Password for {$email} reset to: {$password}");
    }
}
