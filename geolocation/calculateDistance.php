<?php

// Радиус земли
define('EARTH_RADIUS', 6372795);

/*
* Расстояние между двумя точками
* $φA, $λA - широта, долгота 1-й точки,
* $φB, $λB - широта, долгота 2-й точки
*/

function calculateTheDistance ($φA, $λA, $φB, $λB) {

// перевожу координаты в радианы
    $lat1 = $φA * M_PI / 180;
    $lat2 = $φB * M_PI / 180;
    $long1 = $λA * M_PI / 180;
    $long2 = $λB * M_PI / 180;

// косинусы и синусы широт и разницы долгот
    $cl1 = cos($lat1);
    $cl2 = cos($lat2);
    $sl1 = sin($lat1);
    $sl2 = sin($lat2);
    $delta = $long2 - $long1;
    $cdelta = cos($delta);
    $sdelta = sin($delta);

// вычисления длины большого круга
    $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
    $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

//
    $ad = atan2($y, $x);
    $dist = $ad * EARTH_RADIUS;

    return $dist;
}

// Переданные с ajax данные
$φA = $_POST['lat1'];
$λA = $_POST['lon1'];
$φB = $_POST['lat2'];
$λB = $_POST['lon2'];

$distance = calculateTheDistance($φA, $λA, $φB, $λB);

// Возвращаю на javascript расстояние между парой
echo json_encode(
    array(
        'distance' => $distance
    )
);

?>