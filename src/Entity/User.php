<?php

namespace App\Entity;

class User
{
   public  string  $username;
   public string $age;

    public function getAge(): string
    {
        return $this->age;
    }

    public function setAge(string $age): void
    {
        $this->age = $age;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;

    }


}