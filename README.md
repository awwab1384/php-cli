# Example for PHP CLI and Rest API

This project is built based on PHP, with XML Library Spatie.

## Installation

Either you need a machine which has PHP >=7.4 to test or you can test the full project with CLI command.

## Using CLI - Convert CSV to Json or XML

```php
//CLI command to convert CSV file(UTF-8) to json or XML.

//To get response in json
php script.php --f=products.csv --opt=json

//To get response in xml
php script.php --f=products.csv --opt=xml

//To get response in both json and xml
php script.php --f=products.csv --opt=both
```

## Using CLI - Json file filterable by name and pvp and XML response

```php
//Filter by using name
php restApi.php --f_name=Suit

//Filter by using PVP
php restApi.php --f_pvp=0,2000

//Filter with both name and pvp
php restApi.php --f_name=Suit --f_pvp=0,2000

//Multiple filter values
php restApi.php --f_name=Suit,shirt --f_pvp=0,2000
```

## Using PHP server - Json file filterable by name and pvp and XML response
![alt](https://www.go-green.info/s_image.PNG)

## License
[MIT](https://choosealicense.com/licenses/mit/)