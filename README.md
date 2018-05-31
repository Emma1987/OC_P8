ToDoList
========

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6188c936cc054215a7336e6ac3d88ab5)](https://www.codacy.com/app/Emma1987/OC_P8?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Emma1987/OC_P8&amp;utm_campaign=Badge_Grade)


Test an existing application: ToDo & Co.  

## Getting Started
You can download the project, or clone it with Git by using the green button "Clone or download". You can run it on your local machine for development and testing purposes.

## Prerequisites
PHP 7.0  
MySql 5.6.35  
Apache  

## Installing
For installing the project, you have to clone or download it. For running it on your local machine, you can install MAMP (or WAMP for Windows), and put it in the htdocs (or www) file.

Execute the command `composer update` to update the dependancies.  
Execute `php bin/console doctrine:database:create` and `php bin/console doctrine:schema:update --force` to create database and all the entities.
Now, you can go on http://localhost/ and use the application !

## Built With
Bootstrap 3 - the famous CSS framework  
Symfony 3.1 - PHP framework  

## Add-ons
[PHP Unit](https://github.com/sebastianbergmann/phpunit) to run tests  
[PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer) to respect PSR 1 & 2  

## More
You can check the [Authentication documentation](https://github.com/Emma1987/OC_P8/blob/Docs/Authentication.md)  
You can also [Contribute to this project](https://github.com/Emma1987/OC_P8/blob/Docs/Contributing.md)
