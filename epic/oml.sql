insert into author(authorId, firstName, lastName) values("98", "Chamisa", "Edmo");

insert into searchFilter(filterId, filterType, filterNumberApplied, filterAddRemove) values("k9",
"soyuz", "5189", "2c1be03c");

insert into article(articleAuthorId, articleId, articleFilterId, articleDatePublished, articleDescription, articleTitle)
values("98", "7acd83n6e461580d", "k9", "2018-10-15",
		 "Details about Soyuz launch failure", "It's a bird, it's a plane, it's a stage 2 engine failure.");

-- UPDATE author set AuthorAvatarUrl = http://sandbox.onlinephpfunctions.com/ WHERE authorId = unhex("2ca2ea34e1ae47a7830b2f87ffbf7e20");

update author set firstName = "Chameezy" where firstname = "Chamisa";

-- DELETE from author where authorId = unhex("2ca2ea34e1ae47a7830b2f87ffbf7e20");

delete from article where articleDescription = "Details about Soyuz launch failure";

-- write and execute an insert statement on a table with a foreign key from the original table

insert into author(authorId, firstName, lastName) values("99", "Briana", "Nezbah");


select authorId from author where authorId = 99;

-- Write and execute a select statement that incorporates both a where clause
-- and an inner-join on both tables used in this assignment.
-- SELECT tableA.valueA, tableA.ValueB tableA.valueC tableB.valueA from tableA
-- inner join on tableB where tableA.valueA = tableB.valueA where foo = bar
--
select article.articleId, article.articleFilterId, article.articleDatePublished, author.authorId from article
	inner join author where article.articleId = author.authorId where foo = bar;


-- Write a select statement based of off DDC-Twitter that counts the number of likes for a specific tweet.
-- answer:
-- select tweet.tweetId, like.likeTweetId from tweet inner join where
-- 	tweet.tweetId = like.likeTweetId were foo = bar;