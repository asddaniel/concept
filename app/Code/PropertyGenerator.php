<?php
namespace App\Code;

use Nette\PhpGenerator\Property;


class PropertyGenerator extends CodeGenerator{
    protected string $name;
    protected string $type;
    protected array $visibility;
    protected array $comments;
    protected string $code;

    public function __construct(
        string $name, 
        array $visibility,
        string $type="", 
        array $comments = []
        
    ){
        $this->name = $name;
        $this->type = $type;
        $this->visibility = $visibility;
        $this->comment = $comments;
        $this->code = new Property($this->name);
        $this->treat();

    }

    public function treat(){
        $this->setType();
    }
    protected function setType(){
        if(!empty($this->type)){
            $this->code->setType($this->type);
        }
    }
}


?>