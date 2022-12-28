<?php
namespace App\Code;

use \Exception;
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
    protected string $output_path;
    protected $main_class;

    public function __construct(
        string $name = "",
        /* 
            @var visibility must containt abstract, final or Readonly or the three

        **/
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
        string $output_path=""
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
        $this->output_path = $output_path;


        $this->treat();


    }

    public function treat(){
        $this->code = new PhpFile();
        if(!empty($this->src)){
            
            $this->code = PhpFile::fromCode(file_get_contents($this->src), true);
            $class = $this->code->getClasses();
            $this->main_class = $class[array_key_first($class)];
            
            $this->output_path = "output/Client.php";
            
        }else{
            if(!empty($this->name)){
               $this->main_class =  $this->code->addClass($this->name);
            }else{
                //doit retourner une exception
                throw new Exception('You must give a name for the class');
                return 'impossible de crée une classe sans nom';
            }
        }
      
        $this->setVisibility();
        $this->generate($this->code);

    }


    protected function setVisibility(){ 
        foreach ($this->visibility as $key => $value) {
            if($value=="abstract") $this->main_class->setAbstract();
            if($value=="final")   $this->main_class->setFinal();
            if($value=="Readonly" || $value =="readonly")   $this->main_class->setReadonly();
           
        }
    }

}



?>