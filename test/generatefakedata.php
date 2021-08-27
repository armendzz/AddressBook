<?php
require('./vendor/autoload.php');
require('classes/Contacts.php');


$faker = Faker\Factory::create();
$contact = new Contacts();
echo "Give userID to assing contacts (number) ";
$userid = fgets(STDIN);

echo "How much contacts you want to add? (number) ";
$count = fgets(STDIN);
 for($i = 1; $i <= $count; $i++){
$contact->addContact($faker->firstName, $faker->lastName, $faker->numberBetween($min = 491760000000, $max = 956248531858), $faker->city, $faker->date($format = 'Y-m-d', $max = 'now'), $faker->freeEmail, $userid);
} 

echo "$count contacts added successfully";

?>