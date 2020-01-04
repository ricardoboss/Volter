<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws BindingResolutionException
     */
    public function testMe(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => "john@testing",
            'password' => Hash::make("test"),
        ]);

        $token = $this->app->make(Factory::class)->guard('api')->login($user);

        $response = $this->getJson('/api/auth/me', [
            'Authorization' => "bearer $token",
        ]);

        $response->assertSuccessful()
            ->assertExactJson([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }
}
