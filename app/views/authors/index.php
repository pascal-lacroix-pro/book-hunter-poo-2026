<?php

/** @var array $authors  */ ?>

<h2 class="text-2xl font-bold mb-4">Authors</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

    <?php foreach ($authors as $author): ?>
        <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <img
                class="w-full h-48 object-cover"
                src="<?php echo $author->picture; ?>"
                alt="<?php echo $author->firstname; ?> <?php echo $author->lastname; ?>" />
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2">
                    <?php echo $author->firstname; ?>
                    <?php echo $author->lastname; ?>
                </h3>
                <div class="flex items-center mb-2">
                    <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
                    <span>8.9</span>
                </div>
                <p class="text-gray-400">
                    <?php echo \Core\Helpers::truncate($author->biography, 50); ?>
                </p>
                <a
                    href="authors/<?php echo $author->id ?>/<?php echo \Core\Helpers::slugify($author->firstname . ' ' . $author->lastname) ?>"
                    class="inline-block mt-4 bg-red-500 hover:bg-red-800 rounded-full px-4 py-2 text-white">
                    More details
                </a>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<div class="text-center mt-8">
    <button
        class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-full">
        Load More
    </button>
</div>