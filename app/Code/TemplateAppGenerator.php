<?php
namespace App\Code;
use App\Contract\TemplateAppContract;

abstract class TemplateAppGenerator implements TemplateAppContract{

    public const command = "App";
    protected array $codes;
    protected array $sources = [];
    protected array $command_list = [];
    protected string $output_dir;
    protected array $startCommands= [];
    protected array $property;
    protected array $attributes;
    public function generate(){
       foreach ($this->codes as $key => $value) {
        $value->generate();
       }
    }
     
    protected function addSource($path){
       array_push($this->sources, $path);
    }
    // public function execute(){

    // }


}


?>