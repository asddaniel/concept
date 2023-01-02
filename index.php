<?php  
include("init.php");
use app\Command\Command;
use app\Domain\Exemple;
use App\Code\ClasseGenerator;
use App\Code\PropertyGenerator;
use App\Code\ConstantGenerator;
use App\Code\MethodGenerator;
use App\Code\TemplateCodeGenerator;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Literal;
use App\Code\CustomFileGenerator;
// // $class = new Nette\PhpGenerator\ClassType('Demo');
// $class = Nette\PhpGenerator\ClassType::fromCode(file_get_contents("app/Domain/Exemple.php", true));
// $method = $class->getMethod('__set')->cloneWithName("__set");
// $code = PhpFile::fromCode(file_get_contents("output1/routes/web.php"), "eeef");
// // $code = new PhpFile();
// $code->addUse("Illuminate\Support\Facades\Route");
// $code->addUse("Illuminate\Support\Facades\Helpers");
// //$code->setStrictTypes(); // adds declare(strict_types=1)

// $class = $code->addClass('Foo\A');
//  $function = $code->addFunction('Foo\foo');
// $literral = new Literal("trucmashin");
// $ajout = "
// Route::get('/', function () {
//     return view('welcome');
// });
// ";
//  echo $code.$ajout.$ajout;
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


// echo(serialize(["toto"=>"gggf"]));
// $generator = new TemplateCodeGenerator();
// $generator->loadFromSrc("json/class.json");
// $classe = new ClasseGenerator(name:"Client", src:"output/test.php", methods:[new MethodGenerator(name: "participer", removable_parameters:['value'], srcMethod:$method, literal:"return view('accueil');", visibility:['protected', 'static'])], constants:[new ConstantGenerator(name:"euler", value:45, visibility:["static", "private"], comments:["method"])], property:[new PropertyGenerator(name:"user", value:"fred", type:"string", comments:["hello"], visibility:["protected", "readonly"])], use:["pop", "App\contract"], traits:["App\Models", "App\Http\Request"], implements: ["Bouari", "portable"], output_path:"output/Client.php", visibility:["abstract", "readonly"]);
// $classe->treat();
$file = file_get_contents("test/.env");
$tab = file('test/.env');
// var_dump($tab);
for($i=0 ; $i<count($tab) ; $i++){
    $research = "app_name";
   echo preg_match("/".strtoupper($research)."/", $tab[$i]);
echo $tab[$i].'<br>';
}
// $file = new CustomFileGenerator(srcFile:"test/.env");
// $file->addText("bonjour");
?>