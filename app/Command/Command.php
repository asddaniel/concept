<?php
namespace App\Command;

class Command{

    protected String $type;
    protected string $source;
    protected string $prefix = "";
    protected array $list = [];
    protected string $description;
    protected string $tag;
    public  array  $childProcess = [];
    private   $forbidden = [
        "childProcess",
        "source",
        "prefix"
    ];

    public function __construct( String $type="standard", String  $source="", String $prefix="",
    array $list=[], string $description="", string $tag="", array $childProcess=[]){
        $this->source = $source;
        $this->type = $type;
        $this->prefix = $prefix;
        $this->list = $list;
        
        $this->description = $description;
        $this->tag = $tag;
        $this->childProcess = $childProcess;
        
        $_SESSION['concept_src']=[];
    }
    public function add_child(array $child){
        foreach ($child as $key => $value) {
            array_push($this->childProcess, $value);
        }
        
    }

    public function __set($property, $value){
         if(in_array(!in_array($property, $this->forbidden)) && property_exists($this, $property)){
             $this->$property = $value;
         }
    }
   
    public function setPrefix(string $prefix){
        $this->prefix = $prefix;
    }
    public function setList(array $cmd){
        $this->list = $cmd;
    }
    public function add_command(string $cmd):void
    {
            array_push($this->list, $cmd);
    }

    public function run():void   
    {
        

       $this->run_main_commands();
       $this->run_child();
       
    
    }
    protected function run_main_commands()
    {
        if(!empty($this->list)){
            
            foreach ($this->list as $key => $value) {
               
            $this->commande($this->prefix.$value);
               
            }
           
        }
    }
    protected function run_child()
    {
         foreach ($this->childProcess as $key => $value) {
              $value->run();
         }
    }

    protected function makedir(string $dirname){
        if(file_exists($dirname)){
             $this->commande("mkdir ".$dirname);
        }
    }
    protected function  commande(String $commande){
        return system($commande);
    }

    public static function exec($commande){
        return exec($commande);
    }

    public function setSource(string $path){
       
        $this->source = $path;
        $this->config_from_src();
    }

    private function config_from_src(){
        if(!is_null($this->source)){
            $data = json_decode(file_get_contents($this->source));
            foreach ($data as $key => $value) {
               if(property_exists($this, $key)){
               
                if($key == "source" && $value!=$this->source && ! in_array($value, $_SESSION['concept_src'])){
                       array_push($_SESSION['concept_src'], $value);
                        $this->setSource($value);
                        
                        return '';
                }elseif ($key=="list" &&  $this->has_object_in($value)) {
                         
                    foreach ($value as $cle => $valeur) {
                        if(is_object($valeur)){
                            $cmd = command::create( (array) $valeur);
                          array_push($this->childProcess, $cmd);
                        }else{
                           $this->add_command($valeur);
                        }
                    }

                }else{
                    
                    $this->$key = $value;
                }
                
               }
                
            }
            
            
        }
    }
    public function has_object_in(array $array){
        
           foreach ($array as $key => $value) {
           
            if(gettype($value)=="object"){
               
                 return true;
            }
           }
           return false;
    }
    public static function create(array $property){
          $commande  = new Command();
          foreach ($property as $key => $value) {
            if($key == "childProcess"){ $commande->add_child($value); 
            }elseif($key == "prefix"){ $commande->setPrefix($value); 
            }elseif($key == "source"){ $commande->setSource($value); 
            }else{
                $commande->$key = $value;
            }


          }

          return $commande;
    }

}

?>