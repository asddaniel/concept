<?php
namespace App\Code;
use App\Contract\TemplateAppContract;

abstract class TemplateAppGenerator implements TemplateAppContract{

    public const command = "App";
    protected array $codes;
    protected array $sources = [];
    protected array $commandList = [];
    protected string $output_dir;
    protected array $startCommands= [];
    protected array $property = [];
    protected array $attributes = [];
    public function generate(){
       foreach ($this->codes as $key => $value) {
        $value->generate();
       }
    }
     
    protected function addSource($path){
       array_push($this->sources, $path);
    }
    public function runCommand(){
      foreach ($this->commandList as $key => $value) {
         echo $value;
         exec($value);
      }

    }


}


?>