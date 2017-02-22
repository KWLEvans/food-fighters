
<?php
    class Cuisine
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id= $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($input)
        {
            $this->name = $input;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisines (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE cuisines SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function getRestaurants()
        {
            $restaurants = Restaurant::getAll();
            $matching_restaurants = [];
            foreach ($restaurants as $restaurant) {
                if ($restaurant->getCuisineId() == $this->getId()) {
                    array_push($matching_restaurants, $restaurant);
                }
            }
            return $matching_restaurants;
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = [];
            foreach ($returned_cuisines as $cuisine) {
                $name = $cuisine['name'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($name, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
        }

    }
?>
