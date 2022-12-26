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

    public function __construct($type, $source){
        $this->source = $source;
        $this->type = $type;

    }

}

?>