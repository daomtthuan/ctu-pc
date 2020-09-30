<?php

namespace Models;
class Category{
    private int $id;
    private string $name;
    private bool $state;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }
}