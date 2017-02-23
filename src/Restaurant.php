<?php
    class Restaurant
    {
        private $name;
        private $description;
        private $price;
        private $neighborhood;
        private $cuisine_id;
        private $id;


        function __construct($name, $description, $price, $neighborhood, $cuisine_id, $id = null)
        {
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->neighborhood = $neighborhood;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($input)
        {
            $this->name = $input;
        }

        function getDescription()
        {
            return $this->description;
        }

        function setDescription($input)
        {
            $this->description = $input;
        }

        function getPrice()
        {
            return $this->price;
        }

        function setPrice($input)
        {
            $this->price = $input;
        }

        function getNeighborhood()
        {
            return $this->neighborhood;
        }

        function setNeighborhood($input)
        {
            $this->neighborhood = $input;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function setCuisineId($input)
        {
            $this->cuisine_id = $input;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $exec = $GLOBALS['DB']->prepare("INSERT INTO restaurants (name, description, price, neighborhood, cuisine_id) VALUES (:name, :description, :price, :neighborhood, :cuisine_id)");
            $exec->execute([':name' => $this->getName(), ':description' => $this->getDescription(), ':price'=> $this->getPrice(), ':neighborhood' => $this->getNeighborhood(), ':cuisine_id' => $this->getCuisineId()]);
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateName($new_name)
        {
            $exec = $GLOBALS['DB']->prepare("UPDATE restaurants SET name = :name WHERE id = :id;");
            $exec->execute([':name' => $new_name, ':id' => $this->getId()]);
            $this->setName($new_name);
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = [];
            foreach ($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $description = $restaurant['description'];
                $price = $restaurant['price'];
                $neighborhood = $restaurant['neighborhood'];
                $cuisine_id = $restaurant['cuisine_id'];
                $id = $restaurant['id'];
                $new_Restaurant = new Restaurant($name, $description, $price, $neighborhood, $cuisine_id, $id);
                array_push($restaurants, $new_Restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

    }


?>
