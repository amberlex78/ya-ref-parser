<?php

use DiDom\Document;

class Yandex
{
    private static $themes = [
        'astronomy',
        'geology',
        'gyroscope',
        'literature',
        'marketing',
        'mathematics',
        'music',
        'polit',
        'agrobiologia',
        'law',
        'psychology',
        'geography',
        'physics',
        'philosophy',
        'chemistry',
        'estetica',
    ];

    /**
     * @param $id
     * @return stdClass
     */
    public static function parsePage($id)
    {
        $fields = new stdClass();

        // Get page
        $themesString = implode('+', self::$themes);
        $document = new Document('https://referats.yandex.ru/referats/?t=' . $themesString . '&s=' . $id, true);

        $referat    = $document->find('.referats__text')[0];  // Get referat text
        $title      = $referat->find('strong')[0]->text();    // Get title
        $paragraphs = $referat->find('p');                    // Get paragraphs

        // Prepare title
        preg_match("|«(.+?)»|is", $title, $out);
        $title = rtrim($out[1], '?');
        if ($pos = strpos($title, '—')) {
            $title = trim(substr($title, 0, $pos));
        } elseif ($pos = strpos($title, ':')) {
            $title = substr($title, 0, $pos);
        }

        // Object with fields for save to DB
        $fields->title   = $title;
        $fields->slug    = Str::slug($title);
        $fields->preview = $paragraphs[0]->html();
        $fields->text    = $paragraphs[1]->html() . $paragraphs[2]->html();

        return $fields;
    }
}