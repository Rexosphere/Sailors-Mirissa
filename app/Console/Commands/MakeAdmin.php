<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email?} {name?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update a user with admin privileges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Enter email address');
        $name = $this->argument('name') ?? $this->ask('Enter name');
        $password = $this->argument('password') ?? $this->secret('Enter password');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address');
            return 1;
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters');
            return 1;
        }

        $user = \App\Models\User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'name' => $name,
                'password' => bcrypt($password),
                'is_admin' => true,
            ]);
            $this->info("User {$email} has been updated and granted admin privileges.");
        } else {
            \App\Models\User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'is_admin' => true,
            ]);
            $this->info("Admin user {$email} has been created successfully.");
        }

        return 0;
    }
}
