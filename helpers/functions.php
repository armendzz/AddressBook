<?php 

function isDigits(string $s, int $minDigits = 6, int $maxDigits = 15): bool {
    return preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s);
}

function checkIsAValidDate($myDateString){
    return (bool)strtotime($myDateString);
}