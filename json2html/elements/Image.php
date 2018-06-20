<?php

namespace json2html\elements;


class Image extends AbstractElement
{
    private $link;
    private $image;

    public function __construct($payload, $settings)
    {
        parent::__construct($payload, $settings);
        $this->link = $payload->link;
        $this->image = $payload->image->image;
    }

    public function render()
    {

        $imgTag = "<img style=\"{$this->styles}\" src=\"{$this->image}\">";

        if (!is_null($this->link)) {
            return "<a href=\"{$this->link}\">{$imgTag}</a>";
        } else {
            return $imgTag;
        }
    }
}