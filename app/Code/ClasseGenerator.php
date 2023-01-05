<?php
namespace App\Code;

use \Exception;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PhpFile;
use Nette\InvalidStateException;
use Nette\PhpGenerator\Constant;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\Property;
use App\Traits\Helper;

class ClasseGenerator  extends CodeGenerator{

    use Helper;


    protected string $namespace;
    protected  string $name;
    
    /* 
            @var visibility must containt abstract, final or Readonly or the three

        **/
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
    protected  ClassType $main_class;
    protected  array $traits;
    protected PhpNamespace $mainNamespace;
    /*
    @var removable array associative with three key 
    eg. $removable = [
        "property"=>["fillable", "time"],
        "methods"=>["store", "create"],
        "const"=>["limit", "euler"]
    ]

    **/
    protected array $removable;

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
        array $traits = [],
        bool $strict_type = false,
        string $namespace = "", 
        string $output_path="",
        array $removable= []
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
        $this->traits = $traits;
        $this->removable = $removable;
        

       


    }
   

    public function treat(){
        $this->code = new PhpFile();
        if(!empty($this->src)){
            
            $this->code = PhpFile::fromCode(file_get_contents($this->src), true);
            $class = $this->code->getClasses();
            $this->main_class = $class[array_key_first($class)];
            
          
            
        }else{
            if(!empty($this->name)){
               $this->setNamespace();
               
            }else{
                
                throw new Exception('You must give a name for the class');
               
            }
        }
        
        $this->setActions();
        $this->setVisibility();
        $this->setComment();
        $this->setExtends();
        $this->setImplements();
        $this->setConstants();
        $this->setProperty();
        $this->setMethods();
        $this->setActions();
        $this->setUses();
        $this->setStrictType();
        $this->setTraits();
        


    }


    protected function setVisibility(){ 
        foreach ($this->visibility as $key => $value) {
            if($value=="abstract") $this->main_class->setAbstract();
            if($value=="final")   $this->main_class->setFinal();
            if($value=="Readonly" || $value =="readonly")   $this->main_class->setReadonly();
           
        }
    }

    protected function setComment(){
        foreach ($this->comments as $key => $value) {
            $this->main_class->addComment($value);
        }
    }
    
    public function addComment( string $comment){
        
            $this->main_class->addComment($comment);
        
    }

    public function addConstant(Constant $const){
        array_push($this->constants, $const);
    }

    public function addMethod(Method $method){
        array_push($this->methods, $method);
    }

    public function addProperty(Property $property){
        
        array_push($this->property, $property);
    }

    public function set($property, $value){
        $array_forbid = ["methods", "constants", "property"];
        if(!in_array($property, $array_forbid)){
            parent::set($property, $value);
        }
    }

    protected function setExtends(){
        $this->main_class->setExtends($this->extends);
    }

    protected function setImplements(){
            foreach ($this->implements as $key => $value) {
                $this->main_class->addImplement($value);
            }
    }
    public function addConst_reference( string $name){
        return $this->main_class->addConstant($name);
    }
    protected function setConstants(){
        
            foreach ($this->constants as $key => $value) {
                
                    $this->main_class->addMember($value);
                
            }
    }

    protected function setProperty(){
       
        foreach ($this->property as $key => $value) {
           
             $this->main_class->removeProperty($value->getName());
             $this->main_class->addMember($value);
        
    }

    }

    protected function setMethods(){
        
        foreach ($this->methods as $key => $value) {
          try {
            
            $this->main_class->removeMethod($value->getName());
            $this->main_class->addMember($value);
          } catch (InvalidStateException $th) {
            echo " erreur impossible de crée la méthode $th";
          }   
            
        
    }

    }

    protected function setActions(){
        foreach ($this->removable as $key => $value) {
           switch ($key) {
            case 'property':
                foreach ($value as $cle => $valeur) {
                    $this->main_class->removeProperty($valeur);
                }
                break;
            case 'methods':
                    foreach ($value as $cle => $valeur) {
                        $this->main_class->removeMethod($valeur);
                    }
                    break;
            case 'const':
                        foreach ($value as $cle => $valeur) {
                            $this->main_class->removeConstant($valeur);
                        }
                    break;
            
            default:
                # code...
                break;
           }
        }
    }
    protected function setUses(){
        
        foreach ($this->use as $key => $value) {
            $this->mainNamespace->addUse(str_replace("/", "\\", $value));
        }

    }
    protected function setTraits(){
        foreach ($this->traits as $key => $value) {
            $this->main_class->addTrait($value);
        }

    }

    protected function setStrictType(){
        if($this->strict_type){
            $this->code->setStrictTypes();
        }
    }

    protected function setNamespace(){
        if(!empty($this->namespace)){
            
            
            $this->mainNamespace  = $this->code->addNamespace(str_replace("/", "\\", $this->namespace));
            $this->main_class = $this->mainNamespace->addClass($this->name);
            
           
        }else{
            $this->main_class = $this->code->addClass($this->name);
        }
        
    }

}



?>