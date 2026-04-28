<?php

namespace App\Services;

class Slugger
{
    public static function generate(string $text): string
    {
        $text = trim($text);
        $text = strtolower($text);

        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');

        return $text ?: 'livre';
    }
}