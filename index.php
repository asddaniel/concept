<?php  
include("init.php");

// $class = new Nette\PhpGenerator\ClassType('Demo');
$class = Nette\PhpGenerator\ClassType::fromCode(file_get_contents("app/Domain/Exemple.php", true));

$class->setFinal()
	->setExtends(ParentClass::class)
	->addImplement(Countable::class)
	->addComment("Description of class.\nSecond line\n")
	->addComment('@property-read Nette\Forms\Form $form');

// to generate PHP code simply cast to string or use echo:
echo $class;

$file = file_put_contents("test.php", $class);
// 	




?>