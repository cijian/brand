<?php
/**
 * Created by PhpStorm.
 * User: cijian
 * Date: 2018/8/27
 * Time: 下午6:13
 */

use Tools\Tool;

//spl_autoload_register(function ($class) {
//    include dirname($_SERVER['SCRIPT_FILENAME']) . '/' . str_replace('\\', '/', $class) . '.class.php';
//});

//This feature has been DEPRECATED as of PHP 7.2.0. Relying on this feature is highly discouraged.
//function __autoload($class) {
//    include dirname($_SERVER['SCRIPT_FILENAME']) . '/' . str_replace('\\', '/', $class) . '.class.php';
//}

include('./Tools/Tool.class.php');

$letter = [
    'A' => [],
    'B' => [],
    'C' => [],
    'D' => [],
    'E' => [],
    'F' => [],
    'G' => [],
    'H' => [],
    'I' => [],
    'J' => [],
    'K' => [],
    'L' => [],
    'M' => [],
    'N' => [],
    'O' => [],
    'P' => [],
    'Q' => [],
    'R' => [],
    'S' => [],
    'T' => [],
    'U' => [],
    'V' => [],
    'W' => [],
    'X' => [],
    'Y' => [],
    'Z' => [],
];

$brandCvs = 'brands.csv';
$tool = new Tool();

$filesize = filesize($brandCvs);
$brand = [];

//设置大于 10M才分段读取吧
if($filesize > 1024*1024*10){
    $start = 0;
    $line = 10;

    while (($brands = $tool->read_csv_lines($brandCvs,4096,$start,$line)) != false){
        $brand =  array_merge($brand,$brands);

        if (empty($brands) || count($brands) <$line){
            break;
        }

        $start = $line + $start;
        echo $start;
    }

}else{
    $brand = $tool->read_csv_lines($brandCvs,4096);
}


ksort($brand);


foreach ($brand as $k=>$v) {
    $first = $tool->getFirstString($k);
    if(isset($letter[$first])){
        $letter[$first][$k] = $v;
    }
}

$chuck_letter = array_chunk($letter,2,true);
$html = '';
foreach ($chuck_letter as $ck=>$cv){
    $key = [];
    $li = '';
    foreach ($cv as $cck=>$ccv) {
        $key[] = $cck;
        foreach ($ccv as $bk=>$bv){
            $bk = htmlspecialchars($bk);
            $li .= '<div class="brand"><img src="'.htmlspecialchars($bv).'" alt="'.$bk.'" title="'.$bk.'" /></div>';
        }

    }
    if(!empty($li)){
        $html .= '<div class="col"><h2>'.implode('-',$key).'</h2>'.$li.'</div>';
    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>brand</title>
    <link rel="stylesheet" href="./css/style.css"/>
</head>
    <body>

<header>
    <h1>Brands</h1>
</header>

<div class="row">
<?php echo $html; ?>
</div>

</body>
</html>



