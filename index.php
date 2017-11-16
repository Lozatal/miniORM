<?php

use \SGBD\query as query;
use \SGBD\model as model;
use \SGBD\article as article;
use \SGBD\categorie as categorie;
use \SGBD\connectionFactory as connectionFactory;

require_once ("src/utils/ClassLoader.php");

$loader = new ClassLoader('src/');
$loader->register();

connectionFactory::setConfig("conf/config.ini");

//Selection
/*
$query=query::table('article');
$query=$query->select(['id','nom'])->where('id','=',66)->get();
print_r($query);
*/
//Suppression
/*
$queryDelete=query::table('article');
$queryDelete->where('id','=',66)->delete(); 
*/
//Insertion
/*
$queryInsert=query::table('article');
$array = array(	'nom'=> "'téléphone'",
		'descr'=> "'sert à téléphoner,regarder des vidéos etc..'",
		'tarif'=> 599.99,
		'id_categ'=>1 );
echo $queryInsert->insert($array);

/*
$array = array( 'id' => 1,
		'text' => 'bla' 
);

$article = new article($array);

echo $article->text;

$article->truc = 'mwahahaha';
var_dump($article);
echo $article->truc;
*/

//Test class Model - Article

$article = new article();

$article->nom = 'livre jdr';
$article->descr = "pathfinder edition collector golden remasterised signed";
$article->tarif = 599.99;
$article->id_categ = 1;

//$article->insert();
//$article->delete();
/*
var_dump($article->all());

var_dump($article::find(66));

$array = array( 'id', 'nom');

$article::first(66, $array);
$categorie=$article->belongs_to('categorie','id_categ');
var_dump($categorie::first(1));

$cat=$article->categorie();
var_dump($cat::first(1));

*/
$categorie = new categorie();
$categorie = $categorie::first(1);
echo $categorie->id;
$art=$categorie->article;
echo $art[0]->nom;

echo "<br><br>";

$article = $article::first(66);
echo $article->id_categ;
$cat=$article->categorie();
echo $cat->nom;



























