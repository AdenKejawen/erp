<?php
/**
 * @filenames: GatotKaca/SetupBundle/Controller/ModuleFixtures.php
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
use GatotKaca\Erp\UtilitiesBundle\Entity\Module;
use GatotKaca\Erp\MainBundle\Helper\Helper;

class ModuleFixtures extends AbstractFixture implements OrderedFixtureInterface{
    const   SYSTEM_INITIAL  = 'SYSTEM INITIAL';
    private $helper;

    private function getHelper(){
        if(!$this->helper){
            $this->helper   = new Helper();
        }
        return $this->helper;
    }

    public function load(ObjectManager $manager){
        //Module Utilities
        $module1    = new Module();
        $module1->setId($this->getHelper()->getUniqueId());
        $module1->setName('UTILITIES');
        $module1->setIcon('icon-laptop_wrench');
        $module1->setMenuOrder(1);
        $module1->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module1->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module1);
        $this->addReference('module1', $module1);

        $module2    = new Module();
        $module2->setId($this->getHelper()->getUniqueId());
        $module2->setParent($this->getReference('module1'));
        $module2->setName('ROLE');
        $module2->setSelector('panelrole');
        $module2->setIcon('icon-shield_silver');
        $module2->setUrl('GatotKacaErp_module_Utilities_view_Role');
        $module2->setMenuOrder(2);
        $module2->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module2->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module2);
        $this->addReference('module2', $module2);

        $module3    = new Module();
        $module3->setId($this->getHelper()->getUniqueId());
        $module3->setParent($this->getReference('module1'));
        $module3->setName('USER');
        $module3->setSelector('paneluser');
        $module3->setIcon('icon-user_suit_black');
        $module3->setUrl('GatotKacaErp_module_Utilities_view_User');
        $module3->setMenuOrder(3);
        $module3->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module3->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module3);
        $this->addReference('module3', $module3);

        $module4    = new Module();
        $module4->setId($this->getHelper()->getUniqueId());
        $module4->setParent($this->getReference('module1'));
        $module4->setName('MODULE');
        $module4->setSelector('panelmodule');
        $module4->setIcon('icon-brick_edit');
        $module4->setUrl('GatotKacaErp_module_Utilities_view_Module');
        $module4->setMenuOrder(4);
        $module4->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module4->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module4);
        $this->addReference('module4', $module4);

        $module5    = new Module();
        $module5->setId($this->getHelper()->getUniqueId());
        $module5->setParent($this->getReference('module1'));
        $module5->setName('GROUP');
        $module5->setSelector('panelgroup');
        $module5->setIcon('icon-group');
        $module5->setUrl('GatotKacaErp_module_Utilities_view_Group');
        $module5->setMenuOrder(5);
        $module5->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module5->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module5);
        $this->addReference('module5', $module5);

        $module6    = new Module();
        $module6->setId($this->getHelper()->getUniqueId());
        $module6->setName('PERSONAL');
        $module6->setSelector('root');
        $module6->setIcon('icon-user_home');
        $module6->setUrl('root');
        $module6->setMenuOrder(6);
        $module6->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module6->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module6);
        $this->addReference('module6', $module6);

        $module7    = new Module();
        $module7->setId($this->getHelper()->getUniqueId());
        $module7->setParent($this->getReference('module6'));
        $module7->setName('ATTENDANCE');
        $module7->setSelector('root');
        $module7->setIcon('icon-date');
        $module7->setUrl('root');
        $module7->setMenuOrder(7);
        $module7->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module7->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module7);
        $this->addReference('module7', $module7);

        $module8    = new Module();
        $module8->setId($this->getHelper()->getUniqueId());
        $module8->setParent($this->getReference('module7'));
        $module8->setName('OVER TIME');
        $module8->setSelector('panelovertime');
        $module8->setIcon('icon-clock_add');
        $module8->setUrl('GatotKacaErp_module_Personal_view_OverTime');
        $module8->setMenuOrder(8);
        $module8->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module8->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module8);
        $this->addReference('module8', $module8);

        $module9    = new Module();
        $module9->setId($this->getHelper()->getUniqueId());
        $module9->setParent($this->getReference('module7'));
        $module9->setName('REPORT');
        $module9->setSelector('personalattendance');
        $module9->setIcon('icon-clock');
        $module9->setUrl('GatotKacaErp_module_Personal_view_Attendance');
        $module9->setMenuOrder(9);
        $module9->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module9->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module9);
        $this->addReference('module9', $module9);

        $module10    = new Module();
        $module10->setId($this->getHelper()->getUniqueId());
        $module10->setParent($this->getReference('module6'));
        $module10->setName('PROFILE');
        $module10->setSelector('personalprofile');
        $module10->setIcon('icon-user_magnify');
        $module10->setUrl('GatotKacaErp_module_Personal_view_Profile');
        $module10->setMenuOrder(10);
        $module10->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module10->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module10);
        $this->addReference('module10', $module10);

        $module11    = new Module();
        $module11->setId($this->getHelper()->getUniqueId());
        $module11->setName('HUMAN RESOURCES');
        $module11->setSelector('root');
        $module11->setIcon('icon-vcard_key');
        $module11->setUrl('root');
        $module11->setMenuOrder(11);
        $module11->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module11->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module11);
        $this->addReference('module11', $module11);

        $module12    = new Module();
        $module12->setId($this->getHelper()->getUniqueId());
        $module12->setParent($this->getReference('module11'));
        $module12->setName('EMPLOYEE');
        $module12->setSelector('panelemployee');
        $module12->setIcon('icon-user_edit');
        $module12->setUrl('GatotKacaErp_module_HumanResources_view_Employee');
        $module12->setMenuOrder(12);
        $module12->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module12->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module12);
        $this->addReference('module12', $module12);

        $module13    = new Module();
        $module13->setId($this->getHelper()->getUniqueId());
        $module13->setParent($this->getReference('module11'));
        $module13->setName('MUTATION');
        $module13->setSelector('panelmutation');
        $module13->setIcon('icon-user_go');
        $module13->setUrl('GatotKacaErp_module_HumanResources_view_Mutation');
        $module13->setMenuOrder(13);
        $module13->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module13->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module13);
        $this->addReference('module13', $module13);

        $module14    = new Module();
        $module14->setId($this->getHelper()->getUniqueId());
        $module14->setParent($this->getReference('module11'));
        $module14->setName('ATTENDANCE');
        $module14->setSelector('root');
        $module14->setIcon('icon-date');
        $module14->setUrl('root');
        $module14->setMenuOrder(14);
        $module14->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module14->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module14);
        $this->addReference('module14', $module14);

        $module15    = new Module();
        $module15->setId($this->getHelper()->getUniqueId());
        $module15->setParent($this->getReference('module14'));
        $module15->setName('WORK SHIFT');
        $module15->setSelector('panelworkshift');
        $module15->setIcon('icon-clock_edit');
        $module15->setUrl('GatotKacaErp_module_HumanResources_view_WorkShift');
        $module15->setMenuOrder(15);
        $module15->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module15->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module15);
        $this->addReference('module15', $module15);

        $module16    = new Module();
        $module16->setId($this->getHelper()->getUniqueId());
        $module16->setParent($this->getReference('module14'));
        $module16->setName('REPORT');
        $module16->setSelector('panelattendance');
        $module16->setIcon('icon-clock');
        $module16->setUrl('GatotKacaErp_module_HumanResources_view_Attendance');
        $module16->setMenuOrder(16);
        $module16->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module16->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module16);
        $this->addReference('module16', $module16);

        $module17    = new Module();
        $module17->setId($this->getHelper()->getUniqueId());
        $module17->setParent($this->getReference('module14'));
        $module17->setName('TODAY');
        $module17->setSelector('panelattendancetoday');
        $module17->setIcon('icon-clock_red');
        $module17->setUrl('GatotKacaErp_module_HumanResources_view_AttendanceToday');
        $module17->setMenuOrder(17);
        $module17->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module17->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module17);
        $this->addReference('module17', $module17);

        $module18    = new Module();
        $module18->setId($this->getHelper()->getUniqueId());
        $module18->setParent($this->getReference('module14'));
        $module18->setName('OVER TIME');
        $module18->setSelector('panelovertime');
        $module18->setIcon('icon-clock_add');
        $module18->setUrl('GatotKacaErp_module_HumanResources_view_OverTime');
        $module18->setMenuOrder(18);
        $module18->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module18->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module18);
        $this->addReference('module18', $module18);

        $module19    = new Module();
        $module19->setId($this->getHelper()->getUniqueId());
        $module19->setParent($this->getReference('module14'));
        $module19->setName('LEAVE');
        $module19->setSelector('paneltimeoff');
        $module19->setIcon('icon-date_delete');
        $module19->setUrl('GatotKacaErp_module_HumanResources_view_TimeOff');
        $module19->setMenuOrder(19);
        $module19->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module19->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module19);
        $this->addReference('module19', $module19);

        $module20    = new Module();
        $module20->setId($this->getHelper()->getUniqueId());
        $module20->setParent($this->getReference('module11'));
        $module20->setName('PROMOTION');
        $module20->setSelector('panelpromotion');
        $module20->setIcon('icon-award_star_add');
        $module20->setUrl('GatotKacaErp_module_HumanResources_view_Promotion');
        $module20->setMenuOrder(20);
        $module20->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module20->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module20);
        $this->addReference('module20', $module20);

        $module21    = new Module();
        $module21->setId($this->getHelper()->getUniqueId());
        $module21->setName('FINANCIAL');
        $module21->setSelector('root');
        $module21->setIcon('icon-coins');
        $module21->setUrl('root');
        $module21->setMenuOrder(21);
        $module21->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module21->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module21);
        $this->addReference('module21', $module21);

        $module22    = new Module();
        $module22->setId($this->getHelper()->getUniqueId());
        $module22->setName('PROJECT MANAGEMENT');
        $module22->setSelector('root');
        $module22->setIcon('icon-paste_plain');
        $module22->setUrl('root');
        $module22->setMenuOrder(22);
        $module22->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module22->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module22);
        $this->addReference('module22', $module22);

        $module23    = new Module();
        $module23->setId($this->getHelper()->getUniqueId());
        $module23->setName('SALES');
        $module23->setSelector('root');
        $module23->setIcon('icon-basket');
        $module23->setUrl('root');
        $module23->setMenuOrder(23);
        $module23->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module23->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module23);
        $this->addReference('module23', $module23);

        $module24    = new Module();
        $module24->setId($this->getHelper()->getUniqueId());
        $module24->setName('WAREHOUSE');
        $module24->setSelector('root');
        $module24->setIcon('icon-package');
        $module24->setUrl('root');
        $module24->setMenuOrder(24);
        $module24->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module24->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module24);
        $this->addReference('module24', $module24);

        $module25    = new Module();
        $module25->setId($this->getHelper()->getUniqueId());
        $module25->setName('PRODUCTION');
        $module25->setSelector('root');
        $module25->setIcon('icon-arrow_refresh');
        $module25->setUrl('root');
        $module25->setMenuOrder(25);
        $module25->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module25->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module25);
        $this->addReference('module25', $module25);

        $module26    = new Module();
        $module26->setId($this->getHelper()->getUniqueId());
        $module26->setName('PROCUREMENT');
        $module26->setSelector('root');
        $module26->setIcon('icon-door_in');
        $module26->setUrl('root');
        $module26->setMenuOrder(26);
        $module26->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module26->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module26);
        $this->addReference('module26', $module26);

        $module27    = new Module();
        $module27->setId($this->getHelper()->getUniqueId());
        $module27->setName('MATERIAL REQUIREMENT');
        $module27->setSelector('root');
        $module27->setIcon('icon-bricks');
        $module27->setUrl('root');
        $module27->setMenuOrder(27);
        $module27->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module27->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module27);
        $this->addReference('module27', $module27);

        $module28    = new Module();
        $module28->setId($this->getHelper()->getUniqueId());
        $module28->setName('GENERAL SETUP');
        $module28->setSelector('root');
        $module28->setIcon('icon-wrench');
        $module28->setUrl('root');
        $module28->setMenuOrder(28);
        $module28->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module28->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module28);
        $this->addReference('module28', $module28);

        $module29    = new Module();
        $module29->setId($this->getHelper()->getUniqueId());
        $module29->setParent($this->getReference('module28'));
        $module29->setName('SETTING');
        $module29->setSelector('root');
        $module29->setIcon('icon-cog');
        $module29->setUrl('root');
        $module29->setMenuOrder(29);
        $module29->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module29->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module29);
        $this->addReference('module29', $module29);

        $module30    = new Module();
        $module30->setId($this->getHelper()->getUniqueId());
        $module30->setParent($this->getReference('module29'));
        $module30->setName('WORK SHEET');
        $module30->setSelector('panelworksheet');
        $module30->setIcon('icon-clipboard');
        $module30->setUrl('GatotKacaErp_module_GeneralSetup_view_WorkSheet');
        $module30->setMenuOrder(30);
        $module30->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module30->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module30);
        $this->addReference('module30', $module30);

        $module31    = new Module();
        $module31->setId($this->getHelper()->getUniqueId());
        $module31->setParent($this->getReference('module28'));
        $module31->setName('MASTER DATA');
        $module31->setSelector('root');
        $module31->setIcon('icon-database');
        $module31->setUrl('root');
        $module31->setMenuOrder(31);
        $module31->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module31->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module31);
        $this->addReference('module31', $module31);

        $module32    = new Module();
        $module32->setId($this->getHelper()->getUniqueId());
        $module32->setParent($this->getReference('module31'));
        $module32->setName('COMPANY');
        $module32->setSelector('panelcompany');
        $module32->setIcon('icon-building');
        $module32->setUrl('GatotKacaErp_module_GeneralSetup_view_Company');
        $module32->setMenuOrder(32);
        $module32->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module32->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module32);
        $this->addReference('module32', $module32);

        $module33    = new Module();
        $module33->setId($this->getHelper()->getUniqueId());
        $module33->setParent($this->getReference('module31'));
        $module33->setName('DEPARTMENT');
        $module33->setSelector('paneldepartment');
        $module33->setIcon('icon-neighbourhood');
        $module33->setUrl('GatotKacaErp_module_GeneralSetup_view_Department');
        $module33->setMenuOrder(33);
        $module33->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module33->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module33);
        $this->addReference('module33', $module33);

        $module34    = new Module();
        $module34->setId($this->getHelper()->getUniqueId());
        $module34->setParent($this->getReference('module31'));
        $module34->setName('JOB LEVEL');
        $module34->setSelector('paneljoblevel');
        $module34->setIcon('icon-award_star_gold_2');
        $module34->setUrl('GatotKacaErp_module_GeneralSetup_view_JobLevel');
        $module34->setMenuOrder(34);
        $module34->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module34->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module34);
        $this->addReference('module34', $module34);

        $module35    = new Module();
        $module35->setId($this->getHelper()->getUniqueId());
        $module35->setParent($this->getReference('module31'));
        $module35->setName('JOB TITLE');
        $module35->setSelector('paneljobtitle');
        $module35->setIcon('icon-medal_gold_1');
        $module35->setUrl('GatotKacaErp_module_GeneralSetup_view_JobTitle');
        $module35->setMenuOrder(35);
        $module35->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module35->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module35);
        $this->addReference('module35', $module35);

        $module36    = new Module();
        $module36->setId($this->getHelper()->getUniqueId());
        $module36->setParent($this->getReference('module31'));
        $module36->setName('OFFICE HOUR');
        $module36->setSelector('panelofficehour');
        $module36->setIcon('icon-calendar_edit');
        $module36->setUrl('GatotKacaErp_module_GeneralSetup_view_OfficeHour');
        $module36->setMenuOrder(36);
        $module36->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module36->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module36);
        $this->addReference('module36', $module36);

        $module37    = new Module();
        $module37->setId($this->getHelper()->getUniqueId());
        $module37->setParent($this->getReference('module31'));
        $module37->setName('JOB STATUS');
        $module37->setSelector('paneljobstatus');
        $module37->setIcon('icon-page_edit');
        $module37->setUrl('GatotKacaErp_module_GeneralSetup_view_JobStatus');
        $module37->setMenuOrder(37);
        $module37->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module37->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module37);
        $this->addReference('module37', $module37);

        $module38    = new Module();
        $module38->setId($this->getHelper()->getUniqueId());
        $module38->setParent($this->getReference('module31'));
        $module38->setName('EDUCATION');
        $module38->setSelector('paneleducation');
        $module38->setIcon('icon-book_open_mark');
        $module38->setUrl('GatotKacaErp_module_GeneralSetup_view_Education');
        $module38->setMenuOrder(38);
        $module38->setCreatedby(ModuleFixtures::SYSTEM_INITIAL);
        $module38->setUpdatedby(ModuleFixtures::SYSTEM_INITIAL);
        $manager->persist($module38);
        $this->addReference('module38', $module38);


        $manager->flush();
    }

    public function getOrder(){
        return 2;
    }
}