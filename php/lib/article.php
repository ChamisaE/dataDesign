<?php
namespace Cedmo\DataDesign;
require_once(dirname(__DIR__, 2) . "/Classes/autoload.php");
//the constructor is executed here
$Article = new Article("f70cca9c3c614215c6926e92c175bb13", "0102a8ddef86432c99e9380f08bb184a", "a5e9088de81b4f55dfa066e7d4429db6",
	"8/1/2018", "This article shows the reader how to live in Tonga", "How to live in Tonga");

//change the object's state
//$Article -> setArticleDescription("This article shows the reader how to live in Tonga");

//access the object's state

var_dump($Article);

