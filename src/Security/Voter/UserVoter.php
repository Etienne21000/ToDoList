<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    const EDIT = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';

    private $security;

    /**
     * UserVoter constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::CREATE, self::EDIT, self::DELETE])) {
            return false;
        }
        if (!$subject instanceof User) {
            return false;
        }
        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User) {
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        $userForm = $subject;

        switch ($attribute) {
            case self::CREATE:
            case self::EDIT:
            case self::DELETE:
                return $this->canDoAction($userForm, $user);
                break;
        }
        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $user
     * @param User $userForm
     * @return bool
     */
    private function canDoAction(User $userForm, User $user): bool
    {
        return $user === $userForm->getId();
    }
}