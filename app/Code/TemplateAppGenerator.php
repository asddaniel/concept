<?php
namespace App\Code;

class TemplateAppGenerator{

    public const command = "App";
    protected array $codes;
    protected array $sources = [];
    public function generate(){
       foreach ($this->codes as $key => $value) {
        $value->generate();
       }
    }
     
    protected function addSource($path){
       array_push($this->sources, $path);
    }


}


?>