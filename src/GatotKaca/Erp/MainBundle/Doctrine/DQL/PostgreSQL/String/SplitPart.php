<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Doctrine/DQL/PostgreSQL/String/SplitPart.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 * 
 * Fungsi doctrine untuk mengambil string dengan pattern tertentu
 * 
 * SplitPartFunction ::= "SPLIT_PART" "(" "ArithmeticPrimary", "'ArithmeticPrimary'" , "'Position'" ")"
 **/
namespace GatotKaca\Erp\MainBundle\Doctrine\DQL\PostgreSQL\String;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class SplitPart extends FunctionNode{
	private $string		= NULL;
	private $delimiter	= NULL;
	private $position	= NULL;
	
	/**
	 * @param \Doctrine\ORM\Query\Parser $parser
	 **/
	public function parse(\Doctrine\ORM\Query\Parser $parser){
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);
		$this->string		= $parser->ArithmeticPrimary();
		$parser->match(Lexer::T_COMMA);
		$this->delimiter	= $parser->ArithmeticPrimary();
		$parser->match(Lexer::T_COMMA);
		$parser->match(Lexer::T_IDENTIFIER);
		
		$lexer = $parser->getLexer();
		$this->position	= $lexer->token['value'];
        
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
	
	/**
	 * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
	 **/
	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {
		return "SPLIT_PART({$this->string->dispatch($sqlWalker)}, {$this->delimiter->dispatch($sqlWalker)}, {$this->position})";
	}

}