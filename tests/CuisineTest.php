<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Cuisine.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Cuisine::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Icelandic";
            $test_cuisine = new Cuisine($name);

            //Act
            $test_cuisine->save();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getId()
        {
            //Arrange
            $name = "Icelandic";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }
    }

?>
