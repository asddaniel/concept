<?php
namespace App\Code; 

use Nette\PhpGenerator\Method;

class MethodGenerator extends CodeGenerator{

    /*
    @var visibility must be in protected, public, static, readonly, private, abstract

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

    $this->name = $name;
    $this->type = $type;
    $this->visibility = $visibility;
    $this->comments = $comments;
    $this->litteral = $vlitteral;
    $this->code = new Method($this->name);
    $this->treat();
   }


   public function get(){
    return $this->code;
}
protected function setType(){
    if(!empty($this->type)){
       
        $this->code->setType($this->type);
    }
}

protected function setValue(){
    if(!empty($this->value)){
        $this->code->setValue($this->value);
    }
}

protected function setVisibility(){
    foreach ($this->visibility as $key => $value) {
               
        switch ($value) {
            case 'private':
                $this->code->setPrivate();
                break;
            case 'abstract':
                    $this->code->setAbstract();
                    break;
            case 'protected':
                $this->code->setProtected();
                break;
            case 'static':
                    $this->code->setStatic();
                    break;
            case 'final':
                     $this->code->setFinal();
                    break;
           
            case 'readonly':
                $this->code->setReadonly();
                break;
            
            default:
                # code...
                break;
        }
    
    }
}
         




}


?>