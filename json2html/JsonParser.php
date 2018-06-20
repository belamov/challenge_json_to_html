<?php

namespace json2html;


use json2html\elements\ElementsFactory;

class JsonParser
{
    public function collectElementsFromDecodedJson($decodedJson)
    {
        if (!is_array($decodedJson)) {
            $decodedJson = [$decodedJson];
        }
        $elements = [];
        foreach ($decodedJson as $item) {
            $element = ElementsFactory::build($item->type, $item->payload, $item->settings);
            if (isset($item->children)) {
                $element->addChildren($this->collectElementsFromDecodedJson($item->children));
            }
            $elements[] = $element;
        }
        return $elements;
    }
}