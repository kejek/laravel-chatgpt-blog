<?php

namespace App\Services;

use App\Renderer\AnchorHeadingRenderer;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Block\Paragraph;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

class CommonMark
{
    public static function convertToHtml(
        string $markdown,
        $highlightCode = true,
    ): string {
        $config = [
            'default_attributes' => [
                Heading::class => [
                    'class' => static function (Heading $node) {
                        if ($node->getLevel() === 1) {
                            return 'text-2xl font-extrabold mt-5 mb-4';
                        } elseif ($node->getLevel() === 2) {
                            return 'mt-5 mb-4 text-xl font-extrabold';
                        } else {
                            return null;
                        }
                    },
                ],
                Table::class => [
                    'class' => 'table',
                ],
                Paragraph::class => [
                    'class' => ['mt-2', 'mb-2'],
                ],
                Link::class => [
                    'class' => 'btn btn-link',
                    'target' => '_blank',
                ],
            ],
            'smartpunct' => [
                'double_quote_opener' => '“',
                'double_quote_closer' => '”',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],
            'external_link' => [
                'internal_hosts' => config('app.url'),
                'open_in_new_window' => true,
                'html_class' => 'external-link',
                'nofollow' => 'external',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
        ];

        $environment = new Environment($config);
        $environment->addRenderer(Heading::class, new AnchorHeadingRenderer());

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new SmartPunctExtension());
        $environment->addExtension(new DefaultAttributesExtension());
        $environment->addExtension(new HighlightCodeExtension('github-dark'));

        $convertor = new MarkdownConverter($environment);

        return $convertor->convert($markdown)->getContent();
    }
}
