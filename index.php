<?php

require "vendor/autoload.php";

use App\Parser;
use MongoDB\Client as Mongo;

$config = yaml_parse(file_get_contents('config.yml'));
$parser = new Parser($config['website']);
$words = new SplFileObject($config['words']);
$wordsCollection = (new Mongo)->test_task->words;

while (!$words->eof()) {
	$word = $words->fgets();
	$result = $parser->parse(trim($word));
	$insertOneResult = $wordsCollection->insertOne($result);

	echo $word;
}

$words = null;