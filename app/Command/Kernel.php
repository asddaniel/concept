<?php
namespace App\Command;

class Kernel{



    protected array $commandList = [];

    public function __construct($commandList = []){
        $GLOBALS["command"] = [];
        $this->commandList = $GLOBALS["command"];
    }

public static function register(string $command){
  array_push($GLOBALS["command"], $command);
}

public static function execute($instruction){
    echo "commande received";
}

}



?>