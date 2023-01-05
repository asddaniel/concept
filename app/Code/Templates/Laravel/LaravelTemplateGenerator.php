<?php
namespace App\Code\Templates\Laravel;

use App\Contract\TemplateAppContract;
use App\Code\Templates\TemplateAppGenerator;
use App\Code\PhpFileGenerator;
use App\Code\TemplateCodeGenerator;
use App\Command\Command;
use App\Code\CustomFileGenerator;
use Nette\PhpGenerator\PhpFile;



class LaravelTemplateGenerator extends TemplateAppGenerator 
{

protected array $models = [];
protected array $attributes = [];
protected array $classRequestList = [];
protected array $classControllerList = [];
protected array $finalCommande=[];
protected array $routeList = [];
protected array $env = [];
protected array $database = [];
protected const command = "laravel-app";
protected  $manifest_file_name = "laravelManifest.json";

  
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

    if(array_key_exists("env", $json)){
      $this->prepare_env();
    }
    if(array_key_exists("database", $json)){
        $this->database = $json["database"];
    }
    if(array_key_exists("name", $json)){
      $this->add_env("APP_NAME", $json["name"]);
    }
    if(array_key_exists("finalize", $json)){
      // echo trim($json["finalize"])=="true"?"-ok-":"-non-";
      if(trim($json["finalize"])=="true"){
        array_push($this->finalCommande, "php ".$this->output_dir."/artisan migrate ");
        array_push($this->finalCommande, "php ".$this->output_dir."/artisan serve");
      }
    }

  }
  private function add_env($key, $value){
    $this->env[$key] = $value;
  }

  
  protected function generate_env(){
    $file = new CustomFileGenerator(srcFile:$this->output_dir."/.env");
    foreach ($this->env as $key => $value) {
         $file->patchLine($key, $key."=".$value."
");
    }
   $file->set_output_path($this->output_dir."/.env");
   $file->generate();
  }

  protected function prepare_env(){
      
  }

  protected function treatControllers(){
    echo "
      génération des controllers
    ";
    foreach ($this->models as $key => $value) {
      $controllers = PhpFile::fromCode(file_get_contents($this->output_dir."/app/Http/Controllers/".$value['name']."Controller.php"));
       $class = $controllers->getClasses();
       foreach ($class as $cle => $valeur) {
          $valeur->removeMethod("create");
          $valeur->removeMethod("edit");
          $valeur->removeMethod("store");
          $valeur->removeMethod("update");
          $valeur->removeMethod("show");
          $valeur->removeMethod("destroy");
          $valeur->removeMethod("index");
       
    //index method 
      $method = $valeur->addMethod('index')
	->addComment('Display a listing of the resource.')
	->setBody('return response()->json('.$value["name"].'::all());');
   

  //store
  $method = $valeur->addMethod('store')
	->addComment('Store a newly created resource in storage.')
	->setBody('return response()->json('.$value["name"].'::create($request->validated()));');
  $method->addParameter('request') // $items = []
	->setType('App\Http\Requests\Store'.$value["name"]."Request"); 

  //show 
  $method = $valeur->addMethod('show')
	->addComment('Display the specified resource.')
	->setBody('return response()->json($'.strtolower($value["name"]).');');
  $method->addParameter(strtolower($value['name'])) // $items = []
	->setType('App\Models\\'.$value["name"]); 

  //update
  $method = $valeur->addMethod('update')
	->addComment('Update the specified resource in storage.')
	->setBody('return response()->json($'.strtolower($value["name"]).'->update($request->validated()));');
  $method->addParameter(strtolower($value['name'])) 
	->setType('App\Models\\'.$value["name"]);
  $method->addParameter("request")
	->setType("App\Http\Requests\Update".$value['name']."Request");  

   //destroy 
   $method = $valeur->addMethod('destroy')
   ->addComment('Remove the specified resource from storage.')
   ->setBody('return response()->json($'.strtolower($value["name"]).'->delete());');
   $method->addParameter(strtolower($value['name'])) // $items = []
   ->setType('App\Models\\'.$value["name"]); 

       }
   //generer la classe
  $this->writeFile($controllers, $this->output_dir."/app/Http/Controllers/".$value['name']."Controller.php");
       
    }

  }

  protected function writeFile($data, $path){
      file_put_contents($path, $data);
  }
  protected function generate_migrations(){
    foreach ($this->models as $key => $value) {
                  $dir = dir($this->output_dir.'/database/migrations');
                  $fichiers = array() ;
                  while( $nom = $dir->read() ) $fichiers[] = $nom ;

                  $GLOBALS["temp"] = strtolower($value["name"]);
                  $data = array_ordonne(array_filter($fichiers, function($e){
                    
                      return preg_match("/".$GLOBALS["temp"]."/", $e);
                  }));

$file_name = $data[0];
$this->writeColumnMigration($value["type"], $file_name);
    }
    echo"
    generation des migrations
    ";
  }
  protected function writeColumnMigration($columns, $file_name){
          $file = new CustomFileGenerator($this->output_dir."/database/migrations/".$file_name);

          $writer = "";
          foreach ($columns as $key => $value) {
  $writer.="
            @table->".$value."('".$key."');";
          }
          $file->patch_between("timestamps", "});", str_replace("@", "$", $writer));
          $file->set_output_path($this->output_dir."/database/migrations/".$file_name);
          $file->generate();
          
  }
  protected function addCommand(string $cmd){
    array_push($this->commandList, $cmd);
  }
  protected function config_database(){

    foreach ($this->database as $key => $value) {
      switch ($key) {
        case 'db_name':
           $this->add_env("DB_DATABASE", $value);
          break;
        case 'username':
            $this->add_env("DB_USERNAME", $value);
          break;
        case 'host' :
          $this->add_env("DB_HOST", $value);
          break;
        case 'password':
          $this->add_env("DB_PASSWORD", $value);
          break;
        
        default:
          # code...
          break;
      }
    }

  }
  protected function prepareModel($model){
   
      foreach ($model as $key => $value) {
       
           $classModel = ["property"=>["fillable"=>["visibility"=>["protected"], "value"=>""],
                            ],
                            "extends"=>"Illuminate\Database\Eloquent\Model",
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
           $classModel["type"] =$val;
            foreach ($val as $cle => $valeur) {
              $body_rules = $body_rules."'".$cle."'=>'".$valeur."',
              ";
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
    $ibinder = "Schema::defaultStringLength(191);";
    foreach ($this->models as $key => $value) {
      $this->bindProvider($value);
      $ibinder.="Route::bind('".$value['name']."', function(".str_replace("@", "$", "@value")."){
        return ".$value['name']."::findOrFail(".str_replace("@", "$", "@value").");
    });
";
    }

    $file = PhpFile::fromCode(trim(file_get_contents($this->output_dir."/app/Providers/AppServiceProvider.php")));
    $classes = $file->getClasses();
    foreach ($file->getNamespaces() as $key => $value) {
      $value->addUse("Illuminate\Support\Facades\Schema");
    }
   
    $class = "";
    foreach ($classes as $key => $value) {
     $value->removeMethod("boot");
     
     $class = $value;
    }
    $class->addMethod("boot");
    file_put_contents($this->output_dir."/app/Providers/AppServiceProvider.php", trim($file));
    $file = new CustomFileGenerator($this->output_dir."/app/Providers/AppServiceProvider.php");
    $file->make_in_interval("boot", "}", 1, $ibinder);
$file->set_output_path($this->output_dir."/app/Providers/AppServiceProvider.php");

 $file->generate();
   

  }

  protected function bindProvider($model){
    // print_r($this->output_dir);
    try {
      $provider = PhpFile::fromCode(trim(file_get_contents($this->output_dir."/app/Providers/AppServiceProvider.php")));
  
    } catch (Nette\InvalidStateException $th) {
      print_r($th);
    }
     $namespace = $provider->getNamespaces();
    foreach ($namespace as $key => $value) {
      $value->addUse("App\Models\\".$model['name']);
      $value->addUse("Illuminate\Support\Facades\Route");
      
    }
    file_put_contents($this->output_dir."/app/Providers/AppServiceProvider.php", $provider);
   

  
  }
  protected function createModel(){
    foreach ($this->models as $key => $value) {
      $this->generateClass("App/Models", $value);
      
     
    }
  }
  private function generateClass(string $path, $class){

    echo " generate  class ".$class["name"]."
    ";
     $code = new TemplateCodeGenerator(sourceCode:json_encode($class));
     
     $code->loadFromExistingCodeSrc($this->output_dir."/".$path."/".$class["name"].".php");
     
     $code->loadFromJson(json_encode($class));
    
     $code->generate();

  }
  protected function createRequest(){
    foreach ($this->classRequestList as $key => $value) {
      
       $this->generateClass("App/Http/Requests", $value);
    }

  }
  protected function finalCommande(){
    echo "
    running final command";
    
    foreach ($this->finalCommande as $key => $value) {
      Command::exec($value);
    }
    

  }
  protected function creationCommand(){
    array_push($this->commandList, "composer create-project laravel/laravel ".$this->output_dir);

  }

  public function execute(){
       
      $this->loadSrc("manifest/".$this->manifest_file_name);
      
    
  
      $this->config_database();
      $this->runCommand();
      $this->createModel();
      $this->createRequest();
      $this->treatControllers();
      $this->createRoute();
      $this->generate_migrations();
      $this->generate_env();
      $this->finalCommande();
  }


}




?>