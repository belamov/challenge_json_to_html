<?php
require 'vendor/autoload.php';

use json2html\JsonParser;

$json = file_get_contents('data.json');
$parser = new JsonParser();
try {
    $elements = $parser->collectElementsFromDecodedJson(json_decode($json));

    foreach ($elements as $element) {
        echo $element->render();
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}