<?php
require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");

?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update User</h2>


            <form action="/batch/update?id=<?= $UID ?>" method="POST">
                <input name="_method" value="PUT" hidden />

                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    <!-- FIRST NAME -->
                    <div class="w-full">
                        <label for="BATCH_NAME"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch Name</label>
                        <input type="text" name="BATCH_NAME" id="BATCH_NAME"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your first name" value="<?= $details["BATCH_NAME"] ?>" required="">
                    </div>

                    <!-- LAST NAME -->
                    <div class="w-full">
                        <label for="MAX_STUDENT"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Max
                            Capacity</label>
                        <input type="text" name="MAX_STUDENT" id="MAX_STUDENT"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your last name" value="<?= $details["MAX_STUDENT"] ?>" required="">
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label for="STATUS" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Status</label>
                        <select name="STATUS" id="STATUS"
                            class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value="" <?= !isset($details["STATUS"]) ? 'selected' : '' ?>>Select Status</option>
                            <option value="ACTIVE" <?= isset($details["STATUS"]) && $details["STATUS"] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="INACTIVE" <?= isset($details["STATUS"]) && $details["STATUS"] == 'deactive' ? 'selected' : '' ?>>Deactive</option>
                        </select>
                    </div>


                </div>
                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Update
                </button>
            </form>
        </div>
    </section>
</main>



<!-- Script -->
<?php

require from("views/helper/components/script/response.script.php"); ?>
<?php require from("views/helper/partials/footer.partials.php"); ?>