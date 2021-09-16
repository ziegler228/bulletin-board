<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;

class ChangeRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Undefined user with email $email");
            return 1;
        }

        try {
            $user->changeRole($role);
        } catch (\InvalidArgumentException $e) {
            $this->error($e->getMessage());
            return 1;
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Role successfully changed');

        return 0;
    }
}
