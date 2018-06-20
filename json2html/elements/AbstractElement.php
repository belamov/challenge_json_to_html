<?php

namespace json2html\elements;


abstract class AbstractElement
{
    protected $children = [];
    protected $styles = "";

    public abstract function render();

    public function addChildren(array $children)
    {
        $this->children = array_merge($this->children, $children);
    }

    public function __construct($payload, $settings)
    {
        $settingsToStyles = [
            "textAlign" => "text-align",
            "fontSize" => "font-size",
            "zoom" => "zoom",
            "size" => "font-size",
            "textColor" => "color",
            "backgroundColor" => "background-color",
        ];
        foreach ($settings as $key => $value) {
            if (!in_array($key, ['style'])) {
                if (key_exists($key, $settingsToStyles)) {
                    $this->styles .= "{$settingsToStyles[$key]}:{$value};";
                } else {
                    $this->styles .= "{$key}:{$value};";
                }
            }
        }
    }
}