<?php

namespace App\Console\Commands\Token;

use App\Models\User;
use Illuminate\Console\Command;

class GetToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:token {token_name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is your fresh token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::findOr(1, function () {
            User::create([
                'name' => 'amir',
                'email' => 'amir' . rand(111) . '@gmail.com',
            ]);
        });
        if ($user) {


            $data = [
                'hotel-view',
                'hotel-create',
                'hotel-update'
            ];
            $token = $user->createToken($this->argument('token_name'),$data)->plainTextToken;

            $this->info('The token made successful');
        }
        $this->info('Token : ' . $token);
    }
}
