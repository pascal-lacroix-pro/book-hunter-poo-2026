# 🧭 GPS — Du framework procédural au framework POO
## UE Framework côté serveur — Book Hunter

Ce document est votre **GPS** : pour chaque étape, il indique la **destination**, un **itinéraire** et des **indices**. Il ne donne **pas le code** : c'est à vous de le trouver (documentation PHP, notes de cours, IA… toutes les ressources sont permises, à condition de **comprendre** ce que vous écrivez).

> 📌 Chaque étape correspond à un **tag git** (`step-01` à `step-23`) qui fonctionne.
> Bloqué·e ? Comparez avec la solution : `git diff step-05 step-06`
> Envie de repartir d'une étape propre : `git checkout step-06`

---

## 🎒 Avant de partir

1. Cloner le dépôt et se placer sur `step-01`.
2. Importer `documents/db/db_remplie.sql` dans MySQL (base `book_hunter_2025`).
3. Dès l'étape 2 : copier `app/config/params-example.php` en `app/config/params.php` et le compléter avec **vos** paramètres. Ce fichier est ignoré par git : il ne doit **jamais** être commité.
4. Dès l'étape 4 : `composer dump-autoload` (crée le dossier `vendor/`, lui aussi ignoré par git). À refaire chaque fois que `composer.json` change.
5. Servir le dossier `public/` (Apache + `mod_rewrite`). Si le site n'est pas à la racine, c'est normal : le projet gère le sous-dossier.

**Légende** : 🎯 destination · 📍 point de départ · 🧭 itinéraire · 💡 indices · ⚠️ pièges · ✅ vérification

---

## Étape 1 — Le terrain · `step-01`
🎯 La base de données est en place et vous savez la lire.
🧭
- Importer le fichier SQL et observer les tables.
- Repérer les relations : un livre a **un** auteur et **une** catégorie (1-N) ; un livre a **plusieurs** tags (N-M).

💡 Le concepteur de phpMyAdmin dessine le schéma.
✅ `books` contient 6 lignes ; `authors` en contient 5.

## Étape 2 — Structure MVC de base (procédural) · `step-02`
🎯 Une page s'affiche à travers le **front controller** : toutes les URL passent par `public/index.php`.
📍 `step-01`
🧭
- Suivre le chemin d'une requête : `index.php` → `core/init.php` → routeur (vide) → template.
- Repérer les zones dynamiques du template : `$title` et `$content`.
- Observer le template découpé en **partials** (`_head`, `_header`, `_main`, `_aside`).
- Lire le `.htaccess` : que fait-il des fichiers qui existent vraiment (images, css) ?

⚠️ `params.php` n'est pas dans le dépôt : sans lui, rien ne démarre. Avec MAMP, le port MySQL fait partie de l'hôte.
✅ La page s'affiche avec son en-tête et son aside (catégories fictives).

## Étape 3 — La route de la page d'accueil · `step-03`
🎯 L'accueil liste les **3 derniers livres** (titre + résumé), lus dans la base.
📍 `step-02`
🧭
- Le routeur appelle une fonction du contrôleur.
- Le contrôleur demande les données à un modèle, puis charge une vue.
- La vue est « capturée » dans `$content` pour être affichée par le template.

💡 Une limite SQL passée en paramètre doit être liée comme **entier**. Pour capturer l'affichage d'une vue sans l'envoyer tout de suite au navigateur : les fonctions de *output buffering*.
⚠️ `$title` et `$content` doivent être déclarées **globales** dans la fonction.
✅ Trois livres, du plus récent au plus ancien.

## Étape 4 — Le premier autoload · `step-04`
🎯 Le contrôleur devient une **classe** chargée **sans `include_once`**.
📍 `step-03`
🧭
- Créer `composer.json` et y déclarer la correspondance entre un **namespace** et un **dossier** (PSR-4).
- Générer l'autoload et le charger au démarrage.
- Transformer les fonctions du contrôleur en **méthodes statiques publiques** d'une classe `abstract`.
- Adapter le routeur : on n'inclut plus le fichier du contrôleur.

