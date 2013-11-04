<?php

$install = array();

$path = $_SERVER['PHP_SELF'];
$remove = 'index.php';
$appPath = str_replace($remove, '', $path);

$install["tableSql"]["settings"] = "CREATE TABLE IF NOT EXISTS `settings` (
									  `_index` varchar(50) NOT NULL,
									  `_value` varchar(50) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$install["tableSql"]["category"] = "CREATE TABLE IF NOT EXISTS `category` (
									  `catID` int(11) NOT NULL AUTO_INCREMENT,
									  `catName` varchar(25) NOT NULL,
									  PRIMARY KEY (`catID`)
									) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$install["tableSql"]["comments"] = "CREATE TABLE IF NOT EXISTS `comments` (
									  `commentID` int(11) NOT NULL AUTO_INCREMENT,
									  `author` varchar(25) NOT NULL,
									  `email` varchar(40) NOT NULL,
									  `website` varchar(40) NOT NULL,
									  `comment` text NOT NULL,
									  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
									  `postID` int(11) NOT NULL,
									  PRIMARY KEY (`commentID`),
									  KEY `postID` (`postID`)
									) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$install["tableSql"]["post"] = "CREATE TABLE IF NOT EXISTS `post` (
								  `postID` int(11) NOT NULL AUTO_INCREMENT,
								  `title` varchar(40) NOT NULL,
								  `content` text NOT NULL,
								  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
								  `author` varchar(25) NOT NULL,
								  PRIMARY KEY (`postID`)
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$install["tableSql"]["postcat"] = "CREATE TABLE IF NOT EXISTS `postcategory` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `postID` int(11) NOT NULL,
									  `catID` int(11) NOT NULL,
									  PRIMARY KEY (`id`)
									) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$install["tableSql"]["user"] = "CREATE TABLE IF NOT EXISTS `user` (
								  `userID` int(11) NOT NULL AUTO_INCREMENT,
								  `username` varchar(25) NOT NULL,
								  `password` varchar(1000) NOT NULL,
								  `cookieexptime` int(11) NOT NULL,
								  `email` varchar(100) NOT NULL,
								  PRIMARY KEY (`userID`)
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";


$install["insertSql"]["settings"] = "INSERT INTO settings
						            (_index, _value)
						            VALUES(?, ?)";

$install["insertSql"]["post"] = "INSERT INTO post
						          (author, title, content)
						          VALUES(?, ?, ?)";

$install["insertSql"]["category"] = "INSERT INTO category
						          (catName)
						          VALUES(?)";







$install["defaultData"]["title"]["index"] = "blogTitle";
$install["defaultData"]["title"]["value"] = "Your Awesome Blog";
$install["defaultData"]["footer"]["index"] = "blogFooter";
$install["defaultData"]["footer"]["value"] = "Copyright Your Awesome Blog";

$install["defaultData"]["appPath"]["index"] = "appPath";
$install["defaultData"]["appPath"]["value"] = $appPath;


$install["sampleData"]["post"]["author"] = "Awesome Blog";
$install["sampleData"]["post"]["title"] = "First Post";
$install["sampleData"]["post"]["content"] = "Hi!, I am your first blog post!! Feel free too delete me :(";

$install["defaultData"]["categories"] = "uncategorised";


return $install;