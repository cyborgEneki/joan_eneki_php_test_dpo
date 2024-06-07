<?php

class Person
{
    private $name;
    private $age;

    public function __construct($name, $age)
    {
        $this->setName($name);
        $this->setAge($age);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        if (!is_int($age) || $age < 0) {
            throw new Exception("Age must be a positive number.");
        }
        $this->age = $age;
    }

    public function displayPersonInfo()
    {
        echo "Name: " . $this->getName() . "\n";
        echo "Age: " . $this->getAge() . "\n";
    }
}

$person = new Person("Jay", 49);
$person->displayPersonInfo();
