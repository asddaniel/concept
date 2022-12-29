<?php
namespace App\Command;
use App\Code\LaravelTemplateGenerator;

class Kernel{



    protected array $commandList = [];

    public function __construct($commandList = []){
        $GLOBALS["command"] = [];
        $this->commandList = $GLOBALS["command"];
    }

public static function register(string $command){

    if(is_null($GLOBALS["command"])) $GLOBALS["command"]=[];
  array_push($GLOBALS["command"], $command);
}

public static function execute($instruction){
    foreach ($GLOBALS["command"] as $key => $value) {
        $app = new $value();
        $app->execute();
    }
    echo "commande received";
}

}



?>