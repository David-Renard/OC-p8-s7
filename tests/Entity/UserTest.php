<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        $this->user = new User();

    }

    public function testUsername(): void
    {
        $this->user->setUsername('Username');
        $this->assertSame('Username', $this->user->getUsername());

    }

    public function testEmail(): void
    {
        $this->user->setEmail('email');
        $this->assertSame('email', $this->user->getEmail());

    }

    public function testRolesUser(): void
    {
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());

    }

    public function testRolesAdmin(): void
    {
        $this->user->setRoles(['ROLE_ADMIN']);
        $this->assertSame(['ROLE_ADMIN','ROLE_USER'], $this->user->getRoles());

    }

    public function testPassword(): void
    {
        $this->user->setPassword("password");
        $this->assertSame('password', $this->user->getPassword());

    }

    public function testPlainPassword(): void
    {
        $this->user->setPlainPassword("password");
        $this->assertSame('password', $this->user->getPlainPassword());

    }

    public function testNoTask(): void
    {
        $this->assertCount(0, $this->user->getTasks());

    }

}
