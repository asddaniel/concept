<?php
namespace app\Domain;
class Exemple{

    protected $fillable = ["users"];
   //propriétés de la classe
   public $a;
  public $b;
  private $c;
   public function __construct($a =0, $b=0, $c=0){
    if(is_array($a)){
        [$this->a, $this->b, $this->c] = $a;
    }
    
    //  $this->a = $a;
    //  $this->b = $b;
    //  $this->c = $c;
   }

   public function __set($attribute, $value){
       echo "impossible";
   }
}


?>