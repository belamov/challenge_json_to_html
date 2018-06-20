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
        foreach ($settings as $key => $value) {
            $this->styles .= $this->settingsToStyles($key, $value);
        }
    }

    protected function settingsToStyles($key, $value)
    {
        $settingsToStylesRules = [
            "textAlign" => "text-align",
            "fontSize" => "font-size",
            "zoom" => "zoom",
            "size" => "font-size",
            "textColor" => "color",
            "backgroundColor" => "background-color",
        ];

        //i've no idea what does "style" setting does, so i just ignore it
        if (!in_array($key, ['style'])) {
            if (key_exists($key, $settingsToStylesRules)) {
                return "{$settingsToStylesRules[$key]}:{$value};";
            } else {
                return "{$key}:{$value};";
            }
        }
    }
}