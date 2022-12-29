<?php
namespace App\Code;

use Nette\PhpGenerator\Constant;


class ConstantGenerator extends PropertyGenerator{
    protected $allowed_visibility=["static", "protected", "private"];
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
        $this->code = new Constant($this->name);
        // var_dump($this->code);
        // $this->treat();

    }
}


?>