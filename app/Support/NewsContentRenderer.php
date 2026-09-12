<?php

namespace App\Support;

use App\Models\News;
use DOMDocument;
use DOMElement;
use DOMXPath;

class NewsContentRenderer
{
    public static function render(
        string $content,
        ?News $relatedNews = null
    ): string {
        if (trim($content) === '') {
            return '';
        }

        // Tidak ada Baca Juga.
        // Konten langsung dikembalikan apa adanya.
        if (! $relatedNews) {
            return $content;
        }

        libxml_use_internal_errors(true);

        $document = new DOMDocument('1.0', 'UTF-8');

        $html = '<?xml encoding="UTF-8">'
            . '<div id="news-content">'
            . $content
            . '</div>';

        $document->loadHTML(
            $html,
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();

        $xpath = new DOMXPath($document);

        $container = $document->getElementById('news-content');

        if (! $container) {
            return $content;
        }

        /*
         * Cari elemen blok yang bisa menjadi titik penyisipan.
         *
         * Prioritas utama adalah paragraph karena Baca Juga
         * paling natural ditempatkan setelah sebuah paragraf.
         *
         * Heading/list/blockquote tetap dianggap sebagai bagian
         * dari struktur artikel, tetapi tidak kita potong di tengahnya.
         */
        $paragraphs = $xpath->query(
            './p',
            $container
        );

        /*
         * Kalau artikel memiliki minimal 2 paragraph,
         * letakkan Baca Juga setelah paragraph yang berada
         * di sekitar tengah artikel.
         */
        if ($paragraphs && $paragraphs->length >= 2) {

            $middleIndex = (int) floor($paragraphs->length / 2);

            $paragraph = $paragraphs->item($middleIndex);

            if ($paragraph instanceof DOMElement) {
                $callout = self::createBacaJugaCallout(
                    $document,
                    $relatedNews
                );

                $paragraph->parentNode->insertBefore(
                    $callout,
                    $paragraph->nextSibling
                );
            }
        }

        return self::innerHtml($container);
    }

    private static function createBacaJugaCallout(
        DOMDocument $document,
        News $relatedNews
    ): DOMElement {
        $callout = $document->createElement('aside');

        $callout->setAttribute(
            'class',
            'my-10 rounded-2xl border border-neutral-200 bg-neutral-50 px-6 py-5'
        );

        /*
         * Label
         */
        $label = $document->createElement('p');

        $label->setAttribute(
            'class',
            'mb-2 text-xs font-semibold uppercase tracking-[0.15em] text-neutral-400'
        );

        $label->appendChild(
            $document->createTextNode('Baca juga')
        );

        $callout->appendChild($label);

        /*
         * Link
         */
        $link = $document->createElement('a');

        $link->setAttribute(
            'href',
            route('news.show', $relatedNews->slug)
        );

        $link->setAttribute(
            'class',
            'group inline-flex items-start gap-3 font-semibold leading-snug text-neutral-900 transition hover:text-wfsc-coral'
        );

        /*
         * Arrow
         */
        $arrow = $document->createElement('span');

        $arrow->setAttribute(
            'class',
            'mt-0.5 shrink-0 text-neutral-400 transition group-hover:translate-x-1 group-hover:text-wfsc-coral'
        );

        $arrow->appendChild(
            $document->createTextNode('→')
        );

        $link->appendChild($arrow);

        /*
         * Article title
         */
        $title = $document->createElement('span');

        $title->appendChild(
            $document->createTextNode($relatedNews->title)
        );

        $link->appendChild($title);

        $callout->appendChild($link);

        return $callout;
    }

    private static function innerHtml(DOMElement $element): string
    {
        $html = '';

        foreach ($element->childNodes as $child) {
            $html .= $element->ownerDocument->saveHTML($child);
        }

        return $html;
    }
}
