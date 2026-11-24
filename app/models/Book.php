<?php

namespace App\Models;

class Book
{

    // Champs natifs
    private $id, $title, $publicated_at, $resume, $cover, $isbn, $author_id, $category_id, $created_at, $notation;

    // Champs issus de liaisons
    private $author, $category, $tags;

    // GETTER MAGIIIIQUE: getter qui se lance quand on tente d'accéder à 
    // - une propriété qui n'existe pas
    // - une propriété private
    public function __get(string $property): mixed
    {
        $setterName = 'set' . ucfirst($property);
        if (method_exists($this, $setterName)) $this->$setterName();
        return $this->$property;
    }

    private function setAuthor(): void
    {
        $this->author = AuthorsManager::findOneById($this->author_id);
    }

    private function setCategory(): void
    {
        $this->category = CategoriesManager::findOneById($this->category_id);
    }
    private function setTags(): void
    {
        $this->tags = TagsManager::findAllByBookId($this->id);
    }
}
