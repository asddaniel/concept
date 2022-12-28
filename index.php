<?php  
include("init.php");
use app\Command\Command;
use app\Domain\Exemple;
use App\Code\ClasseGenerator;
use App\Code\PropertyGenerator;
use App\Code\ConstantGenerator;
use App\Code\MethodGenerator;
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
$tab = ["pasteur", "ionic", "portable"=>52, "parapluie"];
foreach ($tab as $key => $value) {
    // echo $key.PHP_EOL;
   if(is_int($key)){
    // echo "entier-";
   }else{
    echo "chaine-";
   }
}
$classe = new ClasseGenerator(name:"Client", methods:[new MethodGenerator(name: "participer", literal:"return view('accueil');", visibility:['protected', 'static'])], constants:[new ConstantGenerator(name:"euler", value:45, visibility:["static", "private"], comments:["method"])], property:[new PropertyGenerator(name:"user", value:"fred", type:"string", comments:["hello"], visibility:["protected", "readonly"])], use:["pop", "App\contract"], traits:["App\Models", "App\Http\Request"], implements: ["Bouari", "portable"], output_path:"output/Client.php", visibility:["abstract", "readonly"]);
// $classe->treat();
?>