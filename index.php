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
// $code = PhpFile::fromCode(file_get_contents("test/app/Http/Controllers/ArticleController.php"));
// $classe = $code->getClasses();
// foreach ($classe as $key => $value) {
//     $value->removeMethod("index");
//     echo($code);
    
//     die;
// }
$final_file = "";
$fichier = file("test2/database/migrations/2023_01_04_195903_create_clients_table.php");
$start = "";
foreach ($fichier as $key => $value) {
    $val = "});";
    // echo $key."
    // ";
    if(preg_match("/timestamps/", $value)){
        $start = $key;
    }
   if($val == trim($value)){
    $end = $key;
    // print_r($value);
   }
}
$tab_patcher = [];
foreach ($fichier as $key => $value) {
    if($key==$start){ 
        array_push($tab_patcher, $value);
        $final_file.= "
        ";}elseif ($key>$start  && $key < $end) {
          
        }else{
            $final_file.="
".$value; array_push($tab_patcher, $value);
        }
}
print_r($tab_patcher);
// // $code = new PhpFile();
// $code->addUse("Illuminate\Support\Facades\Route");
// $code->addUse("Illuminate\Support\Facades\Helpers");
// //$code->setStrictTypes(); // adds declare(strict_types=1)
// $file = new CustomFileGenerator("test/database/migrations/2023_01_01_045548_create_clients_table.php");
// //$code = PhpFile::fromCode(file_get_contents("test/database/migrations/2023_01_01_045548_create_clients_table.php"));
// $x = "
//         Schema::create('produits', function (Blueprint @table) {
//             @table->id();
//             @table->string('title');
// ";
// $file->patchLine("timestamps", str_replace("@", "$", $x));
// echo($file->get_content());

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
// $file = file_get_contents("test/.env");
// $tab = file('test/.env');
// // var_dump($tab);
// for($i=0 ; $i<count($tab) ; $i++){
//     $research = "app_name";
//    echo preg_match("/".strtoupper($research)."/", $tab[$i]);
// echo $tab[$i].'<br>';
// }
// $file = new CustomFileGenerator(srcFile:"test/.env");
// $file->addText("bonjour");

// $dir = dir('test/database/migrations');
// $fichiers = array() ;
// while( $nom = $dir->read() ) $fichiers[] = $nom ;
// // print_r($fichiers);
// $data = array_filter($fichiers, function($e){
//     $art = "article";
//     return preg_match("/".$art."/", $e);
// });
// print_r($data);

?>