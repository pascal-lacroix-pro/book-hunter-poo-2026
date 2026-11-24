<?php

/** @var array $categories */ ?>
<h2 class="font-bold text-lg mb-4">Categories</h2>
<ul class="list-reset">
    <?php foreach ($categories as $category): ?>
        <li>
            <a class="text-gray-300 hover:text-white" href="#">
                <?php echo $category->name; ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>