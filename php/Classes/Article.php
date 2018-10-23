<?php
namespace Cedmo\DataDesign;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 *
 */

class Article {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this author; this is the primary key for the table
	 * @var Uuid $articleAuthorId
	 */
	/*
	 *id for the article itself; this is the primary key for the article table
	 * @var Uuid $articleId
	 */
	private $articleId;
	/*
	*id for the article author; this is a foreign key for this table.
	 *@var Uuid $articleAuthorId
	 */
	private $articleAuthorId;
	/*
	 *id for the author of the article; this is a foreign key
	 *@var Uuid $articleFilterId
	 */
	private $articleFilterId;
	/*
	 *date and time that this article was submitted, in a PHP DateTime object
	 * @var \DateTime $articleDatePublished
	 */
	private $articleDatePublished;
	/*
	 *short text content of this article
	 * @var string $articleDescription
	 */
	private $articleDescription;
	/*
	 *text of article title
	 * @var string $articleTitle
	 */
	private $articleTitle;

	/*Constructor for this Tweet
	 *
	 * @param string|Uuid $newArticleId
	 * @param string|Uuid $newArticleAuthorId
	 * @param string|Uuid $newArticleFilterId
	 * @param string|
	 * @param
	 * @param
	 *
	 * and time
	 * @throws
	 * @throws
	 * @throws
	 * @throws
	 * @throws
	 * @throws
	 *
	 */
public function __construct($newArticleAuthorId, $newArticleId, $newArticleFilterId, $newArticleDatePublished,
									 string $newArticleDescription, string $newArticleTitle) {
try {
	$this -> setArticleAuthorId($newArticleAuthorId);
	$this -> setArticleId($newArticleId);
	$this -> setArticleFilterId($newArticleFilterId);
	$this -> setArticleDatePublished($newArticleDatePublished);
	$this -> setArticleDescription($newArticleDescription);
	$this -> setArticleTitle($newArticleTitle);
}
//determine what exception type was thrown
catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	$exceptionType = get_class($exception);
	throw(new $exceptionType($exception->getMessage(), 0, $exception));
}
}
/*
 * accessor method for tweet id
 * @return Uuid value of tweet id
 */
public function getArticleAuthorId() : Uuid {
	return($this->articleAuthorId);
	//this outside of class
	//$this->getTweetId();
}
/*
 * mutator method for author id
 * @param Uuid|string $new
 * @throws \RangeException if $newTweetId is not positive
 * @throws\TypeError if $newTweetId is not a uuid or string
 */
public function setArticleAuthorId( $newArticleAuthorId) : void {
	try {
		$Uuid = self::validateUuid($newArticleAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
}
//convert and store the tweet id
$this->tweetId = $Uuid;
	}
	/*
	 * accessor method for article id
	 * @return uuid value of tweet profile id
	 */
public function getArticleId() : uuid{
	return($this->articleId);
}
/*
 * mutator for article id
 *
 * @param
 * @throws
 * @throws
 */
public function setArticleId( $newArticleId) : void {
	try {
		$uuid = self::validateUuid($newArticleId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

	//convert and store the new article id
	$this->articleId = $uuid;
}
/*accessor method for article filter id
*
 * @return string uuid value for filter id
*/
public function getArticleFilterId() : Uuid{
	return($this->articleFilterId);
}
/*
 * mutator for article id
 *
 * @param
 * @throws
 * @throws
 */
public function setArticleFilterId( $newArticleFilterId) : void {
	try {
		$uuid = self::validateUuid($newArticleFilterId);
	} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

	//convert and store the new article filter id
	$this->articleFilterId = $uuid;
}
/*
 * accessor method for articleDatePublished
 * @return dateTime for date published
 */
public function getArticleDatePublished() : \DateTime{
	return($this->articleDatePublished);
}
/*
 * mutator for article date published
 *
 * @param
 * @throws
 * @throws
 */
public function setArticleDatePublished( $newArticleDatePublished) : void {
	try {
		$uuid = self::validateDateTime($newArticleDatePublished);
	} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(),0, $exception));
	}

	//convert and store the new article date published id
	$this->articleDatePublished = $uuid;
}
/*
 * accessor method for article description
 * @return description in a string
 */
public function getArticleDescription() : string {
	return($this->articleDescription);
}
/*
 * mutator for article description
 *
 * @param
 * @throws
 * @throws
 */
public function setArticleDescription( $newArticleDescription) : void {
	//verify the description content is secure
$newArticleDescription = trim($newArticleDescription);
$newArticleDescription = filter_var($newArticleDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
if(empty($newArticleDescription) === true){
	throw(new \InvalidArgumentException("description content is empty or insecure"));
}
	//verify the tweet content will fit in the database
if(strlen($newArticleDescription) >= 140) {
	throw(new \RangeException("Yo. Make this more concise."));
}
//store the description content
	$this->articleDescription = $newArticleDescription;
}
/*
 * accessor method for article title
 *
 * @return article title in a string
 */
public function getArticleTitle() : string {
	return($this->articleTitle);
}
/*
 * mutator for article description
 *
 * @param
 * @throws
 * @throws
 */
public function setArticleTitle( $newArticleTitle) : void {
//verify the article title is secure
	$newArticleTitle = trim($newArticleTitle);
	$newArticleTitle = filter_var($newArticleTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newArticleTitle) === true){
		throw(new \InvalidArgumentException("this title is invalid"));
	}
//verify the article title will fit in the database
	if(strlen($newArticleTitle) >= 50) {
		throw(new \RangeException("Nah. Make this shorter."));
	}
	//convert and store the new title
	$this->articleTitle = $newArticleTitle;
}
}



