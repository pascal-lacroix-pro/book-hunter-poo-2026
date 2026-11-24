<?php

/** @var \App\Models\Author $author */ ?>
<ul class="list-disc list-inside text-gray-300">
    <?php foreach ($author->books as $book): ?>
        <li>
            <a
                href="books/<?php echo $book->id; ?>/<?php echo \Core\Helpers::slugify($book->title); ?>"
                class="hover:text-red-500 underline font-medium">
                <?php echo $book->title; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>