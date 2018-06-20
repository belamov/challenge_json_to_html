<?php
require 'vendor/autoload.php';

use json2html\elements\ElementsFactory;

function getElements($array)
{
    $elements = [];
    foreach ($array as $item) {
        $element = ElementsFactory::build($item->type, $item->payload, $item->settings);
        if (isset($item->children)) {
            $element->addChildren(getElements($item->children));
        }
        $elements[] = $element;
    }
    return $elements;
}

$json = file_get_contents('data.json');

$obj = json_decode($json);

$elements = getElements([$obj]);

foreach ($elements as $element) {
    echo $element->render();
}