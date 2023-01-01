<?php
namespace App\Code;

use Nette\PhpGenerator\PhpFile;

class PhpFileGenerator extends CodeGenerator{
 
      protected array $lines_codes = [];
    public function __construct($output_path="", $lines_codes=[]){
         $this->output_path = $output_path;
         $this->lines_codes = $lines_codes;
    }

    public function loadFromJson(){
         
    }

    public function loadFromFile( string $codeSrc){
       $this->code = PhpFile::fromCode($codeSrc);
    }
    public function addUse($classNamespace){
        $this->code->addUse($classNamespace);
    }
    public function addLine($line){
        array_push($this->lines_codes, $line);
    }

    public function treat(){
        $data = "
 ";
        foreach ($this->lines_codes as $key => $value) {
            $data = $data."
".$value;
        }
        $this->code = $this->code.$data;

    }
    public function generate(){
       $this->treat();
        if(!empty($this->output_path)){
            file_put_contents($this->output_path, $this->code);
         }
    }

}


?>