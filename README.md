# AddressBook
This is a simple addressbook made with PHP, Users can Add/Edit/Delete entries, sorting by Firstname, Lastname, City, Phone, Birthday etc.  

Watch live Demo: https://addressbook.iarmend.de   
   
Username: ```demo```   
Password: ```123456```   


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
3. user can choose how much contacts to see on page  
4. add avatar
5. create singe page for every contacts and add a optional NOTES text