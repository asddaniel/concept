<?php
namespace App\Command;

class Command{

    protected String $type;
    protected string $source;
    protected string $prefix = "";
    protected array $list = [];
    protected string $target_dir;
    protected string $description;
    protected string $tag;
    public  array  $childProcess = [];
    private   $forbidden = [
        "childProcess",
        "source",
        "prefix"
    ];

    public function __construct( String $type="standard", String  $source="", String $prefix="",
    array $list=[], string $target_dir="", string $description="", string $tag="", array $childProcess=[]){
        $this->source = $source;
        $this->type = $type;
        $this->prefix = $prefix;
        $this->list = $list;
        $this->target_dir = $target_dir;
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
    public function set_target_dir($dir){
        $this->target_dir = $dir;
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

    public function run():void   {
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
            // echo gettype($value)."---";
            if(gettype($value)=="object"){
                // echo "objetrouvé";
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