💡 `abstract` : cette classe ne sera jamais instanciée. L'opérateur `::` appelle une méthode statique.
⚠️ **Le nom du fichier doit être identique au nom de la classe, casse comprise.** Ça passe sous macOS, ça casse sur le serveur Linux. Pensez aussi au `dump-autoload` quand `composer.json` change.
✅ La page s'affiche comme avant, sans aucun `include_once` de contrôleur.

## Étape 5 — Les helpers en classe · `step-05`
🎯 `truncate()` s'appelle via une classe : le résumé est coupé à **30 caractères** suivis de « ... ».
📍 `step-04`
🧭
- Ajouter dans `composer.json` le namespace du dossier `core/`.
- Transformer le fichier de fonctions en classe `Helpers` (méthodes statiques).
- Supprimer le `require` de l'ancien fichier : l'autoload s'en charge maintenant.
- Modifier l'appel dans la vue.

⚠️ Même règle de casse : `Helpers.php`.
✅ Les résumés sont tronqués.

## Étape 6 — Un modèle et son repository · `step-06`
🎯 Les livres sont manipulés comme des **objets** : `$book->title` et non plus `$book['title']`.
📍 `step-05`
🧭
- Créer la classe `Book` : une propriété publique par colonne de la table.
- Transformer l'ancien fichier de fonctions en `BooksRepository` (classe `abstract`, méthode statique).
- Demander à PDO de **fabriquer des objets** `Book` à partir des lignes.
- Déclarer le namespace du dossier `models/` dans `composer.json`, régénérer l'autoload.
- Adapter la vue.

💡 Cherchez le mode de récupération de PDO qui prend un **nom de classe**. Les noms de colonnes et de propriétés doivent correspondre.
✅ L'accueil s'affiche comme avant. La balise `<base>` du `<head>` permet maintenant les URL relatives.

## Étape 7 — Les auteurs récents · `step-07`
🎯 L'accueil affiche aussi les **3 derniers auteurs**.
📍 `step-06`
🧭
- Reproduire ce qui a été fait pour `Book` : `Author` et `AuthorsRepository`.
- Charger les deux listes dans le contrôleur, les afficher dans la vue.

💡 **Copier-coller volontaire !** Comparez ensuite `BooksRepository` et `AuthorsRepository` : qu'est-ce qui diffère *vraiment* ? Gardez la réponse, elle servira à l'étape 15.
✅ Livres et auteurs sur la même page.

## Étape 8 — Une seule connexion · `step-08`
🎯 Plus aucun `$conn` à transmettre de fonction en fonction.
📍 `step-07`
🧭
- Créer `Core\DB` : la connexion est créée **une seule fois** puis réutilisée (patron **Singleton**).
- Supprimer l'ancien fichier de connexion et son `require`.
- Retirer le paramètre `$conn` du contrôleur, des repositories et du routeur.
- Les repositories demandent la connexion à `DB`.

💡 Une propriété statique **privée** garde la connexion. Une méthode publique la crée si elle n'existe pas encore, puis la renvoie.
⚠️ Un appel qui transmet encore `$conn` donnera une erreur d'arguments : cherchez-les tous.
✅ Le site fonctionne, sans aucun `$conn` dans le code.

## Étape 9 — La classe `App` · `step-09`
🎯 Le démarrage de l'application est regroupé dans **une** méthode ; `public/index.php` devient minimal.
📍 `step-08`
🧭
- Créer `Core\App` avec une méthode de démarrage : session, chargement des paramètres, constante de l'URL de base.
- Supprimer les anciens fichiers d'initialisation et de constantes.
- `index.php` charge l'autoload, démarre l'application, charge le routeur puis le template.

⚠️ Un fichier inclus **dans une méthode** voit ses variables devenir **locales**. `$title` et `$content` (définies dans `params.php`) doivent rester globales : trouvez comment.
✅ Le titre de l'onglet affiche « Books & Authors » (s'il est vide, la variable a été perdue).

