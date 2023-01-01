<?php
namespace App\Code\Templates\Laravel;

use App\Contract\TemplateAppContract;
use App\Code\TemplateAppGenerator;

class LaravelTemplateGenerator extends TemplateAppGenerator 
{

protected array $models = [];
protected array $attributes = [];
protected array $classRequestList = [];
protected array $classControllerList = [];
protected array $routeList = [];

  public function loadSrc($json){
    $json = serializeJson(json_decode(file_get_contents($json)));
    
    $this->output_dir = $json["output_dir"];
    $this->creationCommand();
    //ajout des commandes de création des modèles 
    foreach ($json["models"] as $key => $value) {
        $this->addCommand("php ".$this->output_dir."/artisan make:model ".$key." --all ");
       
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
       
           $classModel = ["property"=>["fillable"=>["visibility"=>["protected"], "value"=>""],
                            ],
                            "output_path"=>$this->output_dir."/App/Models/".$key.".php"
                          ];
            
                          
          $classRequest1 = ["methods"=>[["name"=>"rules", "literal"=>""],
                                        ["name"=>"authorize", "literal"=>"return true;"]         ], 
                                        
                                        "extends"=>"Illuminate\Foundation\Http\FormRequest",
                                       
                                       
                                          "name"=>"Store".$key."Request",
                                          "output_path"=>$this->output_dir."/App/Http/Requests/Store".$key."Request.php"];
          $classRequest2 = ["methods"=>[["name"=>"rules", "literal"=>""],
         
                                          ["name"=>"authorize", "literal"=>"return true;"]         ], 
                                         
                                          "extends"=>"Illuminate\Foundation\Http\FormRequest",
                                          
                                            "name"=>"Update".$key."Request",
                                            "output_path"=>$this->output_dir."/App/Http/Requests/Update".$key."Request.php"];
           
           
           $classModel["name"] = $key;

           foreach ($value as $keys => $val) {
            # code...
          
        switch ($keys) {
            case 'attributes':
             
              $body_rules = "";
           
            foreach ($val as $cle => $valeur) {
              $body_rules = $body_rules."'".$cle."'=>'".$valeur."',";
            }



             $classRequest1["methods"][0]["literal"]= " [".$body_rules."];";
             $classRequest2["methods"][0]["literal"]= "[".$body_rules."];";
                  
                break;
              case 'fillable':
                $classModel["property"]["fillable"]["value"]=$val;
                break;
                
            
            default:
                # code...
                break;
        }
      }
       if(is_null($this->models)) $this->models = [];
       if(is_null($this->classRequestList)) $this->classRequestList = [];
       array_push($this->classRequestList, $classRequest1);
       array_push($this->classRequestList, $classRequest2);
        array_push($this->models, $classModel);
        // var_dump($this->models);
      }
  }
  protected function createRoute(){
    $route = new PhpFileGenerator(output_path:$this->output_dir."/routes/api.php");
    $route->loadFromFile(file_get_contents($this->output_dir."/routes/api.php"));
    foreach ($this->models as $key => $value) {
      $route->addUse("App\Http\Controllers\\".$value["name"]."Controller");
      $route->addLine("Route::resource('".$value['name']."', ".$value["name"]."Controller::class)->except(['create', 'edit']);");
      
    }
    echo "
    géneration des routes
    ";
    $route->generate();
   

  }
  protected function createModel(){
    foreach ($this->models as $key => $value) {
      $this->generateClass("App/Models", $value);
      
     
    }
  }
  private function generateClass(string $path, $class){

    echo " generation de la classe ".$class["name"]."
    ";
     $code = new TemplateCodeGenerator(sourceCode:json_encode($class));
     
     $code->loadFromExistingCodeSrc($this->output_dir."/".$path."/".$class["name"].".php");
     
     $code->loadFromJson(json_encode($class));
    
     $code->generate();

  }
  protected function createRequest(){
    foreach ($this->classRequestList as $key => $value) {
      // print_r($value);
       $this->generateClass("App/Http/Requests", $value);
    }

  }
  protected function finalCommande(){
    // array_push($this->commandList, "php ".$this->output_dir."/artisan migrate ");
    array_push($this->commandList, " php ".$this->output_dir."/artisan serve ");

  }
  protected function creationCommand(){
    array_push($this->commandList, "composer create-project laravel/laravel ".$this->output_dir);

  }

  public function execute(){
    
      $this->loadSrc("json/laravelTest.json");
     
      // $this->finalCommande();
    
      $this->runCommand();
      $this->createModel();
      $this->createRequest();
      $this->createRoute();
  }


}




?>