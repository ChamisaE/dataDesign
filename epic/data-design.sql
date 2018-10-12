alter database cedmo character set utf8 collate utf8_unicode_ci;

-- dropping tables to run again with fresh inputs, eliminates run errors
drop table if exists `article`;
drop table if exists `searchFilter`;
drop table if exists `author`;

-- creating tables
create table author (
	authorId BINARY(16) not null, -- this will create a 32 digit id
	firstName VARCHAR(16) not null, -- variable characters for names, 32 character limit
	lastName VARCHAR(16) not null, -- variable characters for names, 32 character limit
	-- the following makes sure duplicate data cannot exist
	unique(authorId),
	-- this determines what the primary key will be for this entity
	primary key(authorId)
);

create table searchFilter (
	filterId BINARY(8) not null, -- PK, this will create a 16 digit filter id
	filterType VARCHAR(16) not null, -- variable character because filter name lengths vary (3-12 characters)
	filterNumberApplied INT(8) not null, -- integer of up to 16 characters
	filterAddRemove BINARY(8) not null, -- may need to change this, not sure what to use when T/F/0
	-- the following makes sure duplicate data cannot exist
	unique(filterNumberApplied),
	-- this determines what the primary key will be for this entity
	primary key(filterId)
);

create table article (
	articleAuthorId BINARY(16) not null, -- keeping consistent with all other ID lengths/types
	articleId BINARY(16) not null, -- ID is binary, this allows lots of numbers : a nearly infinite # articles can be written
	articleFilterId BINARY(16) not null, -- ID is binary, linking it to filterId in searchFilter table
	articleDatePublished DATETIME(6) not null, -- mm/dd/yyyy format
	articleDescription TEXT(128), -- Text allows this to be any number of characters up to 256
	articleTitle VARCHAR(128) not null, -- allows titles of up to 80 characters
	-- the following makes sure duplicate data cannot exist
	unique(articleAuthorId),
	unique(articleId),
	unique(articleTitle),
	-- the following creates an index before making a foreign key
	index(articleFilterId),
	index(articleAuthorId),
	-- the following creates the actual foreign key relation
	foreign key(articleFilterId) references searchFilter(filterId),
	foreign key(articleAuthorId) references author(authorId),
	-- the following creates the primary key for this entity
	primary key (articleId)
);