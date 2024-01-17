<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const EDIT = 'TASK_EDIT';
    public const DELETE = 'TASK_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                return $this->canEdit($token, $subject);
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                return $this->canDelete($token, $subject);
                break;
        }

        return false;
    }

    private function canEdit(TokenInterface $token, Task $task) {
        $user = $token->getUser();

        return (in_array('ROLE_ADMIN', $user->getRoles()) && $task->getAuthor()->getUsername() === "anonymous") ||
            $user === $task->getAuthor();
    }

    private function canDelete(TokenInterface $token, Task $task) {
        $user = $token->getUser();

        return (in_array('ROLE_ADMIN', $user->getRoles()) && $task->getAuthor()->getUsername() === "anonymous") ||
            $user === $task->getAuthor();
    }
}
