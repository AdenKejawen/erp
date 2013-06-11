<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Doctrine/DQL/PostgreSQL/Walker/OrderByNullWalker.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 * 
 * Fungsi doctrine untuk support NULLS FIRST | LAST
 **/
namespace GatotKaca\Erp\MainBundle\Doctrine\DQL\PostgreSQL\Walker;

use Doctrine\ORM\Query\SqlWalker;

class OrderByNullWalker extends SqlWalker{
	const NULLS_FIRST = 'NULLS FIRST';
	const NULLS_LAST = 'NULLS LAST';
	
	public function walkOrderByClause($orderByClause){
		$sql	= parent::walkOrderByClause($orderByClause);
		$query	= $this->getQuery();
		if($nullFields	= $query->getHint('OrderByNullWalker.NullOrder')){
			if(is_array($nullFields)){
				$sql	= explode(' ', str_replace(array(' ORDER BY ', ','), '', $sql));
				$expr	= array();
				$field	= array();
				foreach($sql as $key => $val){
					if($key % 2 === 1){
						array_push($expr, $val);
					}else{
						array_push($field, $val);
					}
				}
				//Create New SQL Statement
				$sql	= " ORDER BY ";
				if(count($field) && count($nullFields)){
					$i	= 0;
					foreach($nullFields as $key => $val){
						$sql	.= "{$field[$i]} {$expr[$i]} {$val}, ";
						$i++;
					}
				}
				$sql	= trim($sql, ', ');
			}
		}
		return " ".$sql;
	}
}