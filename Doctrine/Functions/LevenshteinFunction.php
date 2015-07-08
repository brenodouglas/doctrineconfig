<?php
namespace RespectDoctrine\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class LevenshteinFunction extends FunctionNode
{
    public $expr1 = null;

    public $expr2 = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'LEVENSHTEIN('.
            $this->expr1->dispatch($sqlWalker).', '.
            $this->expr2->dispatch($sqlWalker).
        ')';
    }
}