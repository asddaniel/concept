<?php  
include("init.php");
use app\Command\Command;
use app\Domain\Exemple;
use App\Code\ClasseGenerator;
// // $class = new Nette\PhpGenerator\ClassType('Demo');
// $class = Nette\PhpGenerator\ClassType::fromCode(file_get_contents("app/Domain/Exemple.php", true));

// $class->setFinal()
// 	->setExtends(ParentClass::class)
// 	->addImplement(Countable::class)
// 	->addComment("Description of class.\nSecond line\n")
// 	->addComment('@property-read Nette\Forms\Form $form');

// // to generate PHP code simply cast to string or use echo:
// echo $class;

// $file = file_put_contents("test.php", $class);
// 	

// $commandes = new command(source:"article", type:"standard");
// $commandes->setPrefix("");
// $commandes->list = ["php --version", "java"];
// $commandes->run();
// $cmd = new Command();
// $cmd->setSource("json/index1.json");
// $cmd->run();

// $exemple = new Exemple([1, 2, 3]);
// var_dump($exemple->a);
// $exemple->c = "alors";

$classe = new ClasseGenerator(name:"Client", output_path:"output/Client.php", visibility:["abstract", "readonly"]);
// $classe->treat();
?>