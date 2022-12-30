<?php
namespace App\Code;

use Nette\PhpGenerator\ClassType;


class TemplateCodeGenerator {

    protected string $src;
    protected  $class;
    /*
        lien ou path to the src code
    **/
    protected $sourceCode;
    protected $sourceFile;

    public function __construct($sourceCode = [], $sourceFile = ""){
          $this->sourceCode = $sourceCode;
          $this->sourceFile = $sourceFile;
    }

    public function treatClass($class){
        
        
        foreach ($class as $key => $value) {
           switch ($key) {
            case 'constants':
                foreach ($value as $cle => $valeur) {
                    $this->treatConstant($cle, $valeur);
                }
               
                break;
            case 'methods':
                foreach ($value as $cle => $valeur) {
                $this->treatMethod($valeur);
                }
                break;
            case 'property':
                
            foreach ($value as $cle => $valeur) {
               
                $this->treatProperty($cle, $valeur);
            }
                break;
            
            default: $this->class->set($key, $value);
                
                break;
           } 
        }
        $this->class->treat();
    }
   
    protected function treatConstant($name, $constant){
        $mainconstant = new ConstantGenerator($name);
        foreach ($constant as $cle => $valeur) {
           $mainconstant->set($cle, $valeur);
        }
        if(!empty($constant)){
            $mainconstant->treat();
            $this->class->addConstant($mainconstant->get());
        }
    }

    protected function treatMethod($method){
        
        $main_method = new MethodGenerator($method["name"]);
        foreach ($method as $cle => $valeur) {
            
           $main_method->set($cle, $valeur);
        }
        if(!empty($method)){
            // print_r($main_method);
            $main_method->treat();
            $this->class->addMethod($main_method->get());
        }
    }

    protected function treatProperty($name, $property){
        
        $mainproperty = new PropertyGenerator($name);
        foreach ($property as $cle => $valeur) {
            //  print_r($value);
           $mainproperty->set($cle, $valeur);
        }
        if(!empty($property)){
            $mainproperty->treat();
            // var_dump($this->class);
            $this->class->addProperty($mainproperty->get());
        }
    }


    
    
    public function loadFromJson($json){
          $this->sourceFile = json_decode($json);
         
    }
    public function loadFromExistingCodeSrc($src){
         $this->sourceCode = $src;
    }
    public function loadFromSrc($src){
        $this->sourceFile= json_decode(file_get_contents($src));
        
        // $this->generate();

    }
    public function generate(){
        $this->class = new ClasseGenerator();
        // var_dump($this->sourceFile);
        if(!empty($this->sourceCode)){
            $this->class->set('src', $this->sourceCode);
        }
        if (!empty($this->sourceFile)) {
            // $this->class = new ClasseGenerator();
            $this->treatClass(serializeJson($this->sourceFile)); 
        }else{
            $this->class->treat();
        }
        
        echo "generation";
        $this->class->generate();
    }
}


?>