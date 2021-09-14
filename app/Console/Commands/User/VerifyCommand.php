<?php

namespace App\Console\Commands\User;

use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    private $registerService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify user email';

    public function __construct(RegisterService $registerService)
    {
        parent::__construct();
        $this->registerService = $registerService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Undefined user with email $email");
            return 1;
        }

        try {
            $this->registerService->verify($user->id);
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Email is successfully confirmed');
        return 0;
    }
}
