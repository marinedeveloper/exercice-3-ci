<?php

namespace App;

class User {
    private string $username;
    private string|null $createdAt = '2021-04-26 12:14:20';
    private int $id;

    // $name le nom de la pp et $value c'est la valeur
    public function __set($name, string $value): void
    {
        $this->$name = $value; // $this->username = "Alan" ; $name $value
    }

    public function __get(string $name):string
    {
        return $this->$name;
    }

}
