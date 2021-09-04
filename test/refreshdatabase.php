<?php
require('./vendor/autoload.php');
require('classes/Contacts.php');
require_once('./db/pdo.php');


$db = new Database();
$db->rawQuery("DELETE FROM `contacts` WHERE `userid`=5");

$faker = Faker\Factory::create();
$contact = new Contacts();


$userid = '5';
$count = '60';
 for($i = 1; $i <= $count; $i++){
$contact->addContact($faker->firstName, $faker->lastName, $faker->numberBetween($min = 491760000000, $max = 956248531858), $faker->city, $faker->date($format = 'Y-m-d', $max = 'now'), $faker->freeEmail, $faker->text(), $userid);
} 


?>