<?php
namespace App\Code;

use App\Contract\TemplateAppContract;

class LaravelTemplateGenerator extends TemplateAppGenerator 
{

protected array $models = [];
protected array $attributes = [];

  public function loadSrc($json){
    $json = serializeJson(json_decode(file_get_contents($json)));
    // var_dump($json);
    // die;
    $this->output_dir = $json["output_dir"];

    //ajout des commandes de création des modèles 
    foreach ($json["models"] as $key => $value) {
        $this->addCommand("php ".$this->output_dir."/artisan make:model ".$key." --all ");
        // $this->prepareModel($value);
    }
    if(array_key_exists("models", $json)){
      $this->prepareModel($json["models"]);
    }
    

  }

  protected function addCommand(string $cmd){
    array_push($this->commandList, $cmd);
  }
  protected function prepareModel($model){
   
      foreach ($model as $key => $value) {
        // print_r($value);
           $classModel = ["property"=>["fillable"=>["visibility"=>["protected"], "value"=>""],
                            ],
                            "output_path"=>$this->output_dir."/App/Models/".$key.".php"
                          ];
           $classRequest1 = ["methods"=>["rules"=>[]]];
           $classRequest2 = ["methods"=>["rules"=>[]]];
           
           
           $classModel["name"] = $key;

           foreach ($value as $keys => $val) {
            # code...
          
        switch ($keys) {
            case 'attributes':
              $body_rules = "";
                  foreach ($val as $cle => $valeur) {
                    $body_rules = $body_rules.$cle."=>[".$valeur."],";
                  }
             array_push($classRequest1["methods"]["rules"], $body_rules);
             array_push($classRequest2["methods"]["rules"], $body_rules);
                  
                break;
              case 'fillable':
                $classModel["property"]["fillable"]["value"]=$val;
                // foreach ($val as $cle => $valeur) {
                //   $classModel["property"]["fillable"]["value"]=$classModel["property"]["fillable"]["value"]."'".$valeur."', ";
                // }
                // $classModel["property"]["fillable"]["value"] = $classModel["property"]["fillable"]["value"]."]";
              // print_r($classModel["property"]["fillable"]["value"]);
                break;
                
            
            default:
                # code...
                break;
        }
      }
       if(is_null($this->models)) $this->models = [];
        array_push($this->models, $classModel);
        // var_dump($this->models);
      }
  }
  protected function createModel(){
    foreach ($this->models as $key => $value) {
      echo "generation de la classe ".$value["name"];
     $code = new TemplateCodeGenerator(sourceCode:json_encode($value));
     $code->loadFromExistingCodeSrc($this->output_dir."/App/Models/".$value["name"].".php");
     
     $code->loadFromJson(json_encode($value));
    //  $code->generate($value);
     $code->generate();
     
    }
  }
  protected function finalCommande(){
    array_push($this->commandList, "php ".$this->output_dir."/artisan migrate ");
    array_push($this->commandList, "php ".$this->output_dir."/artisan serve ");

  }
  protected function creationCommand(){
    array_push($this->commandList, "composer create-project laravel/laravel ".$this->output_dir);

  }

  public function execute(){
      $this->loadSrc("json/laravelTest.json");
      // $this->creationCommand();
      // $this->runCommand();
      $this->createModel();
  }


}




?>