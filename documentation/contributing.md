# OC - p8

## Contributing

Here is the process to contribute to ToDo & Co in the right way. 

### Recommendations

__To make a pull request :__

* __Follow PSR__
* __Write and run tests to reach at least 70% code coverage__

### Process

1. Please follow [README](../readme.md) and then come back right here
2. Create an issue
3. Create a new branch on which you will work on following the rules
4. Commit this branch
5. Write and run tests :

_Here is the process to install and use PHP/Unit :_
* run `composer require --dev phpunit/phpunit ^9.6`
* install __XDebug__ following this https://xdebug.org/docs/install (take care of installing zend_extension and coverage too)
* create your test database by typing `symfony console doctrine:database:create --env=test`
* add tables by typing `symfony console doctrine:migrations:migrate --env=test`
* add fixtures by typing `symfony console doctrine:fixtures:load --env=test`
* to reset your database updates after each test install dama bundle by typing `composer require dama/doctrine-test-bundle`
* to run test you can type in `vendor/bin/phpunit` or `vendor/bin/phpunit --coverage-html public/test-coverage` to get the coverage
* if you reach at least 70% code coverage, you're all good

6. Push the branch on your side
7. Create a pull request on __this__ GitHub project
