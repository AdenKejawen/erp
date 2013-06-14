<?php
/**
 * @filenames: GatotKaca/SetupBundle/Controller/RoleFixtures.php
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
use GatotKaca\Erp\UtilitiesBundle\Entity\Role;
use GatotKaca\Erp\MainBundle\Helper\Helper;

class RoleFixtures extends AbstractFixture implements OrderedFixtureInterface{
    const   SYSTEM_INITIAL  = 'SYSTEM INITIAL';
    private $helper;

    private function getHelper(){
        if(!$this->helper){
            $this->helper   = new Helper();
        }
        return $this->helper;
    }

    public function load(ObjectManager $manager){
        //Utilities Role
        $role1  = new Role();
        $role1->setId($this->getHelper()->getUniqueId());
        $role1->setGroup($this->getReference('group1'));
        $role1->setModule($this->getReference('module1'));
        $role1->setView(TRUE);
        $role1->setModif(TRUE);
        $role1->setDelete(TRUE);
        $role1->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role1->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role1);
        $this->addReference('role1', $role1);

        $role2  = new Role();
        $role2->setId($this->getHelper()->getUniqueId());
        $role2->setGroup($this->getReference('group1'));
        $role2->setModule($this->getReference('module2'));
        $role2->setView(TRUE);
        $role2->setModif(TRUE);
        $role2->setDelete(TRUE);
        $role2->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role2->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role2);
        $this->addReference('role2', $role2);

        $role3  = new Role();
        $role3->setId($this->getHelper()->getUniqueId());
        $role3->setGroup($this->getReference('group1'));
        $role3->setModule($this->getReference('module3'));
        $role3->setView(TRUE);
        $role3->setModif(TRUE);
        $role3->setDelete(TRUE);
        $role3->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role3->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role3);
        $this->addReference('role3', $role3);

        $role4  = new Role();
        $role4->setId($this->getHelper()->getUniqueId());
        $role4->setGroup($this->getReference('group1'));
        $role4->setModule($this->getReference('module4'));
        $role4->setView(TRUE);
        $role4->setModif(TRUE);
        $role4->setDelete(TRUE);
        $role4->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role4->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role4);
        $this->addReference('role4', $role4);

        $role5  = new Role();
        $role5->setId($this->getHelper()->getUniqueId());
        $role5->setGroup($this->getReference('group1'));
        $role5->setModule($this->getReference('module5'));
        $role5->setView(TRUE);
        $role5->setModif(TRUE);
        $role5->setDelete(TRUE);
        $role5->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role5->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role5);
        $this->addReference('role5', $role5);

        $role6  = new Role();
        $role6->setId($this->getHelper()->getUniqueId());
        $role6->setGroup($this->getReference('group2'));
        $role6->setModule($this->getReference('module1'));
        $role6->setView(TRUE);
        $role6->setModif(TRUE);
        $role6->setDelete(TRUE);
        $role6->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role6->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role6);
        $this->addReference('role6', $role6);

        $role7  = new Role();
        $role7->setId($this->getHelper()->getUniqueId());
        $role7->setGroup($this->getReference('group2'));
        $role7->setModule($this->getReference('module2'));
        $role7->setView(TRUE);
        $role7->setModif(TRUE);
        $role7->setDelete(TRUE);
        $role7->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role7->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role7);
        $this->addReference('role7', $role7);

        $role8  = new Role();
        $role8->setId($this->getHelper()->getUniqueId());
        $role8->setGroup($this->getReference('group2'));
        $role8->setModule($this->getReference('module3'));
        $role8->setView(TRUE);
        $role8->setModif(TRUE);
        $role8->setDelete(TRUE);
        $role8->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role8->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role8);
        $this->addReference('role8', $role8);

        $role9  = new Role();
        $role9->setId($this->getHelper()->getUniqueId());
        $role9->setGroup($this->getReference('group2'));
        $role9->setModule($this->getReference('module4'));
        $role9->setView(TRUE);
        $role9->setModif(TRUE);
        $role9->setDelete(TRUE);
        $role9->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role9->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role9);
        $this->addReference('role9', $role9);

        $role10  = new Role();
        $role10->setId($this->getHelper()->getUniqueId());
        $role10->setGroup($this->getReference('group2'));
        $role10->setModule($this->getReference('module5'));
        $role10->setView(TRUE);
        $role10->setModif(TRUE);
        $role10->setDelete(TRUE);
        $role10->setCreatedby(RoleFixtures::SYSTEM_INITIAL);
        $role10->setUpdatedby(RoleFixtures::SYSTEM_INITIAL);
        $manager->persist($role10);
        $this->addReference('role10', $role10);

        $manager->flush();
    }

    public function getOrder(){
        return 4;
    }
}