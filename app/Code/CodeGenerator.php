<?php
namespace App\Code;

abstract class CodeGenerator {

    protected $code;
    protected string $output_path;
    

    public abstract function treat();

    public function generate(){
       
            file_put_contents($this->output_path, $this->code);
        
    }
}



?>