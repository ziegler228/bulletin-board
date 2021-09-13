<?php

namespace Tests\Unit\Model\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testRequest(): void
    {
        $user = User::register(
            $name = 'test',
            $email = 'test@test.test',
            $password = 'password'
        );

        $this->assertNotEmpty($user);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertNotEquals($password, $user->password);

        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());
    }
}
