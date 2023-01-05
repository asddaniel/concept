<?php
namespace App\Code\Templates;
use App\Contract\TemplateAppContract;
use App\Command\Command;


abstract class TemplateAppGenerator implements TemplateAppContract{

    protected const command = "App";
    protected const manifest_file_name = "manifest.json";
    
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

    public function get_start_cmd(){
       return $this::command;
    }
     
    protected function addSource($path){
       array_push($this->sources, $path);
    }
    public function runCommand(){
      foreach ($this->commandList as $key => $value) {
         
           
         Command::exec($value);
         // sleep(2);
      }

    }


}


?>