<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Doctrine/DQL/PostgreSQL/DateTime/ToChar.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 * 
 * Fungsi doctrine untuk merubah datetime jadi string
 * 
 * ToCharFunction ::= "TO_CHAR" "(" "ArithmeticPrimary", "'Format'" ")"
 **/
namespace GatotKaca\Erp\MainBundle\Doctrine\DQL\PostgreSQL\DateTime;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class ToChar extends FunctionNode{
	private $datetime	= NULL;
	private $format	= NULL;
	
	/**
	 * @param \Doctrine\ORM\Query\Parser $parser
	 **/
	public function parse(\Doctrine\ORM\Query\Parser $parser){
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);
		$this->datetime	= $parser->ArithmeticPrimary();
		$parser->match(Lexer::T_COMMA);
		$parser->match(Lexer::T_IDENTIFIER);
		
		$lexer = $parser->getLexer();
		$this->format	= $lexer->token['value'];
        
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
	
	/**
	 * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
	 **/
	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {
		return "TO_CHAR({$this->datetime->dispatch($sqlWalker)}, '{$this->format}')";
	}

}