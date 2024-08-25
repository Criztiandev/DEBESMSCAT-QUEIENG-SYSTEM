<?php
require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");
?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add New Department</h2>


            <form action="/department/create" method="POST">

                <!-- Department NAME -->
                <div class="w-full mb-4">
                    <label for="DEPARTMENT_NAME"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department Name</label>
                    <input type="text" name="DEPARTMENT_NAME" id="DEPARTMENT_NAME"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter your batch name" required="">
                </div>
                <!-- Department -->

                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="">
                        <label for="OPERATOR_ID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Operator Name</label>
                        <select name="OPERATOR_ID" id="OPERATOR_ID"
                            class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option disabled selected>Select your operator </option>
                            <?php foreach ($operators as $items): ?>
                                <option value="<?= $items["OPERATOR_ID"] ?>"><?= $items["OPERATOR_FULLNAME"] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>


                    <!-- WINDOWS NAME -->
                    <div class="w-full">
                        <label for="WINDOWS_NUMBER"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Windows Number</label>
                        <input type="text" name="WINDOWS_NUMBER" id="WINDOWS_NUMBER"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your windows number" required="">
                    </div>


                </div>
                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Create
                </button>
            </form>
        </div>
    </section>
</main>



<!-- Script -->
<?php

require from("views/helper/components/script/response.script.php"); ?>
<?php require from("views/helper/partials/footer.partials.php"); ?>