<?php
namespace App\Code;

use App\Contract\TemplateAppContract;

class LaravelTemplateGenerator extends TemplateAppGenerator 
{

protected array $models;

  public function loadSrc($json){
    $json = json_decode(serializeJson($json));
    $this->output_dir = $json["output_dir"];
    if(array_key_exists("startCommands", $json)){
        foreach ($this->startCommands as $key => $value) {
            //  array_push($this->commandList, $value);
        }
    }
    foreach ($json->models as $key => $value) {
        array_push($this->commandList, "php ".$this->output_dir."artisan make:model ".$key." --all");
    }
    

  }
  protected function finalCommande(){
    array_push($this->commandList, "php ".$this->output_dir."artisan migrate ");
    array_push($this->commandList, "php ".$this->output_dir."artisan serve ");

  }
  protected function creationCommand(){
    array_push($this->commandList, "composer create-project laravel/laravel ".$this->output_dir);

  }

  public function execute(){

  }


}




?>