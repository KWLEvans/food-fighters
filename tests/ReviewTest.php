<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Review.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Review::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $user_id = 1;
            $restaurant_id = 3;
            $rating = 3;
            $review = "I love these hot beans. I had a sk8r boi, but I said to you l8r boi. His beans werent hot enough for me.";
            $test_review = new Review($user_id, $restaurant_id, $rating, $review);
            $test_review->save();

            //Act
            $result = $test_review->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $user_id = 1;
            $restaurant_id = 3;
            $rating = 3;
            $review = "I love these hot beans. I had a sk8r boi, but I said to you l8r boi. His beans werent hot enough for me.";
            $test_review = new Review($user_id, $restaurant_id, $rating, $review);

            //Act
            $test_review->save();
            $result = Review::getAll();

            //Assert
            $this->assertEquals($test_review, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $user_id = 1;
            $restaurant_id = 3;
            $rating = 3;
            $review = "I love these hot beans. I had a sk8r boi, but I said to you l8r boi. His beans werent hot enough for me.";
            $test_review = new Review($user_id, $restaurant_id, $rating, $review);
            $test_review->save();

            $user_id = 2;
            $restaurant_id = 1;
            $rating = 5;
            $review = "Doo doo doooooooo doodlee do deeeeeeee, doo dee dooooooo, dee doooooooo. Yum. Salds.";
            $test_review2 = new Review($user_id, $restaurant_id, $rating, $review);
            $test_review2->save();

            //Act
            $result = Review::getAll();

            //Assert
            $this->assertEquals([$test_review, $test_review2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $user_id = 1;
            $restaurant_id = 3;
            $rating = 3;
            $review = "I love these hot beans. I had a sk8r boi, but I said to you l8r boi. His beans werent hot enough for me.";
            $test_review = new Review($user_id, $restaurant_id, $rating, $review);
            $test_review->save();

            $user_id = 2;
            $restaurant_id = 1;
            $rating = 5;
            $review = "Doo doo doooooooo doodlee do deeeeeeee, doo dee dooooooo, dee doooooooo. Yum. Salds.";
            $test_review2 = new Review($user_id, $restaurant_id, $rating, $review);
            $test_review2->save();

            //Act
            Review::deleteAll();
            $result = Review::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_update()
        {
            //Arrange
            $user_id = 1;
            $restaurant_id = 3;
            $rating = 4;
            $review = "I love these hot beans. I had a sk8r boi, but I said c u l8r boi. His beans werent hot enough for me.";
            $test_review = new Review($user_id, $restaurant_id, $rating, $review);
            $test_review->save();

            $new_rating = 1;
            $new_review = "Yowch! Too hot.";

            //Act
            $test_review->update($new_rating, $new_review);
            $result = Review::getAll()[0];

            //Assert
            $this->assertEquals(1, $result->getRating());
            $this->assertEquals("Yowch! Too hot.", $result->getReview());
        }
    }

?>
