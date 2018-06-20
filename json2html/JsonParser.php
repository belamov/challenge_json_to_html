<?php

namespace json2html;


use json2html\elements\ElementsFactory;

class JsonParser
{
    public function collectElementsFromJson($json)
    {
        //this is needed for recursion
        if (is_string($json)) {
            $array = [json_decode($json)];
        } else {
            $array = $json;
        }

        $elements = [];
        foreach ($array as $item) {
            try {
                $element = ElementsFactory::build($item->type, $item->payload, $item->settings);
                if (isset($item->children)) {
                    $element->addChildren($this->collectElementsFromJson($item->children));
                }
                $elements[] = $element;
            } catch (\Exception $exception) {
                echo "Whoops! " . $exception->getMessage();
            }
        }
        return $elements;
    }
}