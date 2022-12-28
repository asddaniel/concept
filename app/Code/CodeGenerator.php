<?php
namespace App\Code;

abstract class CodeGenerator {

    protected $code;
    protected string $output_path;
    protected array $comment = [];
    

    public abstract function treat();

    public function generate(){
             if(!empty($this->output_path)){
                file_put_contents($this->output_path, $this->code);
             }
            
        
    }
    public function get(){
        return $this->code;
    }
    protected function addComment(){
     
        // $this->code = $this->code->setInitialized(true);
    foreach ($this->comments as $key => $value) {
      
        $this->code->addComment($value);
    }

}
}



?>