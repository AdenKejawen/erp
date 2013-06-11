<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Helper/Helper.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Helper;

use GatotKaca\Erp\HumanResourcesBundle\Model\AttendanceModel;
use GatotKaca\Erp\HumanResourcesBundle\Model\EmployeeModel;
use GatotKaca\Erp\HumanResourcesBundle\Model\OverTimeModel;
use GatotKaca\Erp\MainBundle\Model\CompanyModel;
use GatotKaca\Erp\MainBundle\Model\CountryModel;
use GatotKaca\Erp\MainBundle\Model\DepartmentModel;
use GatotKaca\Erp\MainBundle\Model\DistrictModel;
use GatotKaca\Erp\MainBundle\Model\EducationModel;
use GatotKaca\Erp\MainBundle\Model\JobLevelModel;
use GatotKaca\Erp\MainBundle\Model\JobStatusModel;
use GatotKaca\Erp\MainBundle\Model\JobTitleModel;
use GatotKaca\Erp\MainBundle\Model\LanguageModel;
use GatotKaca\Erp\MainBundle\Model\OfficeHourModel;
use GatotKaca\Erp\MainBundle\Model\ProvinceModel;
use GatotKaca\Erp\MainBundle\Model\ReligionModel;
use GatotKaca\Erp\UtilitiesBundle\Model\ModuleModel;
use GatotKaca\Erp\UtilitiesBundle\Model\RoleModel;
use GatotKaca\Erp\UtilitiesBundle\Model\SecurityModel;
use GatotKaca\Erp\UtilitiesBundle\Model\SettingModel;
use GatotKaca\Erp\UtilitiesBundle\Model\UserModel;

class ModelManager{
	private $em;
	private $helper;

	/**
	 * Register all model class to property
	 **/
	private $attendance;
	private $employee;
	private $overtime;
	private $company;
	private $country;
	private $department;
	private $district;
	private $education;
	private $joblevel;
	private $jobstatus;
	private $jobtitle;
	private $language;
	private $officehour;
	private $province;
	private $religion;
	private $module;
	private $role;
	private $security;
	private $setting;
	private $user;

	/**
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \GatotKaca\Erp\MainBundle\Helper\Helper $helper
	 **/
	public function __construct(\Doctrine\ORM\EntityManager $em = NULL, \GatotKaca\Erp\MainBundle\Helper\Helper $helper = NULL){
		$this->setManager($em, $helper);
	}

	/**
	 * Build Model Manager Object
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \GatotKaca\Erp\MainBundle\Helper\Helper $helper
	 **/
	public function setManager(\Doctrine\ORM\EntityManager $em = NULL, \GatotKaca\Erp\MainBundle\Helper\Helper $helper = NULL){
		if(!$this->em){
			$this->em		= $em;
			$this->helper	= $helper;
		}
	}

	public function getAttendance(){
		if(!$this->attendance){
			$this->attendance	= new AttendanceModel($this->em, $this->helper);
		}
		return $this->attendance;
	}

	public function getEmployee(){
		if(!$this->employee){
			$this->employee	= new EmployeeModel($this->em, $this->helper);
		}
		return $this->employee;
	}

	public function getOverTime(){
		if(!$this->overtime){
			$this->overtime	= new OverTimeModel($this->em, $this->helper);
		}
		return $this->overtime;
	}

	public function getCompany(){
		if(!$this->company){
			$this->company	= new CompanyModel($this->em, $this->helper);
		}
		return $this->company;
	}

	public function getCountry(){
		if(!$this->country){
			$this->country	= new CountryModel($this->em, $this->helper);
		}
		return $this->country;
	}

	public function getDepartment(){
		if(!$this->department){
			$this->department	= new DepartmentModel($this->em, $this->helper);
		}
		return $this->department;
	}

	public function getDistrict(){
		if(!$this->district){
			$this->district	= new DistrictModel($this->em, $this->helper);
		}
		return $this->district;
	}

	public function getEducation(){
		if(!$this->education){
			$this->education	= new EducationModel($this->em, $this->helper);
		}
		return $this->education;
	}

	public function getJobLevel(){
		if(!$this->joblevel){
			$this->joblevel	= new JobLevelModel($this->em, $this->helper);
		}
		return $this->joblevel;
	}

	public function getJobStatus(){
		if(!$this->jobstatus){
			$this->jobstatus	= new JobStatusModel($this->em, $this->helper);
		}
		return $this->jobstatus;
	}

	public function getJobTitle(){
		if(!$this->jobtitle){
			$this->jobtitle	= new JobTitleModel($this->em, $this->helper);
		}
		return $this->jobtitle;
	}

	public function getLanguage(){
		if(!$this->language){
			$this->language	= new LanguageModel($this->em, $this->helper);
		}
		return $this->language;
	}

	public function getOfficeHour(){
		if(!$this->officehour){
			$this->officehour	= new OfficeHourModel($this->em, $this->helper);
		}
		return $this->officehour;
	}

	public function getProvince(){
		if(!$this->province){
			$this->province	= new ProvinceModel($this->em, $this->helper);
		}
		return $this->province;
	}

	public function getReligion(){
		if(!$this->religion){
			$this->religion	= new ReligionModel($this->em, $this->helper);
		}
		return $this->religion;
	}

	public function getModule(){
		if(!$this->module){
			$this->module	= new ModuleModel($this->em, $this->helper);
		}
		return $this->module;
	}

	public function getRole(){
		if(!$this->role){
			$this->role	= new RoleModel($this->em, $this->helper);
		}
		return $this->role;
	}

	public function getSecurity(){
		if(!$this->security){
			$this->security	= new SecurityModel($this->em, $this->helper);
		}
		return $this->security;
	}

	public function getSetting(){
		if(!$this->setting){
			$this->setting	= new SettingModel($this->em, $this->helper);
		}
		return $this->setting;
	}

	public function getUser(){
		if(!$this->user){
			$this->user	= new UserModel($this->em, $this->helper);
		}
		return $this->user;
	}
}