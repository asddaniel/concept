<?php
namespace App\Code;


class TemplateCodeGenerator {

    protected string $src;
    protected array $classes=[];

    public function __construct(){

    }

    protected function treatClass($class){
        $treated_class = $this->initialize_class();
        $final_classe = new ClasseGeberator();
        foreach ($class as $key => $value) {
           switch ($key) {
            case 'constants':
                foreach ($value as $cle => $valeur) {
                    # code...
                }
                break;
            
            default:$final_classe->$key = $value;
                
                break;
           } 
        }
    }
    private function initialize_class(){
         return [
            "name"=>"",
            "visibility" => [],
            "extends"=>"",
            "implements"=>[],
            "comments"=>[],
            "constants"=>[],
            "property"=>[],
            "methods"=>[],
            "actions"=>[],
            "use"=>[], 
            "traits"=>[],
            "removable"=>[],
            "src"=>"",
            "strict_type"=>false,
            "namespace"=>"",
            "output_path"=>""
         ];
    }
    public function loadFromJson($json){
          $data = json_decode($json);
    }
    public function loadFromSrc($src){
        $file = json_decode(file_get_contents($src));

    }
}


?>