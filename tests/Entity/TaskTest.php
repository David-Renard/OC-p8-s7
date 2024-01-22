<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private Task $task;

    private \DateTimeImmutable $createdAt;
    public function setUp(): void
    {
        $this->task = new Task();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function testCreatedAt(): void
    {
        $this->task->setCreatedAt($this->createdAt);
        $this->assertSame($this->createdAt, $this->task->getCreatedAt());
    }

    public function testTitle(): void
    {
        $this->task->setTitle('Titre test');
        $this->assertSame('Titre test', $this->task->getTitle());
    }

    public function testContent(): void
    {
        $this->task->setContent('Contenu test');
        $this->assertSame('Contenu test', $this->task->getContent());
    }

    public function testIsDoneFalse(): void
    {
        $this->assertSame(false, $this->task->isIsDone());
    }

    public function testIsDoneTrue(): void
    {
        $this->task->setIsDone(true);
        $this->assertSame(true, $this->task->isIsDone());
    }

    public function testAuthor(): void
    {
        $this->task->setAuthor(new User());
        $this->assertInstanceOf(User::class, $this->task->getAuthor());
    }

    public function testOrphanTask(): void
    {
        $this->task->setAuthor(null);
        $this->assertNull($this->task->getAuthor());
    }
}