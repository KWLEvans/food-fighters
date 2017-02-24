<?php
    class Review
    {
        private $user_id;
        private $restaurant_id;
        private $rating;
        private $review;
        private $id;
        private $user_name;

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

        function getUserName() {
            return $this->user_name;
        }

        function save()
        {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO reviews (user_id, restaurant_id, rating, review) VALUES (:user_id, :restaurant_id, :rating, :review);");
            $exec->execute([':user_id' => $this->getUserId(), ':restaurant_id' => $this->getRestaurantId(), ':rating' => $this->getRating(), ':review' => $this->getReview()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_rating, $new_review)
        {
            $exec = $GLOBALS['DB']->prepare("UPDATE reviews SET rating = :rating WHERE id = :id;");
            $exec->execute([':rating' => $new_rating, ':id' => $this->getId()]);

            $exec = $GLOBALS['DB']->prepare("UPDATE reviews SET review = :review WHERE id = :id;");
            $exec->execute([':review' => $new_review, ':id' => $this->getId()]);
        }

        function export()
        {
            $found_user;
            $users = User::getAll();
            foreach ($users as $user) {
                if ($user->getId() == $this->getUserId()) {
                    $found_user = $user;
                }
            }
            $this->user_name = $found_user->getName();
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
