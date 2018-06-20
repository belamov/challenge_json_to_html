<?php

use json2html\elements\Block;
use json2html\elements\Button;
use json2html\elements\Container;
use json2html\elements\Image;
use json2html\elements\Text;
use json2html\JsonParser;

class JsonParserTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_parses_correct_widget_type()
    {
        $json = '
        [
            {
                "type": "container",
                "payload": {},
                "settings": {}
            },
            {
                "type": "image",
                "payload": {
                    "link": null,
                    "image": {
                        "id": 1,
                        "meta": {
                            "format": "JPG",
                            "width": 1200,
                            "height": 400,
                            "filesize": 9130
                        },
                        "image": "https://pbs.twimg.com/profile_images/645219915402715137/AGToACh7_400x400.jpg"
                    }
                },
                "settings": {
                    "zoom": false
                }
            },
            {
                "type": "text",
                "payload": {
                    "text": "Sample Text"
                },
                "settings": {
                    "fontSize": "medium",
                    "textAlign": "center"
                }
            },
            {
                "type": "block",
                "payload": {},
                "settings": {
                    "textAlign": "center"
                }
            },
            {
                "type": "button",
                "payload": {
                    "link": {
                        "type": "url",
                        "payload": "https://google.com/"
                    },
                    "text": "Sample Button"
                },
                "settings": {
                    "size": "medium",
                    "style": "custom",
                    "textColor": "#FFFFFF",
                    "backgroundColor": "#FF0000"
                }
            }
        ]';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));

        $this->assertCount(5, $elements);
        $this->assertInstanceOf(Container::class, $elements[0]);
        $this->assertInstanceOf(Image::class, $elements[1]);
        $this->assertInstanceOf(Text::class, $elements[2]);
        $this->assertInstanceOf(Block::class, $elements[3]);
        $this->assertInstanceOf(Button::class, $elements[4]);
    }

    /** @test */
    public function it_renders_button()
    {
        $json = '
        {
            "type": "button",
            "payload": {
                "link": {
                    "type": "url",
                    "payload": "https://google.com/"
                },
                "text": "Sample Button"
            },
            "settings": {
                "size": "medium",
                "style": "custom",
                "textColor": "#FFFFFF",
                "backgroundColor": "#FF0000"
            }
        }';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));


        $this->assertSame(
            '<a class="widget-button" style="font-size:medium;color:#FFFFFF;background-color:#FF0000;" href="https://google.com/">Sample Button</a>',
            $elements[0]->render()
        );
    }

    /** @test */
    public function it_renders_text()
    {
        $json = '
        {
            "type": "text",
            "payload": {
                "text": "Sample Text"
            },
            "settings": {
                "fontSize": "medium",
                "textAlign": "center"
            }
        }';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));
        $this->assertSame(
            '<div style="font-size:medium;text-align:center;">Sample Text</div>',
            $elements[0]->render()
        );
    }

    /** @test */
    public function it_renders_empty_block()
    {
        $json = '
        {
            "type": "block",
            "payload": {},
            "settings": {
                "textAlign": "center"
            }
        }';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));
        $this->assertSame(
            '<div style="text-align:center;"></div>',
            $elements[0]->render()
        );
    }

    /** @test */
    public function it_renders_empty_container()
    {
        $json = '
        {
            "type": "container",
            "payload": {},
            "settings": {
                "textAlign": "center"
            }
        }';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));
        $this->assertSame(
            '<div style="text-align:center;"></div>',
            $elements[0]->render()
        );
    }

    /** @test */
    public function it_renders_block_and_container_with_children()
    {
        $json = '
        {
            "type": "block",
            "payload": {},
            "children": [
                {
                    "type": "container",
                    "payload": {},
                    "children": [
                        {
                            "type": "button",
                            "payload": {
                                "link": {
                                    "type": "url",
                                    "payload": "https://google.com/"
                                },
                                "text": "Sample Button"
                            },
                            "settings": {
                                "size": "medium",
                                "style": "custom",
                                "textColor": "#FFFFFF",
                                "backgroundColor": "#FF0000"
                            }
                        }
                    ],
                    "settings": {}
                }
            ],
            "settings": {
                "textAlign": "center"
            }
        }';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));
        $this->assertSame(
            '<div style="text-align:center;"><div style=""><a class="widget-button" style="font-size:medium;color:#FFFFFF;background-color:#FF0000;" href="https://google.com/">Sample Button</a></div></div>',
            $elements[0]->render()
        );
    }

    /** @test */
    public function if_json_contains_widget_with_unregistered_type_it_throws_exception()
    {
        $this->expectException("Exception");
        $json = '
        {
            "type": "unknown",
            "payload": {},
            "settings": {
                "textAlign": "center"
            }
        }';

        $parser = new JsonParser();
        $elements = $parser->collectElementsFromDecodedJson(json_decode($json));
    }
}
