<?php

use App\Models\Password;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SharedAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $passwords = Password::all();
        $users = User::all();

        $accesses = [];
        for ($i = 0; $i < 10; $i++) {
            $accesses[] = [
                'password_id' => $passwords->random()->id,
                'model_type' => User::class,
                'model_id' => $users->random()->id,
                'key' => Str::random(12),
                'can_edit' => rand() > 0.5,
            ];
        }

        DB::table('shared_access')->insert($accesses);
    }
}
