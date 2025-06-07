<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function registration_form_renders_properly()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register'); // adjust based on your view content
    }

    #[Test]
    public function user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/register', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'username', 'email', 'password', 'phone', 'whatsapp']);
    }

    #[Test]
    public function username_must_be_unique()
    {
        User::factory()->create(['username' => 'tarek123']);

        $response = $this->postJson('/register', [
            'name' => 'Tarek',
            'username' => 'ziad', // duplicate username
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'whatsapp' => '1234567890',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
    }

    #[Test]
    public function email_must_be_valid_format()
    {
        $response = $this->postJson('/register', [
            'name' => 'Tarek',
            'username' => 'uniqueuserk',
            'email' => 'not-an-email', // invalid email format
            'phone' => '1234567890',
            'whatsapp' => '1234567890',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    #[Test]
    public function user_can_register_successfully_and_get_success_message()
    {
        // Fake WhatsApp API returns an array with phone validation info (not wrapped in 'data')
        Http::fake([
            '*' => Http::response([
                [
                    'phone_number' => '1234567890',
                    'status' => 'valid'
                ]
            ])
        ]);

        Storage::fake('public');

        $response = $this->postJson('/register', [
            'name' => 'New Userrr',
            'username' => 'new_userkw123',
            'email' => 'neww@example.com',
            'phone' => '1234567890',
            'whatsapp' => '1234567890',
            'password' => 'secret123',
            'image' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('users', [
            'username' => 'new_user123',
            'email' => 'new@example.com',
        ]);
    }
}
