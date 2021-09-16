<?php

namespace Tests\Unit\Model\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseMigrations;

    public function testChange(): void
    {
        $user = User::factory()->user()->create();

        $this->assertFalse($user->isAdmin());
        $this->assertTrue($user->isUser());

        $user->changeRole(User::ROLE_ADMIN);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isUser());
    }

    public function testAlready(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertTrue($user->isAdmin());

        $newRole = User::ROLE_ADMIN;

        $this->expectExceptionMessage("Role $newRole is already assigned");

        $user->changeRole($newRole);

    }

    public function testUndefined(): void
    {
        $user = User::factory()->user()->create();

        $newRole = 'xxqq';

        $this->expectExceptionMessage("Undefined role $newRole");

        $user->changeRole($newRole);
    }
}
