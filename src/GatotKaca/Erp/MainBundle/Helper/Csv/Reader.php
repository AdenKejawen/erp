<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Helper/Csv/Reader.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Helper\Csv;

/**
 * Class untuk membaca file CSV
 * 
 * @private $file
 * @private $delimiter
 * @private $length
 * @private $line
 * @private $data
 **/
class Reader{
	private $file;
	private $delimiter;
	private $length;
	private $line;
	private $data;
	
	/**
	 * Class Initialization
	 * 
	 * @param string $file
	 * @param string $delimiter
	 * @param number $length
	 * @param string $mode
	 */
	public function __construct($file, $delimiter = ',', $length = 1000, $mode = 'r'){
		if($this->file	= fopen($file, $mode)){
			$this->delimiter	= $delimiter;
			$this->length	= $length;
			$this->line	= 0;
		}else{
			exit("The file {$file} can't be read.");
		}
	}
	
	/**
	 * Baris pertama adalah penanda field jadi tidak dianggap sebagai data
	 **/
	private function readCsv(){
		while($csv	= fgetcsv($this->file, $this->length, $this->delimiter)){
			$this->line++;
			if($this->line != 1){//Exclude first line
				$this->data[]	= $csv;
			}
		}
		$this->close();
	}
	
	private function close(){
		fclose($this->file);
	}
	
	/**
	 * Get CSV Data
	 * 
	 * @return mixed:
	 **/
	public function getData(){
		$this->readCsv();
		return $this->data;
	}
}