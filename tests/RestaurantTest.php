<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Restaurant.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown() {
            Restaurant::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Sigur Roast";
            $description = "ég gaf ykkur von sem varð að vonbrigðum.. þetta er ágætis byrjun";
            $price = "high";
            $neighborhood = "Cully";
            $cuisine_id = 2;
            $test_Restaurant = new Restaurant($name, $description, $price, $neighborhood, $cuisine_id);
            $test_Restaurant->save();

            //Act
            $result = $test_Restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save() {
            //Arrange
            $name = "Sigur Roast";
            $description = "ég gaf ykkur von sem varð að vonbrigðum.. þetta er ágætis byrjun";
            $price = "high";
            $neighborhood = "Cully";
            $cuisine_id = 2;
            $test_Restaurant = new Restaurant($name, $description, $price, $neighborhood, $cuisine_id);

            //Act
            $test_Restaurant->save();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_Restaurant, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
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
            $cuisine_id2 = 4;
            $test_Restaurant2 = new Restaurant($name2, $description2, $price2, $neighborhood2, $cuisine_id2);
            $test_Restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_Restaurant, $test_Restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
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
            $cuisine_id2 = 4;
            $test_Restaurant2 = new Restaurant($name2, $description2, $price2, $neighborhood2, $cuisine_id2);
            $test_Restaurant2->save();

            //Act
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_updateName() {
            //Arrange
            $name = "Sigur Roast";
            $description = "ég gaf ykkur von sem varð að vonbrigðum.. þetta er ágætis byrjun";
            $price = "high";
            $neighborhood = "Cully";
            $cuisine_id = 2;
            $new_name = "Cigar Roost";

            $test_Restaurant = new Restaurant($name, $description, $price, $neighborhood, $cuisine_id);

            //Act
            $test_Restaurant->save();
            $test_Restaurant->updateName($new_name);

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($new_name, $result[0]->getName());
        }
    }



?>