## Étape 10 — Les catégories dans l'aside · `step-10`
🎯 L'aside liste les **catégories de la base**, triées par nom.
📍 `step-09`
🧭
- `Category` et `CategoriesRepository` (pas de limite, tri par nom).
- Un **fragment de vue** `categories/_index` qui boucle sur `$categories`.
- L'aside charge les catégories et inclut ce fragment.

💡 Sans paramètre à lier, une requête directe suffit.
🤔 *Question à se poser* : la vue appelle ici le repository. Est-ce conforme au MVC ? Notez votre avis, on en rediscutera.
✅ Roman, Science-fiction, Policier, Fantastique, Horreur.

## Étape 11 — Des vues en morceaux · `step-11`
🎯 L'accueil est assemblé à partir de **fragments réutilisables**.
📍 `step-10`
🧭
- Découper : une liste (`_index`) et un bloc titre + liste (`_recents`), pour les livres et pour les auteurs.
- La vue d'accueil n'inclut plus que les `_recents`.

💡 Convention : un nom commençant par `_` est un fragment, jamais une page complète. Les variables du fichier appelant restent visibles dans le fichier inclus.
✅ Le rendu est identique à l'étape 10.

## Étape 12 — Le détail d'un livre et le lazy loading · `step-12`
🎯 `books/{id}` affiche un livre avec son **auteur** et sa **catégorie**.
📍 `step-11`
🧭
- Route dans le `.htaccess` et dans le routeur → `BooksController::showAction`.
- `findOneById` dans les repositories.
- Dans `Book` : les liaisons sont des propriétés **privées**. Quand on lit `$book->author`, PHP appelle une méthode « magique » qui charge l'auteur **à la demande** (*lazy loading*).
- La vue écrit simplement `$book->author->firstname`.

💡 Cherchez la méthode magique appelée quand on lit une propriété **inaccessible**. `method_exists` et `ucfirst` aident à fabriquer le nom du « setter » à appeler.
⚠️ La route de la liste (`books`) existe dans le routeur mais pas encore son action : elle viendra à l'étape 16.
✅ `books/1` : « The Shining », Stephen King, Horreur.

## Étape 13 — Le modèle abstrait · `step-13`
🎯 La mécanique du lazy loading n'est **plus dans `Book`** mais dans une classe mère.
📍 `step-12`
🧭
- Créer `Core\Model` (abstraite) avec `id`, `created_at` et la méthode magique.
- `Book` en hérite et ne garde que ses propriétés et ses setters.
- Le test « cette liaison est-elle encore vide ? » se fait **une seule fois**, dans la classe mère.

⚠️ Les liaisons passent de `private` à `protected` : pourquoi la classe mère ne peut-elle pas lire une propriété privée de sa fille ?
✅ `books/1` fonctionne exactement comme avant.

