<!-- Aside -->
<aside class="w-full md:w-1/4 p-3">
    <div class="bg-gray-700 rounded-lg shadow-lg p-4">
        <?php
        $categories = \App\Models\CategoriesManager::findAll();
        include '../app/views/categories/_index.php';
        ?>
    </div>
    <div class="bg-gray-700 rounded-lg shadow-lg p-4 mt-4">
        <?php
        $tags = \App\Models\TagsManager::findAll();
        include '../app/views/tags/_index.php';
        ?>
    </div>
</aside>