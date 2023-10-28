<?php

namespace App\Renderer;

use Illuminate\Support\Str;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

class AnchorHeadingRenderer implements NodeRendererInterface
{
    public function render(
        Node $node,
        ChildNodeRendererInterface $childRenderer,
    ): HtmlElement {
        $element = $this->createElement($node, $childRenderer);
        $id = Str::slug($element->getContents());
        $element->setAttribute('id', $id);

        return $element;
    }

    protected function createElement(
        Node $node,
        ChildNodeRendererInterface $childRenderer,
    ): HtmlElement {
        $tagName = 'h'.$node->getLevel();
        $attrs = $node->data->get('attributes', []);

        return new HtmlElement(
            $tagName,
            $attrs,
            $childRenderer->renderNodes($node->children()),
        );
    }
}
