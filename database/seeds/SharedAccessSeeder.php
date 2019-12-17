<?php

declare(strict_types=1);

use App\Models\Password;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Class SharedAccessSeeder.
 */
class SharedAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwords = Password::all();
        $users = User::all();

        $accesses = [];
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $password = $passwords->where('created_by', '!=', $user->id)->random();

            $accesses[] = [
                'password_id' => $password->id,
                'model_type' => User::class,
                'model_id' => $user->id,
                'key' => Str::random(12),
                'can_edit' => rand() > 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('shared_access')->insertOrIgnore($accesses);
    }
}
