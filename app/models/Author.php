<?php

namespace App\Models;

class Author
{

    // Champs natifs
    private $id, $firstname, $lastname, $biography, $picture, $created_at;

    // Champs issus des liaisons
    private $books;

    // GETTER MAGIIIIQUE: getter qui se lance quand on tente d'accéder à 
    // - une propriété qui n'existe pas
    // - une propriété private
    public function __get(string $property): mixed
    {
        $setterName = 'set' . ucfirst($property);
        if (method_exists($this, $setterName)) $this->$setterName();
        return $this->$property;
    }

    private function setBooks()
    {
        $this->books = BooksManager::findAllByAuthorId($this->id);
    }
}
