<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use DatabaseTransactions; // Rollback database changes after each test

    public function testLoginWithValidCredentials()
    {
        $email = 'abhishek@vert-age.com';
        $password = 'xspl@2018';

        // Retrieve the user from the database
        $user = User::where('email', $email)->first();

        // Ensure the user exists
        $this->assertNotNull($user);

        // Check if the password matches
        $this->assertTrue(Hash::check($password, $user->password));

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Login Success',
                // assert any other expected response data
            ]);
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalid_password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'failed',
                'message' => 'The Provided Credentials are incorrect',
            ]);
    }
}
