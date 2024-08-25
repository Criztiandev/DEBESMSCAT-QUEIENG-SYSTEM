<?php
use lib\Router\Express;

require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");
?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Apply Batch</h2>


            <form action="/booking/apply?id=<?= $details["BATCH_ID"] ?>" method="POST">

                <!-- BATCH NAME -->
                <div class="w-full mb-4">
                    <label for="BATCH_NAME" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch
                        Name</label>
                    <input type="text" name="BATCH_NAME" id="BATCH_NAME"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter your batch name" value="<?= $details["BATCH_NAME"] ?>" disabled required="">
                </div>



                <!-- Request form -->

                <label for="SCHEDULE_END" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Request
                    Form</label>
                <div class="grid grid-cols-2 gap-4  min-h-[300px] rounded-md mb-4">

                    <?php foreach ($request_form_list as $key => $value): ?>
                        <label for="<?= "REQUEST_FIELD-" . $key ?>"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 flex items-center  gap-3">
                            <input id="<?= "REQUEST_FIELD-" . $key ?>" type="checkbox" value="<?= strtoupper($value) ?>"
                                name=" REQUEST_FIELD[]"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                            <span class="block my-1 text-sm font-medium text-gray-600 dark:text-white">
                                <?= $value ?>
                            </span>
                        </label>

                    <?php endforeach; ?>
                </div>
                <!-- Purpose -->

                <div class="sm:col-span-2">
                    <label for="PURPOSE"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purpose</label>
                    <textarea name="PURPOSE" id="PURPOSE" rows="8"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Your purpose here"></textarea>
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