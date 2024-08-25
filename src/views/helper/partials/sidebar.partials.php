<?php

use lib\Router\Express;

$role = Express::Session()->get("credentials")["role"];
$navigation = require from("views/navigation.php");


function isUri($path)
{
    $currentURI = $_SERVER["REQUEST_URI"];
    return $path === $currentURI;
}

?>

<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full  border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full  dark:bg-gray-800 pt-6">

        <ul class="space-y-2">
            <?php foreach ($navigation[$role] as $nav): ?>
                <li>
                    <a href="<?= $nav['path'] ?>"
                        class="<?= isUri($nav['path']) ? "bg-gray-300 dark:text-black text-gray-900 dark:hover:text-black" : "opacity-70" ?> flex items-center p-2 text-base font-medium  rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-black group">
                        <?= $nav['icon'] ?>
                        <span class="ml-3 dark:text-white"><?= $nav['title'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</aside>
<?php


?>