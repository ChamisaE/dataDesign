<?php
namespace Cedmo\DataDesign;
require_once("../Classes/Article.php");

$date = new \DateTime('now');
//the constructor is executed here
$Article = new Article("e08e550f-a39d-47c0-acac-0d23958647fe", "7373b074-6763-4500-86f6-ae1bd93cb4f7", "7373b074-6763-4500-86f6-ae1bd93cb4f7",
	$date, "This article shows the reader how to live in Tonga", "How to live in Tonga");

var_dump($Article);

