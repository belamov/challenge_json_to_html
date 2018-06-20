<?php
require 'vendor/autoload.php';

use json2html\JsonParser;

$json = file_get_contents('data.json');
$parser = new JsonParser();
$elements = $parser->collectElementsFromJson($json);

foreach ($elements as $element) {
    echo $element->render();
}