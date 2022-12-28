<?php
namespace App\Code;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PhpFile;

class ClasseGenerator  extends CodeGenerator{
    protected string $namespace;
    protected  string $name;
    protected array $visibility;
    protected string $extends ;
    protected array $implements; 
    protected array $comments; 
    protected array $constants; 
    protected array $property; 
    protected array $methods; 
    protected array $actions;
    protected string $src;
    protected array $use;
    protected bool $strict_type;
    protected string $output_dir;

    public function __construct(
        string $name = "",
        array $visibility = [],
        string $extends = "",
        array $implements = [], 
        array $comments = [], 
        array $constants = [], 
        array $property = [], 
        array $methods = [],
        string $src = "",
        array $actions = [], 
        array $use = [], 
        bool $strict_type = false,
        string $namespace = "", 
        string $output_dir=""
    )
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->extends = $extends;
        $this->implements = $implements; 
        $this->comments = $comments; 
        $this->constants = $constants; 
        $this->property = $property; 
        $this->methods = $methods; 
        $this->actions = $actions;
        $this->src = $src;
        $this->use = $use;
        $this->strict_type = $strict_type;
        $this->namespace = $namespace;
        $this->output_dir = $output_dir;


        $this->treat();


    }

    public function treat(){
        $this->code = new PhpFile();
        if(!empty($this->src)){
            
            $this->code = PhpFile::fromCode(file_get_contents($this->src), true);
           
            file_put_contents("output/test.php", $this->code);
        }


    }

}



?>