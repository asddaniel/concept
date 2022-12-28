<?php
namespace App\Code;

abstract class CodeGenerator {

    protected $code;
    protected string $output_dir;

    public abstract function treat();
}



?>