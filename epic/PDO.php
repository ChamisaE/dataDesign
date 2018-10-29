<?php
/**
 * inserts this Tweet into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {

	$query = "INSERT INTO Article(articleAuthorId, articleId, articleFilterId, articleDatePublished,
articleDescription, articleTitle) VALUES(:articleAuthorId, :articleId, :articleFilterId, :articleDatePublished,
:articleDescription, :articleTitle)";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template
	$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
	$parameters = ["tweetId" => $this->tweetId->getBytes(), "tweetProfileId" => $this->tweetProfileId->getBytes(), "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
	$statement->execute($parameters);
}


/**
 * deletes this Tweet from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {

	// create query template
	$query = "DELETE FROM tweet WHERE tweetId = :tweetId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = ["tweetId" => $this->tweetId->getBytes()];
	$statement->execute($parameters);
}

/**
 * updates this Tweet in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) : void {

	// create query template
	$query = "UPDATE tweet SET tweetProfileId = :tweetProfileId, tweetContent = :tweetContent, tweetDate = :tweetDate WHERE tweetId = :tweetId";
	$statement = $pdo->prepare($query);


	$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
	$parameters = ["tweetId" => $this->tweetId->getBytes(),"tweetProfileId" => $this->tweetProfileId->getBytes(), "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
	$statement->execute($parameters);
}

/**
 * gets the Tweet by tweetId
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $tweetId tweet id to search for
 * @return Tweet|null Tweet found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
public static function getTweetByTweetId(\PDO $pdo, $tweetId) : ?Tweet {
	// sanitize the tweetId before searching
	try {
		$tweetId = self::validateUuid($tweetId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	// create query template
	$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetId = :tweetId";
	$statement = $pdo->prepare($query);

	// bind the tweet id to the place holder in the template
	$parameters = ["tweetId" => $tweetId->getBytes()];
	$statement->execute($parameters);

	// grab the tweet from mySQL
	try {
		$tweet = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($tweet);
}

/**
 * gets the Tweet by profile id
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $tweetProfileId profile id to search by
 * @return \SplFixedArray SplFixedArray of Tweets found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getTweetByTweetProfileId(\PDO $pdo, $tweetProfileId) : \SplFixedArray {

	try {
		$tweetProfileId = self::validateUuid($tweetProfileId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	// create query template
	$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetProfileId = :tweetProfileId";
	$statement = $pdo->prepare($query);
	// bind the tweet profile id to the place holder in the template
	$parameters = ["tweetProfileId" => $tweetProfileId->getBytes()];
	$statement->execute($parameters);
	// build an array of tweets
	$tweets = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
			$tweets[$tweets->key()] = $tweet;
			$tweets->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($tweets);
}

/**
 * gets the Tweet by content
 *
 * @param \PDO $pdo PDO connection object
 * @param string $tweetContent tweet content to search for
 * @return \SplFixedArray SplFixedArray of Tweets found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getTweetByTweetContent(\PDO $pdo, string $tweetContent) : \SplFixedArray {
	// sanitize the description before searching
	$tweetContent = trim($tweetContent);
	$tweetContent = filter_var($tweetContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($tweetContent) === true) {
		throw(new \PDOException("tweet content is invalid"));
	}

	// escape any mySQL wild cards
	$tweetContent = str_replace("_", "\\_", str_replace("%", "\\%", $tweetContent));

	// create query template
	$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetContent LIKE :tweetContent";
	$statement = $pdo->prepare($query);

	// bind the tweet content to the place holder in the template
	$tweetContent = "%$tweetContent%";
	$parameters = ["tweetContent" => $tweetContent];
	$statement->execute($parameters);

	// build an array of tweets
	$tweets = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
			$tweets[$tweets->key()] = $tweet;
			$tweets->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($tweets);
}

/**
 * gets all Tweets
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllTweets(\PDO $pdo) : \SPLFixedArray {
	// create query template
	$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet";
	$statement = $pdo->prepare($query);
	$statement->execute();

	// build an array of tweets
	$tweets = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
			$tweets[$tweets->key()] = $tweet;
			$tweets->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($tweets);
}

/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() : array {
	$fields = get_object_vars($this);

	$fields["tweetId"] = $this->tweetId->toString();
	$fields["tweetProfileId"] = $this->tweetProfileId->toString();

	//format the date so that the front end can consume it
	$fields["tweetDate"] = round(floatval($this->tweetDate->format("U.u")) * 1000);
	return($fields);
}
}