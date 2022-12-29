<?php
namespace App\Code;

use Nette\PhpGenerator\ClassType;


class TemplateCodeGenerator {

    protected string $src;
    protected ClassType $class;

    public function __construct(){

    }

    protected function treatClass($class){
        
        $this->class = new ClasseGenerator();
        foreach ($class as $key => $value) {
           switch ($key) {
            case 'constants':
               $this->treatConstant($value);
                break;
            case 'methods':
                $this->treatMethod($value);
                break;
            case 'property':
                $this->treatProperty($value);
                break;
            
            default: $this->class->set($key, $value);
                
                break;
           } 
        }
    }
   
    protected function treatConstant($constant){
        $constant = new ConstantGenerator($constant["name"]);
        foreach ($constant as $cle => $valeur) {
           $constant->set($cle, $valeur);
        }
        if(!empty($constant)){
            $constant->treat();
            $this->class->addConstant($constant->get());
        }
    }

    protected function treatMethod($method){
        $method = new MethodGenerator($method["name"]);
        foreach ($method as $cle => $valeur) {
           $method->set($cle, $valeur);
        }
        if(!empty($method)){
            $method->treat();
            $this->class->addMethod($method->get());
        }
    }

    protected function treatProperty($property){
        $property = new PropertyGenerator($property["name"]);
        foreach ($property as $cle => $valeur) {
           $property->set($cle, $valeur);
        }
        if(!empty($property)){
            $property->treat();
            $this->class->addProperty($property->get());
        }
    }


    
    
    public function loadFromJson($json){
          $data = json_decode($json);
    }
    public function loadFromSrc($src){
        $file = json_decode(file_get_contents($src));

    }
}


?>