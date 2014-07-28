<?php

namespace Hyperreal\AcaciaBundle\Internals\Security;

use Hyperreal\AcaciaBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class AnnouncementGrantVoter implements VoterInterface
{
    const CLASS_ANNOUNCEMENT = 'Hyperreal\AcaciaBundle\Entity\Announcement';
    const VIEW = 'VIEW';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    private static $superUsers = array('ROLE_ADMIN');
    private static $supportedAttributes = array(
        self::VIEW,
        self::EDIT,
        self::DELETE,
    );

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, self::$supportedAttributes);
    }

    public function supportsClass($class)
    {
        return $class === self::CLASS_ANNOUNCEMENT || is_subclass_of($class, self::CLASS_ANNOUNCEMENT);
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass(get_class($object))) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return self::ACCESS_DENIED;
        }

        $rolesInCommon = array_intersect($user->getRoles(), self::$superUsers);
        if (count($rolesInCommon) > 0 || $user->getId() == $object->getUser()->getId()) {
            return self::ACCESS_GRANTED;
        }

        return self::ACCESS_DENIED;
    }
}