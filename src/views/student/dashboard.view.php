<?php
require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");
?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">My Bookings</h2>
                </div>

                <!-- Content -->
                <div class="mt-6 flow-root sm:mt-8">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700  border-b rounded-md">

                        <!-- Items -->
                        <?php foreach ($booking_lists as $item): ?>

                            <div class="flex flex-wrap items-center gap-y-4 py-6">

                                <!-- Booking ID -->
                                <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Batch ID:</dt>
                                    <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                        <span href="#" class="hover:underline"><?= $item["BATCH_NAME"] ?></span>
                                    </dd>
                                </dl>

                                <!-- Date -->
                                <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Date:</dt>
                                    <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                        <?= $item["BOOKING_DATE"] ?>
                                    </dd>
                                </dl>

                                <!-- Querue number -->
                                <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Queue Number</dt>
                                    <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                        <?= $item["QUEUE_NUMBER"] ?>
                                    </dd>
                                </dl>

                                <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Inquiries</dt>
                                    <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                        <?= $item["REQUEST_FORM"] ?>
                                    </dd>
                                </dl>


                                <!-- Status -->
                                <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Status:</dt>
                                    <dd
                                        class="me-2 mt-1.5 inline-flex items-center rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                        <?= $item["STATUS"] ?>
                                    </dd>
                                </dl>
                                <?php if ($item["STATUS"] === "ACCEPTED"): ?>


                                    <div
                                        class=" w-full grid sm:grid-cols-2 lg:flex lg:w-32 lg:items-center lg:justify-end gap-4">
                                        <?php if ($item["STATUS"] === "PENDING"): ?>
                                            <button type="button" data-delete-id="<?= $item["BOOKING_ID"] ?>"
                                                class=" delete-modal-btn w-full rounded-lg border border-red-700 px-3 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white dark:focus:ring-red-900 lg:w-auto">Cancel
                                                Book</button>
                                        <?php endif ?>

                                        <?php if ($item["STATUS"] === "ACCEPTED"): ?>
                                            <a href="/batch/view?id=<?= $item["BOOKING_ID"] ?>"
                                                class="w-full inline-flex justify-center rounded-lg  border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 lg:w-auto">View
                                                details</a>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>

                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>


            </div>
        </div>
    </section>
</main>


<?php display("views/helper/components/ui/DeleteModal.php", ["route" => "/booking/apply/delete"]) ?>


<!-- Script -->
<?php require from("views/helper/components/script/response.script.php"); ?>
<?php require from("views/helper/partials/footer.partials.php"); ?>