<?php
namespace App\Code; 

use Nette\PhpGenerator\Method;

class MethodGenerator extends CodeGenerator{

    /*
    @var visibility must be in protected, public, static, readonly, private

    **/

    protected string $name;
    protected string $type;
    protected array $visibility;
    protected array $comments;
    protected string $litteral;
     
   public function __construct(
    string $name, 
        array $visibility=[],
        string $litteral = "",
        string $type="", 
        array $comments = []

   ){

   }
         




}


?>