<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email : The email address of the user to make an admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a specific user to an administrator based on their email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $this->error('You must provide an email address using the --email option.');
            return Command::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return Command::FAILURE;
        }

        if ($user->is_admin) {
            $this->info("User '{$user->name}' ({$email}) is already an admin.");
            return Command::SUCCESS;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("Successfully promoted user '{$user->name}' ({$email}) to an admin!");
        return Command::SUCCESS;
    }
}
