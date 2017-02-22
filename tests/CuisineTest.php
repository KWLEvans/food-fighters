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

        function test_getName()
        {
            //Arrange
            $name = "Canadian";
            $test_cuisine = new Cuisine($name);

            //Act
            $result = $test_cuisine->getName();

            //Assert
            $this->assertEquals($name, $result);

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

        function test_getAll()
        {
            //Arrange
            $name = "Icelandic";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $name2 = "Canadian";
            $test_cuisine2 = new Cuisine($name);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Icelandic";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $name2 = "Canadian";
            $test_cuisine2 = new Cuisine($name);
            $test_cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Canadian";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            //Act
            $new_name = "New British";
            $test_cuisine->updateName($new_name);
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($new_name, $result[0]->getName());
        }

        function test_getRestaurants()
        {
            //Arrange
            $name = "Canadian";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name = "Sigur Roast";
            $description = "ég gaf ykkur von sem varð að vonbrigðum.. þetta er ágætis byrjun";
            $price = "high";
            $neighborhood = "Cully";
            $cuisine_id = 2;
            $test_Restaurant = new Restaurant($name, $description, $price, $neighborhood, $cuisine_id);
            $test_Restaurant->save();

            $name2 = "Avril leBean";
            $description2 = "Why go and make things so complicated? Its just beans.";
            $price2 = "low";
            $neighborhood2 = "Sullivans Gulch";
            $cuisine_id2 = $test_cuisine->getId();
            $test_Restaurant2 = new Restaurant($name2, $description2, $price2, $neighborhood2, $cuisine_id2);
            $test_Restaurant2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_Restaurant2], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Icelandic";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $name2 = "Canadian";
            $test_cuisine2 = new Cuisine($name);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::find($test_cuisine->getId());

            //Assert
            $this->assertEquals($test_cuisine, $result);
        }
    }
?>
