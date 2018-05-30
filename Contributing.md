# Contributing

This file describes how to contribute to ToDoList App. When contributing to this repository, you can first discuss the change you wish to make via issue.

Please note we have a code of conduct, please follow it in all your interactions with the project.

## Clone the project

First, you have to clone the project in your local machine.

Then, run `composer update` command to install dependencies.  
And run `php bin/console doctrine:database:create && php bin/console doctrine:schema:update --force` to install database.

Before starting your changes, create a new branch.

## Do your changes

You can now do your changes to the code or add a new feature.  
After coding, please make PHPUnit tests to test your code, and run all the tests with `vendor/bin/phpunit` command to be sure your changes work and do not create failing with our tests.  

If it is ok, you can submit a pull request, and wait for it to be accepted by the staff.

## Code of conducts

Using welcoming and inclusive language  
Being respectful of differing viewpoints and experiences  
Gracefully accepting constructive criticism  
Focusing on what is best for the community  

We respect some PSR rules, please respect PSR-1, PSR-2 and PSR-4. You can use `vendor/bin/phpcs` to check it.  
This application is developped with Symfony framework, please check the [Best Practises](https://symfony.com/doc/3.1/best_practices/index.html)

Thanks ♥
