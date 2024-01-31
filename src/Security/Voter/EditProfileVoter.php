<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EditProfileVoter extends Voter
{

    public const EDIT = 'USER_EDIT';
    public const ROLE = 'ROLE_EDIT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::ROLE])
            && $subject instanceof User;

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
                return $this->canEditUser($token, $subject);
                break;
            case self::ROLE:
                return $this->canEditRoles($token);
                break;
        }

        return false;

    }

    private function canEditRoles(TokenInterface $token): Bool {
        $loggedUser = $token->getUser();

        return in_array(User::ROLE_ADMIN, $loggedUser->getRoles());
    }

    private function canEditUser(TokenInterface $token, User $user): Bool {
        $loggedUser = $token->getUser();

        return $loggedUser === $user;

    }


}
