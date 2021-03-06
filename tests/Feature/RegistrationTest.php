<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post("/register", [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ]);

        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();
        $this->post("/register", [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ]);

        $user = User::whereName('John')->first();
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
        $this->get(route('register.confirm', ['token' => $user->confirmation_token]));
        tap($user->fresh(), fn($user) => [
            $this->assertTrue($user->confirmed),
            $this->assertNull($user->confirmation_token),
        ]);
    }

    /** @test */
    function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads.index'))
            ->assertSessionHas('flash', 'Token inconnu.');
    }
}
