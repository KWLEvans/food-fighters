<?php
    class Review
    {
        private $user_id;
        private $restaurant_id;
        private $rating;
        private $review;
        private $id;

        function __construct($user_id, $restaurant_id, $rating, $review, $id = null)
        {
            $this->user_id = $user_id;
            $this->restaurant_id = $restaurant_id;
            $this->rating = $rating;
            $this->review = $review;
            $this->id = $id;
        }

        function getUserId()
        {
            return $this->user_id;
        }

        function getRestaurantId()
        {
            return $this->restaurant_id;
        }

        function getRating()
        {
            return $this->rating;
        }

        function setRating($new_rating)
        {
            $this->rating = $new_rating;
        }

        function getReview()
        {
            return $this->review;
        }

        function setReview($new_review)
        {
            $this->review = $new_review;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO reviews (user_id, restaurant_id, rating, review) VALUES ({$this->getUserId()}, {$this->getRestaurantId()}, {$this->getRating()}, '{$this->getReview()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_rating, $new_review)
        {
            $GLOBALS['DB']->exec("
            UPDATE reviews SET rating = {$new_rating} WHERE id = {$this->getId()};
            UPDATE reviews SET review = '{$new_review}' WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $reviews = [];
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
            foreach($returned_reviews as $review) {
                $user_id = $review['user_id'];
                $restaurant_id = $review['restaurant_id'];
                $rating = $review['rating'];
                $review_text = $review['review'];
                $id = $review['id'];

                $new_review = new Review($user_id, $restaurant_id, $rating, $review_text, $id);
                array_push($reviews, $new_review);
             }
             return $reviews;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM reviews");
        }

    }

?>
