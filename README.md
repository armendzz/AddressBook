# AddressBook
This is a simple addressbook made with PHP, Users can Add/Edit/Delete entries, sorting by Firstname, Lastname, City, Phone, Birthday etc.  

Watch live Demo: https://addressbook.iarmend.de   


# Installation

``` git clone https://github.com/armendzz/AddressBook.git```  
``` cp db/example.conf.php db/config.php```  
edit file ``` db/config.php ```  
  
open in brwoser http://youhost/AddressBook/install

# Test

Generate fake data for registered user:

Install Dependecies:
``` composer install```

Generate fake data:
``` php test/generatefakedata.php```


# TODO

1. add Filter for birthday or added-on range
2. add Pagination   