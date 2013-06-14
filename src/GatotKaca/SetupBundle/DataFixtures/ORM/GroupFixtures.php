<?php
/**
 * @filenames: GatotKaca/SetupBundle/Controller/GroupFixtures.php
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
use GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup;
use GatotKaca\Erp\MainBundle\Helper\Helper;

class GroupFixtures extends AbstractFixture implements OrderedFixtureInterface{
    const   SYSTEM_INITIAL  = 'SYSTEM INITIAL';
    private $helper;

    private function getHelper(){
        if(!$this->helper){
            $this->helper   = new Helper();
        }
        return $this->helper;
    }

    public function load(ObjectManager $manager){
        $group1 = new UserGroup();
        $group1->setId($this->getHelper()->getUniqueId());
        $group1->setName('SUPER ADMINISTRATOR');
        $group1->setRelation('GatotKacaErpHumanResourcesBundle:Employee');
        $group1->setCreatedby(GroupFixtures::SYSTEM_INITIAL);
        $group1->setUpdatedby(GroupFixtures::SYSTEM_INITIAL);
        $manager->persist($group1);
        $this->addReference('group1', $group1);

        $group2 = new UserGroup();
        $group2->setId($this->getHelper()->getUniqueId());
        $group2->setName('ADMINISTRATOR');
        $group2->setRelation('GatotKacaErpHumanResourcesBundle:Employee');
        $group2->setCreatedby(GroupFixtures::SYSTEM_INITIAL);
        $group2->setUpdatedby(GroupFixtures::SYSTEM_INITIAL);
        $manager->persist($group2);
        $this->addReference('group2', $group2);

        $manager->flush();
    }

    public function getOrder(){
        return 1;
    }
}