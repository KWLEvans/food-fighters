<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/User.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            User::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "toobutts";
            $password = "toothbutts";
            $test_user = new User($name, $password);

            //Act
            $test_user->save();
            $result = User::getAll();

            //Assert
            $this->assertEquals($test_user, $result[0]);
        }
    }

?>
