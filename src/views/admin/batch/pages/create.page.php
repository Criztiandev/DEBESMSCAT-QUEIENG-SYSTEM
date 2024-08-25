<?php
use lib\Router\Express;

require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");
?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add New Batch</h2>


            <form action="/batch/create" method="POST">
                <!-- Department -->
                <?php if (Express::Session()->get("credentials")["role"] === "admin"): ?>

                    <div class="mb-4">
                        <label for="DEPARTMENT_ID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Department</label>
                        <select name="DEPARTMENT_ID" id="DEPARTMENT_ID"
                            class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option disabled selected>Select your Department </option>
                            <?php foreach ($departments as $items): ?>
                                <option value="<?= $items["DEPARTMENT_ID"] ?>"><?= $items["DEPARTMENT_NAME"] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                <?php endif; ?>

                <div class="w-full my-4">
                    <label for="BOOKING_DATE" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                    </label>
                    <input type="date" name="BOOKING_DATE" id="BOOKING_DATE"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter your batch name" required="">
                </div>


                <!-- Content -->
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    <!-- BATCH NAME -->
                    <div class="w-full">
                        <label for="BATCH_NAME"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch Name</label>
                        <input type="text" name="BATCH_NAME" id="BATCH_NAME"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your batch name" required="">
                    </div>

                    <!-- STUDENT CAPACITY -->
                    <div class="w-full">
                        <label for="MAX_STUDENT"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Max
                            Student Capacity</label>
                        <input type="text" name="MAX_STUDENT" id="MAX_STUDENT"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your last name" required="">
                    </div>

                    <div class="mb-4">
                        <label for="YEARLEVEL" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Year level</label>
                        <select name="YEARLEVEL" id="YEARLEVEL"
                            class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option disabled selected>Select year level </option>
                            <option value="all">All</option>
                            <option value="1st"> 1st year</option>
                            <option value="2nd"> 2nd year</option>
                            <option value="3rd"> 3rd year</option>
                            <option value="4th"> 4th year</option>
                        </select>
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