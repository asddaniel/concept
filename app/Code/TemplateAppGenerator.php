<?php
namespace App\Code;

class TemplateAppGenerator{

    public const command = "App";
    protected array $codes;
    public function generate(){
       foreach ($this->codes as $key => $value) {
        $value->generate();
       }
    }


}


?>