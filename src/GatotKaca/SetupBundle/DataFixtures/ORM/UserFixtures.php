<?php
/**
 * @filenames: GatotKaca/SetupBundle/Controller/UserFixtures.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\SetupBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GatotKaca\Erp\UtilitiesBundle\Entity\User;
use GatotKaca\Erp\MainBundle\Helper\Helper;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface{
    const   SYSTEM_INITIAL  = 'SYSTEM INITIAL';
    private $helper;

    private function getHelper(){
        if(!$this->helper){
            $this->helper   = new Helper();
        }
        return $this->helper;
    }

    public function load(ObjectManager $manager){
        $username   = 'ADEN.KEJAWEN';
        $salt       = $this->getHelper()->getSalt($username);
        $user1      = new User();
        $user1->setId($this->getHelper()->getUniqueId());
        $user1->setName($username);
        $user1->setGroup($this->getReference('group1'));
        $user1->setSalt($salt);
        $user1->setPass($this->getHelper()->hashPassword('kejawen', $salt));
        $user1->setCreatedby(UserFixtures::SYSTEM_INITIAL);
        $user1->setUpdatedby(UserFixtures::SYSTEM_INITIAL);
        $manager->persist($user1);
        $this->addReference('user1', $user1);

        $username   = 'ADMINISTRATOR';
        $salt       = $this->getHelper()->getSalt($username);
        $user2      = new User();
        $user2->setId($this->getHelper()->getUniqueId());
        $user2->setName($username);
        $user2->setGroup($this->getReference('group2'));
        $user2->setSalt($salt);
        $user2->setPass($this->getHelper()->hashPassword('admin', $salt));
        $user2->setCreatedby(UserFixtures::SYSTEM_INITIAL);
        $user2->setUpdatedby(UserFixtures::SYSTEM_INITIAL);
        $manager->persist($user2);
        $this->addReference('user2', $user2);

        $manager->flush();
    }

    public function getOrder(){
        return 3;
    }
}