## Étape 14 — Le lazy loading par convention · `step-14`
🎯 **Plus aucun setter** dans `Book`.
📍 `step-13`
🧭
- À partir du nom de la propriété demandée (`author`), déduire : la **clé étrangère** (`author_id`), le **repository** (`AuthorsRepository`) et donc l'appel à faire.
- Supprimer les setters de `Book`.
- Gérer le cas particulier de `category` (le pluriel n'est pas « categorys »).

💡 On peut fabriquer un nom de classe sous forme de chaîne, puis appeler une méthode statique dessus. `$this->$nom` lit la propriété dont le nom est dans `$nom`.
⚠️ La liaison doit rester **déclarée** et **protégée** dans `Book`, sinon la méthode magique n'est jamais appelée.
✅ Les 6 livres affichent leurs auteur et catégorie.

## Étape 15 — Un repository pour tous · `step-15`
🎯 `findAll` et `findOneById` sont écrits **une seule fois**.
📍 `step-14`
🧭
- Créer `Core\Repository` (abstraite) qui contient les deux méthodes.
- Elle **déduit la table et le modèle du nom de la classe fille** : `BooksRepository` → `books` → `Book`.
- `AuthorsRepository` et `BooksRepository` n'ont plus de corps.
- `CategoriesRepository` reste à part : pourquoi ?

💡 `static::class` donne le nom de la classe **appelée** (alors que `self::` désigne la classe où le code est écrit). Les fonctions `basename` et `str_replace` aident à extraire un nom d'un chemin de namespace.
⚠️ Les propriétés statiques sont partagées : la déduction doit être refaite à chaque appel.
✅ Même rendu, beaucoup moins de code. Rappelez-vous la question de l'étape 7.

## Étape 16 — Un contrôleur pour tous · `step-16`
🎯 `BooksController` et `AuthorsController` sont **vides** et toutes les pages livres/auteurs fonctionnent.
📍 `step-15`
🧭
- **Template** : créer `Core\Template` pour définir une zone (`title`, `content`) **depuis la vue** ; la vue ouvre et ferme une section, et son contenu est rangé dans la variable globale du même nom.
- **Controller** : créer `Core\Controller` (abstraite), qui déduit de son propre nom le dossier des vues, le nom de la variable et le repository ; il contient `indexAction` et `showAction`.
- Ajouter les routes et les vues des auteurs, la liste des livres et les liens de l'en-tête.

💡 Pour transmettre aux vues une variable dont le nom est calculé (`$books`, `$book`…), cherchez les variables variables (`${...}`).
⚠️ Les vues doivent utiliser exactement les noms de variables que le contrôleur fabrique.
✅ `books`, `books/1`, `authors`, `authors/4` : tout s'affiche, et chaque page a son propre titre.

---

## 🛣️ Les améliorations

## Étape 17 — Le slug dans l'URL · `step-17`
🎯 Les livres ont des URL lisibles : `books/{id}/{slug}`.
📍 `step-16`
🧭
- Modifier la règle du `.htaccess` pour accepter un segment supplémentaire (minuscules, chiffres, tirets), **sans le capturer**.
- Dans la liste des livres, fabriquer le lien avec `Helpers::slugify`.

💡 Seul l'**id** sert à retrouver le livre ; le slug n'est là que pour la lisibilité.
⚠️ Les anciennes URL `books/1` ne correspondent plus à la règle.
✅ `books/1/the-shining`.

## Étape 18 — `init()` privé · `step-18`
🎯 `Controller::init()` n'est plus appelable de l'extérieur.
📍 `step-17`
🧭 Changer la visibilité et vérifier que tout fonctionne encore.
🤔 Pourquoi l'appel `static::init()` fonctionne-t-il toujours depuis la classe mère ?
💡 `public`, `protected`, `private` : qui peut appeler quoi ?

## Étape 19 — Échapper les sorties · `step-19`
🎯 Aucune donnée venue de la base n'est affichée **sans échappement**.
📍 `step-18`
🧭
- Créer un helper `e()` s'appuyant sur `htmlspecialchars` (guillemets inclus, encodage UTF-8).
- L'utiliser dans **toutes** les vues pour toute donnée issue de la base.

💡 Ne pas échapper `$content` ni `$title` : ce sont déjà des blocs HTML construits par les vues.
⚠️ Oublier une vue (cherchez tous les `echo`) ; échapper deux fois.
✅ Affichez le livre « Harry Potter and the Philosopher's Stone » et regardez le **code source** de la page. Ensuite, en local, mettez `<script>` dans un titre en base et constatez ce qui s'affiche.

## Étape 20 — Ne pas bavarder en cas d'erreur · `step-20`
🎯 Si la connexion à la base échoue, le visiteur ne voit **aucun détail**.
📍 `step-19`
🧭
- Dans `DB`, supprimer le `try/catch` qui affiche le message.
- Provoquer l'erreur (mauvais mot de passe) et comparer : la page, puis le **journal d'erreurs PHP**.

💡 Le message d'erreur révèle l'utilisateur et l'hôte de la base : c'est une information sensible. PHP sait journaliser une erreur sans l'afficher.
⚠️ Pas de `echo` ni de `var_dump` « pour voir ».
✅ Page sans détail ; le détail est dans le journal.

## Étape 21 — Une vraie 404 · `step-21`
🎯 `books/999/x` renvoie une **page 404** propre (et un vrai code HTTP 404).
📍 `step-20`
🧭
- Un repository peut ne **rien trouver** : adapter les types de retour.
- `showAction` vérifie le résultat avant d'aller plus loin.
- Une action `notFoundAction` pose le code HTTP 404 puis charge une vue d'erreur (qui définit ses sections).

💡 Une fonction PHP permet de fixer le code de statut HTTP. Les outils développeur du navigateur (onglet réseau) affichent ce code.
⚠️ Le code de statut doit être posé **avant** toute sortie.
✅ `books/999/x` et `authors/999` → 404.

---

## 🚦 Le routeur

## Étape 22 — Le routeur · `step-22`
🎯 Les routes **se lisent dans un fichier PHP** et non plus dans le `.htaccess`. Le `.htaccess` ne fait plus que renvoyer tout vers `index.php`.
📍 `step-21`
🧭 Le principe, en quatre idées :
1. Toutes les requêtes arrivent à `index.php`.
2. PHP lit l'**URL demandée**, sans le dossier de base du site ni la query string.
3. Il parcourt la **liste des routes déclarées**, dans l'ordre. Chaque route = un pattern (expression régulière) + un contrôleur + une action. La **première** qui correspond est exécutée.
4. Ce que le pattern capture (l'id) est transmis comme **argument** à l'action.

À faire :
- Créer `Core\Route` avec deux méthodes : une qui **mémorise** une route, une qui **cherche et exécute**.
- `App::start()` définit en plus le **dossier de base** du site.
- Déclarer les routes dans le fichier du routeur, avec les **mêmes patterns** que ceux de l'ancien `.htaccess`.
- Supprimer les anciens routeurs `books` et `authors`, et réduire le `.htaccess`.

💡 `parse_url` extrait le chemin d'une URL ; `preg_match` teste une expression régulière et renvoie les captures ; l'opérateur `...` transforme un tableau en arguments ; `ClassName::class` donne le nom complet d'une classe. Avec `#` comme délimiteur de regex, on n'a pas à échapper les `/`.
⚠️ Le dossier de base : le site n'est pas toujours à la racine du serveur.
✅ Toutes les pages fonctionnent encore. L'URL `index.php?books=show&id=abc` ne plante plus.
🤔 Constat : une URL inconnue donne une page vide. Comment la traiter ? → étape 23.

## Étape 23 — La route 404 · `step-23`
🎯 Toute URL inconnue renvoie la page 404.
📍 `step-22`
🧭
- Ajouter **une dernière route** dont le pattern accepte n'importe quelle URL et qui appelle `notFoundAction`.
- Faire en sorte que `PagesController` puisse l'appeler.

💡 Aucun code à ajouter dans `Route` : c'est l'**ordre** des routes qui fait tout le travail.
🤔 Que se passe-t-il si vous placez cette route en **première** position ? Essayez.
✅ `nimportequoi`, `books/1` (sans slug), `books/abc` → 404.

---

## 🏁 Arrivée — et ensuite ?

Vous avez écrit un mini-framework. Les mêmes idées se retrouvent dans **Laravel** :

| Ici | Dans Laravel |
|---|---|
| les routes déclarées dans `app/routers/index.php` | `routes/web.php` (`Route::get(...)`) |
| `BooksRepository::findOneById($id)` | `Book::find($id)` |
| `$book->author->firstname` (lazy loading) | identique (relations Eloquent) |
| `Template::startSection('content')` | `@section('content')` (Blade) |
| `Helpers::e($x)` | `{{ $x }}` |
| `App::start()` | `bootstrap/app.php` |

### 🧗 Défis (facultatifs)
1. Écrire `{id}` dans le pattern d'une route, comme dans Laravel, et le traduire en expression régulière.
2. La relation inverse : `$author->books`.
3. Un slug aussi pour les auteurs.
4. Une page « livres d'une catégorie ».
5. `Route::post` et un petit formulaire.
6. Une route réservée aux utilisateurs connectés (idée de *middleware*).
7. Combien de requêtes SQL pour afficher la liste des livres avec leurs auteurs ? (Activez le journal des requêtes de MySQL.)
