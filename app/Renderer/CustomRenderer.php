<?php

namespace App\Renderer;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class CustomRenderer extends MarkdownRenderer
{
    public function configureCommonMarkEnvironment(EnvironmentBuilderInterface $environment): void
    {
        parent::configureCommonMarkEnvironment($environment);

        $environment->addExtension(new AttributesExtension());
    }
}
