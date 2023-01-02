<?php
namespace App\Command;
use App\Code\LaravelTemplateGenerator;

class Kernel{



    protected array $commandList = [];

    

protected  array $directive = [
    "create",
    "run"
];

public static function register(string $command){

    if(is_null($GLOBALS["command"])) $GLOBALS["command"]=[];
  array_push($GLOBALS["command"], $command);
}



public static function execute($instruction){
   $time = time();
    $verif = 0;
    foreach ($GLOBALS["command"] as $key => $value) {
        $app = new $value();
      
       
       if(md5(trim(strtolower($instruction)))==md5("create ".strtolower($app->get_start_cmd()))){
              $verif++;
        $app->execute();
       }
     
    }

    if($verif>0){
        echo "command finished in ".(time()-$time). "sec";
    }else{
        echo "no matching command found";
    }
    
}

}



?>