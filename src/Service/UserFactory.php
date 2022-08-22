<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
 
use App\Entity\User;

class UserFactory extends AbstractFactory {

    private $em;

    public function __construct(
        EntityManagerInterface $em,
        Security $security,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->em = $em;
        $this->security = $security;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function repo() {
        return $this->em->getRepository(User::class);
    }

    public function get(int $id) {
        return $this->repo()->find($id);
    }

    public function getBy($params = []) {
        return $this->repo()->findOneBy($params);
    }

    public function save($params = []) {
        
        $user = new User();

        $user->setEmail($params['email']);
        $user->setPassword($this->userPasswordHasher->hashPassword(
            $user,
            $params['password']
        ));

        $this->em->persist($user);
        $this->em->flush();
    
        return $user->getId();
    }

}