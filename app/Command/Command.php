<?php
namespace App\Command;
class Command{
    public String $type;
    public string $source;
    public string $prefix;
    public array $list = [];
    public string $target_dir;
    public string $description;
    public string $tag;

    public function __construct( String $type="standard", String  $source=""){
        $this->source = $source;
        $this->type = $type;

    }

    public function setPrefix(string $prefix){
        $this->prefix = $prefix;
    }
    public function setList(array $cmd){
        $this->list = $cmd;
    }
    public function add_command(string $cmd){
            array_push($this->list($cmd));
    }

    public function run(){
        $tab = [];
        // ob_start();
        if(!empty($this->list)){
            foreach ($this->list as $key => $value) {
               
            $array =    $this->commande(($this->prefix??"php ").$value);
               array_push($tab, $array); 
            }
           
        }
    //     $affiche = ob_get_contents();
    //     ob_end_clean();
    //    var_dump($tab);
    }
    protected function  commande(String $commande){
        return system($commande);
    }

}

?>