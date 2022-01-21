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
    const VIEW = 'view';

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
//        if (!in_array($attribute, [self::CREATE, self::EDIT, self::DELETE])) {
//            return false;
//        }
//        if (!$subject instanceof User) {
//            return false;
//        }
//        return true;
        return in_array($attribute, [self::CREATE, self::EDIT, self::VIEW], true) && $subject instanceof User;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $subject;

        if(!$user instanceof User) {
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
//        if ($this->security->isGranted('ROLE_USER')){
//            return false;
//        }
        return false;
    }
}