<?php

namespace json2html\elements;

class Block extends AbstractElement
{
    public function render()
    {
        $html = "<div style=\"{$this->styles}\">";
        if (!empty($this->children)) {
            foreach ($this->children as $child) {
                $html .= $child->render();
            }
        }
        $html .= "</div>";

        return $html;
    }
}