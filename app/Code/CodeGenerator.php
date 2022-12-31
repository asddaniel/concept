<?php
namespace App\Code;

abstract class CodeGenerator {

    protected $code;
    protected string $output_path;
    protected array $comment = [];
    

    public abstract function treat();

    public function generate(){
        // echo $this->output_path;
             if(!empty($this->output_path)){
                file_put_contents($this->output_path, $this->code);
             }
            
        
    }
    protected function setComment(){
   
        foreach ($this->comments as $key => $value) {
            $this->code->addComment($value);
        }
    }
   
    public function set($property, $value){
        if(property_exists($this, $property)){
            $this->$property = $value;
        }
    }
    public function get(){
        return $this->code;
    }
    protected function addComment( string $comment){
     
        // $this->code = $this->code->setInitialized(true);
    foreach ($this->comments as $key => $value) {
      
        $this->code->addComment($value);
    }

}
}



?>