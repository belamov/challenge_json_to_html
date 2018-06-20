<?php

namespace json2html\elements;


class Text extends AbstractElement
{
    private $text;

    public function __construct($payload, $settings)
    {
        parent::__construct($payload, $settings);
        $this->text = $payload->text;
    }

    public function render()
    {
        return "<div style=\"{$this->styles}\">{$this->text}</div>";
    }
}