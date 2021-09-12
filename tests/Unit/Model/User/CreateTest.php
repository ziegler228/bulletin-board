<?php

namespace Tests\Unit\Model\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testNew(): void
    {
        $user = User::new(
            $name = 'test',
            $email = 'test@test.ru',
            $password = 'test228'
        );

        $this->assertNotEmpty($user);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertNotEquals($password, $user->password);

        $this->assertTrue($user->isActive());
    }
}
