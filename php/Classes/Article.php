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
		$newArticleAuthorId = self::validateUuid($newArticleAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
}
//convert and store the tweet id
$this->articleAuthorId = $newArticleAuthorId;
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
	if(empty($newArticleTitle) === true) {
		throw(new \InvalidArgumentException("this title is invalid"));
	}
//verify the article title will fit in the database
	if(strlen($newArticleTitle) >= 50) {
		throw(new \RangeException("Nah. Make this shorter."));
	}
	//convert and store the new title
	$this->articleTitle = $newArticleTitle;
}


/*
PDO
starts
here:
*/

public function insert(\PDO $pdo) : void {

		$query = "INSERT INTO Article(articleAuthorId, articleId, articleFilterId, articleDatePublished,
articleDescription, articleTitle) VALUES(:articleAuthorId, :articleId, :articleFilterId, :articleDatePublished,
:articleDescription, :articleTitle)";
		$statement = $pdo->prepare($query);

// bind the member variables to the place holders in the template
		$parameters = ["articleAuthorId" => $this->articleAuthorId->getBytes(), "articleId" => $this->articleId->getBytes(),
			"articleFilterId" => $this->articleFilterId, "articleDatePublished" => $this->articleDatePublished,
			"articleDescription" => $this->articleDescription, "articleTitle" => $this->articleTitle];

		$statement->execute($parameters);
	}

/**
 * deletes this Article from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {

// create query template
	$query = "DELETE FROM article WHERE articleAuthorId = :articleAuthorId";
	$statement = $pdo->prepare($query);

// bind the member variables to the place holder in the template
	$parameters = ["articleAuthorId" => $this->articleAuthorId->getBytes()];
	$statement->execute($parameters);
}

/**
 * updates this Article in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) : void {

// create query template
	$query = "UPDATE Article SET articleAuthorId = :articleAuthorId, articleId = :articleId, articleFilterId = :articleFilterId,
articleDatePublished = :articleDatePublished, articleDescription = :articleDescription, articleTitle = :articleTitle";
	$statement = $pdo->prepare($query);


	$parameters = ["articleAuthorId" => $this->articleAuthorId->getBytes(),"articleId" => $this->articleId->getBytes(),
		"articleFilterId" => $this->articleFilterId->getBytes(), "articleDatePublished" => $this->articleDatePublished->getBytes(),
		"articleDescription" => $this->articleDescription->getBytes(), "articleTitle" => $this->articleTitle->getBytes();]

	
$statement->execute($parameters);
};

/**
* gets the Article by articleId
*
* @param \PDO $pdo PDO connection object
* @param Uuid|string $articleId article id to search for
* @return Article|null Article found or null if not found
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError when a variable are not the correct data type
**/
public static function getArticleByArticleId(\PDO $pdo, $articleId) : ?Article {
// sanitize the articleId before searching
try {
$articleId = self::validateUuid($articleId);
} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
throw(new \PDOException($exception->getMessage(), 0, $exception));
}

// create query template
$query = "SELECT articleId, articleAuthorId, articleFilterId, articleDatePublished, articleDescription, articleTitle FROM article WHERE articleId = :articleId";
$statement = $pdo->prepare($query);

// bind the tweet id to the place holder in the template
$parameters = ["articleId" => $articleId->getBytes()];
$statement->execute($parameters);

// grab the tweet from mySQL
try {
$article = null;
$statement->setFetchMode(\PDO::FETCH_ASSOC);
$row = $statement->fetch();
if($row !== false) {
$article = new Tweet($row["articleId"], $row["articleAuthorId"], $row["articleFilterId"],
	$row["articleDatePublished", $row["articleDescription"], $row["articleTitle"]);
}
} catch(\Exception $exception) {
// if the row couldn't be converted, rethrow it
throw(new \PDOException($exception->getMessage(), 0, $exception));
}
return($article);
}

/**
* gets the Article by article author id
*
* @param \PDO $pdo PDO connection object
* @param Uuid| $articleAuthorId author id to search by
* @return \SplFixedArray SplFixedArray of Articles found
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError when variables are not the correct data type
**/
public static function getArticleByArticleAuthorId(\PDO $pdo, $articleAuthorId) : \SplFixedArray {

try {
$articleAuthorId = self::validateUuid($articleAuthorId);
} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
throw(new \PDOException($exception->getMessage(), 0, $exception));
}

