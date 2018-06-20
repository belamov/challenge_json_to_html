<?php

namespace json2html\elements;

class ElementsFactory
{
    public static function build(string $elementType, $payload, $settings): AbstractElement
    {
        $element = "\json2html\\elements\\" . ucwords($elementType);
        if (class_exists($element)) {
            return new $element($payload, $settings);
        } else {
            throw new \Exception("Can't find class with name {$element}");
        }
    }
}