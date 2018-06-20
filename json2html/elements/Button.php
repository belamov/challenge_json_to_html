<?php

namespace json2html\elements;


class Button extends AbstractElement
{
    private $text;
    private $link;

    public function __construct($payload, $settings)
    {
        parent::__construct($payload, $settings);
        $this->link = $payload->link->payload;
        $this->text = $payload->text;
    }

    public function render()
    {
        return "<a class=\"widget-button\" style=\"{$this->styles}\" href=\"{$this->link}\">{$this->text}</a>";
    }
}