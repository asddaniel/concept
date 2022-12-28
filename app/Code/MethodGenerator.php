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
    protected string $literal;
    protected string $src;
    /* 
        @var parameters must be an array mixed of each parameters and their property
        eg. [ 
            "params"=>[
                'reference'=>true,
                'type'=>'string',
                'nullable'=>true, 

            ]
        ]
    **/
    protected array $parameters;
     
   public function __construct(
    string $name, 
        array $visibility=[],
        string $literal = "",
        string $type="", 
        string $src= "",
        array $comments = [],
        array $parameters = []

   ){

    $this->name = $name;
    $this->type = $type;
    $this->visibility = $visibility;
    $this->comments = $comments;
    $this->literal = $literal;
    $this->code = new Method($this->name);
    $this->parameters = $parameters;
    $this->src = $src;
    $this->treat();
   }

   public function treat(){
    $this->load();
    $this->setType();
    $this->setVisibility();
    $this->setParameters();
    $this->setLiteral();
    $this->addComment();
}

public function load(){
    /*load from src

    **/
    if(!empty($this->src)){
        $this->code = Method::from($this->src);
    }
    
}


   public function get(){
    return $this->code;
}
protected function setLiteral(){
    $this->code->addBody($this->literal);
}
protected function setParameters(){
    foreach ($this->parameters as $key => $value) {
        if(is_array($value)){
            $this->addProperty_to_parameters($this->code->addParameter($key), $value);

            
        }else{
            $this->code->addParameter($value);
        }

    }
}

private function addProperty_to_parameters(&$parameter, array $property){
    foreach ($property as $cle => $valeur) {
                 switch ($cle) {
                    case 'reference':
                        if($valeur) $parameter->setReference();
                        break;
                    case'type':
                            $parameter->setType($valeur);
                        break;
                    case 'nullable':
                            if($valeur) $parameter->setNullable();
                        break;
                    
                    default:
                        # code...
                        break;
                 }
    }
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