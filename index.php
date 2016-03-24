<?php

include 'vendor/autoload.php';

include 'libs/DB.php';
include 'libs/Str.php';
include 'Yandex.php';

$db = new DB('root', 'root', 'yandex');

// Reset autoincrement to 1
// (for first run in empty DB)
//$row = $db->query('ALTER TABLE referats AUTO_INCREMENT = 1')->execute();

$start = (int) $db->query('SELECT MAX(id) AS max FROM referats')->one()['max'];
$end   = $start + 100;

for ($i = $start; $i < $end; $i++) {

    $s = $i + 1;
    $fields = Yandex::parsePage($s);

    echo '#ID ' . $s . ': ' . $fields->title . '<br>';

    $db->query('INSERT INTO `referats` (`title`, `slug`, `preview`, `text`) VALUES (?, ?, ?, ?)')
        ->bind(1, $fields->title)
        ->bind(2, $fields->slug)
        ->bind(3, $fields->preview)
        ->bind(4, $fields->text)
        ->execute();
}
