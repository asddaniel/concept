<?php
namespace App\Code;

class CustomFileGenerator{

    protected $srcFile;
    protected $contentFile;
    public function __construct($srcFile=""){
            $this->srcFile = $srcFile;
            if(!empty($this->srcFile)){
                $this->contentFile = file_get_contents($srcFile);
            }
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


