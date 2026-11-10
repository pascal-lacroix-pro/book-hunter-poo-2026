<?php

/** @var array $books  */
?>
<h2 class="text-2xl font-bold mb-4">Popular books</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($books as $book): ?>
        <article
            class="bg-gray-800 rounded-lg overflow-hidden shadow-lg relative">
            <span
                class="bg-white text-gray-800 px-2 py-1 rounded-md text-sm font-semibold absolute top-2 left-2">
                <?php echo $book['category_id']; ?>
            </span>
            <img
                class="w-full h-48 object-cover"
                src="<?php echo $book['cover']; ?>"
                alt="<?php echo $book['title']; ?>" />
            <div class="p-4">
                <div class="pb-4">
                    <span
                        class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-semibold mr-2">
                        #society
                    </span>
                    <span
                        class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        #bestseller
                    </span>
                </div>
                <h3 class="text-xl font-bold">
                    <?php echo $book['title']; ?>
                </h3>
                <h4 class="text mb-2 text-gray-400">
                    <?php echo $book['author_id']; ?>
                </h4>
                <div class="flex items-center mb-2">
                    <span class="text-yellow-500 mr-1">
                        <i class="fas fa-star"></i>
                    </span>
                    <span>8.9</span>
                </div>

                <p class="text-gray-400">
                    <?php echo $book['resume']; ?>
                </p>

                <a
                    href="book.html"
                    class="inline-block mt-4 bg-red-500 hover:bg-red-800 rounded-full px-4 py-2 text-white">
                    More details
                </a>
            </div>
        </article>
    <?php endforeach; ?>
</div>