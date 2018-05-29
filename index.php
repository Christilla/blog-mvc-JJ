<?php
session_start();
require_once ('./connexion.php');

if(isset($_GET['controller']) && isset($_GET['action'])){
    $controller = $_GET['controller'];
    $action = $_GET['action'];
}else{
//    $controller = 'pages';
//    $action = 'home';
    $controller = 'annonces';
    $action = 'index';
}

/**
 * tests
 */
/*$buffer = "J'aime bien les nains, surtout ceux qui mangent des patates et qui aiment faire des choses.";
$wordArray = explode(' ', $buffer);
$wordArray = ['patates', 'nains', 'choses'];
$buffer = str_replace($wordArray, '<span style="color: #ff7b31;"> [Censuré] </span>', $buffer);
echo $buffer;

function tick_handler()
{
    echo '<br>';
    echo "tick_handler() called\n";
}

$a = 1;
tick_handler();

if ($a > 0) {
    $a += 2;
    tick_handler();
    echo '<br>';
    print($a);
    tick_handler();
}
tick_handler();*/
require_once ('views/layout.php');


/**
 * @param $pWhat
 */

function printr($pWhat){
    echo '<pre>';
    print_r($pWhat);
    echo '</pre>';
}

/**
 * @param $pWhat
 */
function vardump($pWhat){
    echo '<pre>';
    var_dump($pWhat);
    echo '</pre>';
}
