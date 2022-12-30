<?php
namespace App\Code;

use Nette\PhpGenerator\Property;


class PropertyGenerator extends CodeGenerator{
    /*
    @var visibility must be in protected, public, static, readonly, private

    **/
    protected $allowed_visibility=["static", "readonly", "protected", "private"];
    protected string $name;
    protected string $type;
    protected array $visibility;
    protected array $comments;
    protected  $value;

    public function __construct(
        string $name, 
        array $visibility=[],
        string $value = "",
        string $type="", 
        array $comments = []
        
    ){
        $this->name = $name;
        $this->type = $type;
        $this->visibility = $visibility;
        $this->comments = $comments;
        $this->value = $value;
        $this->code = new Property($this->name);
         
        // $this->treat();

    }

    public function treat(){
        $this->setType();
        $this->setVisibility();
        $this->setValue();
        $this->setComment();
    }
   
    protected function setType(){
        if(!empty($this->type)){
           
            $this->code->setType($this->type);
        }
    }

    protected function setValue(){
        // print_r($this->value);
        if(!empty($this->value)){
            $this->code->setValue($this->value);
        }
    }

    protected function setVisibility(){
        foreach ($this->visibility as $key => $value) {
            if(in_array($value, $this->allowed_visibility)){         
            switch ($value) {
                case 'private':
                    $this->code->setPrivate();
                    break;
                case 'protected':
                    $this->code->setProtected();
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

    
}


?>