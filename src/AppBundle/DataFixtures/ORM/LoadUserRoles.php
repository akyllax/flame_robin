<?php
namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Role;

class LoadUserRoles implements FixtureInterface {
  private $roles = [
      'ROLE_AUTHOR' => 'author',
      'ROLE_SUPER_ADMIN' => 'super_admin',
      'ROLE_ADMIN' => 'admin',
      'ROLE_USER' => 'user',

  ];
  public function load(ObjectManager $manager){

        foreach($this->roles as $role => $name){
          $roleEntity = new Role();
          $roleEntity->setRole($role);
          $roleEntity->setName($name);
          $manager->persist($roleEntity);
        }
        $manager->flush();
  }
}
