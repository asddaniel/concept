<?php
namespace App\Code;

class CustomFileGenerator{

    protected $srcFile;
    protected $contentFile;
    protected string $output_path;
    public function __construct($srcFile=""){
            $this->srcFile = $srcFile;
            if(!empty($this->srcFile)){
                $this->contentFile = file_get_contents($srcFile);
            }
    }

    public function generate(){
        
             if(!empty($this->output_path)){
                file_put_contents($this->output_path, trim($this->contentFile));
             }
            
        
    }
    public function set_output_path($path){
        $this->output_path = $path;
    }
   public function get_content(){
    return $this->contentFile;
   }
   public function add_after_position(string $ref, int $pas, string $data){
    
    // ini_set('memory_limit', '-1');
   
    $fichier = file($this->srcFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  
    $end_file = "";
    $execute = 0;
    $def_pas = -1;
    foreach ($fichier as $key => $value) {
        if(preg_match("/".$ref. "/", $value) && $execute==0){
            $end_file.="
".trim($value);
$def_pas = $key;
$execute++;
        }else{
            if($key==$def_pas+$pas && $def_pas>=0){
                 echo $value;
                $end_file.="
".trim($value)."
".$data;
            }
            $end_file.="
".$value;
        }
    }
    $this->contentFile = $end_file;
    // unlink($end_file);

   }
   public function addLine_by_position(int $position, string $line){
    $fichier = file($this->srcFile);
    $end_file="";
    foreach ($fichier as $key => $value) {
       if($key==$position){
        $end_file.=$line."
".$value;
       }else{  $end_file.="
".$value;}
    }
    // print_r($end_file);
$this->contentFile = $end_file;
   }
   public function patch_between(string $ref_start, string $ref_end, string $patch){
               $fichier = file($this->srcFile);
               $start = -1;
               $end = -1;
               $final_file = "";
               $tab_patcher = [];
               foreach ($fichier as $key => $value) { 
                   if(preg_match("/".$ref_start."/", $value)){
                       $start = $key;
                   }
                  if($ref_end == trim($value) && $start>=0){
                   $end = $key;
                  }
               }
if($start>-1 && $end>-1){
    
    foreach ($fichier as $key => $value) {
        if($key==$start){ array_push($tab_patcher, $value);
        }elseif ($key>$start  && $key < $end) {    
            }else{
               
    array_push($tab_patcher, $value);

            }
    }
  foreach ($tab_patcher as $key => $value) {
    if($key==$start){
        $final_file.=$value."
".$patch."
";
    }else{
        $final_file.=$value;
    }
  }
  $this->contentFile = $final_file;
}


   }

   public function make_in_interval(string $ref_start, string $ref_end, int $saut, $data){
    $fichier = file($this->srcFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $pos_start = -1;
    $pos_end = -1;
    $final_file = "";
    foreach ($fichier as $key => $value) {
        if(preg_match("/".$ref_start."/", $value) && $pos_start<0){
               $pos_start = $key;  
        }

        if(preg_match("/".$ref_end."/", $value) && $pos_start>0 && $pos_end<0){
            $pos_end = $key;  
     }
    }
  foreach ($fichier as $key => $value) {
    if($key==$pos_start+$saut){
        $final_file.=$value."
".$data;
    }elseif ($key>$pos_start && $key<$pos_end) {
        
    }else{
        $final_file.="
".$value;
    }
  
  }
$this->contentFile = $final_file;

   }
   public function patchLine(string $reference_old_value, string $new_value){
    $file = $this->parseLine();
    $line = "";
    foreach ($file as $key => $value) {
        if(preg_match("/".$reference_old_value."/", $value)){
                $line = $value;
                break;
        }
    }
     if(!empty($line)){
        $this->contentFile = str_replace($line, $new_value, $this->contentFile);
     }else{
        $this->addText($new_value);
     }

   }

    private function parseLine()
        {
        return file($this->srcFile);
        }

    public function addText($text)
        {
            $this->contentFile.=$text; 
            
        }
        
    public function addNewLine($textLine)
    {
        $this->contentFile.="
".$textLine; 

    }

}


