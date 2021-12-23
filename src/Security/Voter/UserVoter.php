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
        if (!in_array($attribute, [self::CREATE, self::EDIT])) {
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
                return $this->canDoAction($user, $userForm);
                break;
        }
        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $user
     * @param User $userForm
     * @return bool
     */
    private function canDoAction(User $user, User $userForm): bool
    {
        return $user === $userForm->getId();
    }
}