// create query template
$query = "SELECT articleId, articleAuthorId, articleFilterId, articleDatePublished, articleDescription, articleTitle FROM article WHERE articleAuthorId = :articleAuthorId";
$statement = $pdo->prepare($query);
// bind the tweet profile id to the place holder in the template
$parameters = ["articleAuthorId" => $articleAuthorId->getBytes()];
$statement->execute($parameters);
// build an array of tweets
$article = new \SplFixedArray($statement->rowCount());
$statement->setFetchMode(\PDO::FETCH_ASSOC);
while(($row = $statement->fetch()) !== false) {
try {
$articles = new Article($row["articleId"], $row["articleAuthorId"], $row["articleFilterId"], $row["articleDatePublished"],
	$row["articleDescription"], $row["articleTitle"]);
$articles[$articles->key()] = $article;
$articles->next();
} catch(\Exception $exception) {
// if the row couldn't be converted, rethrow it
throw(new \PDOException($exception->getMessage(), 0, $exception));
}
}
return($article);
}

/**
* gets the Article by article description
 *
* @param \PDO $pdo PDO connection object
* @param string $articleDescription to search for
* @return \SplFixedArray SplFixedArray of Articles found
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError when variables are not the correct data type
**/
public static function getArticleByArticleDescription(\PDO $pdo, string $articleDescription) : \SplFixedArray {
// sanitize the description before searching
$articleDescription = trim($articleDescription);
$articleDescription = filter_var($articleDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
if(empty($articleDescription) === true) {
throw(new \PDOException("article description is invalid"));
}

// escape any mySQL wild cards
$articleDescription = str_replace("_", "\\_", str_replace("%", "\\%", $articleDescription));

// create query template
$query = "SELECT articleId, articleAuthorId, articleDescription, articleFilterId, articleDatePublished, articleTitle 
FROM article WHERE articleDescription LIKE :articleDescription";
$statement = $pdo->prepare($query);

// bind the tweet content to the place holder in the template
$articleDescription = "%$articleDescription%";
$parameters = ["articleDescription" => $articleDescription];
$statement->execute($parameters);

// build an array of tweets
$articles = new \SplFixedArray($statement->rowCount());
$statement->setFetchMode(\PDO::FETCH_ASSOC);
while(($row = $statement->fetch()) !== false) {
try {
$article = new Article($row["articleId"], $row["articleAuthorId"], $row["articleDescription"], $row["articleFilterId"],
	$row["articleDatePublished"], $row["articleTitle"]);
$article[$articles->key()] = $article;
$articles->next();
} catch(\Exception $exception) {
// if the row couldn't be converted, rethrow it
throw(new \PDOException($exception->getMessage(), 0, $exception));
}
}
return($articles);
}

/**
* gets all Articles
*
* @param \PDO $pdo PDO connection object
* @return \SplFixedArray SplFixedArray of Tweets found or null if not found
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError when variables are not the correct data type
**/
public static function getAllArticles(\PDO $pdo) : \SPLFixedArray {
// create query template
$query = "SELECT articleId, articleAuthorId, articleDescription, articleFilterId, articleDatePublished, articleTitle FROM article";
$statement = $pdo->prepare($query);
$statement->execute();

// build an array of tweets
$articles = new \SplFixedArray($statement->rowCount());
$statement->setFetchMode(\PDO::FETCH_ASSOC);
while(($row = $statement->fetch()) !== false) {
try {
$article = new Article($row["articleId"], $row["articleAuthorId"], $row["articleDescription"], $row["articleFilterId"],
	$row["articleDatePublished"], $row["articleTitle"]);
$articles[$articles->key()] = $article;
$articles->next();
} catch(\Exception $exception) {
// if the row couldn't be converted, rethrow it
throw(new \PDOException($exception->getMessage(), 0, $exception));
}
}
return ($articles);
}

/**
* formats the state variables for JSON serialization
*
* @return array resulting state variables to serialize
**/
public function jsonSerialize() : array {
$fields = get_object_vars($this);

$fields["articleId"] = $this->articleId->toString();
$fields["articleAuthorId"] = $this->articleAuthorId->toString();

return($fields);
}
}