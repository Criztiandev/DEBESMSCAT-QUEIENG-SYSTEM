<?php
require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");

?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="mt-4 overflow-hidden">
        <div class=" h-full  flex grid grid-cols-[auto_25%] gap-4 overflow-hidden">
            <div
                class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden overflow-y-scroll h-full border">

                <div class="overflow-x-auto" style="height: calc(100vh - 190px);">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">#ID</th>
                                <th scope="col" class="px-4 py-3">Name</th>
                                <th scope="col" class="px-4 py-3">Course</th>
                                <th scope="col" class="px-4 py-3">Inquries</th>
                                <th scope="col" class="px-4 py-3">Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($student_list as $items): ?>
                                <tr class="border-b dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $items["STUDENT_ID"] ?>
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $items["FULL_NAME"] ?>
                                    </th>

                                    <td class="px-4 py-3">
                                        <?= $items["COURSE"] ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?= count(json_decode($items["BOOKING_DETAILS"]["REQUEST_FORM"])) ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-primary-300">
                                            <?= $items["STATUS"] ?>
                                        </span>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                                class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="border rounded-md  shadow-md p-4 flex flex-col justify-between overflow-y-scroll"
                style="overflow: hidden">

                <div class="flex-1  flex justify-center items-center overflow-hidden">
                    <div class="flex flex-col gap-4 items-center  w-full">
                        <div
                            class="p-4 rounded-full border w-[200px] h-[200px] flex justify-center items-center bg-primary-200">
                            <h1 class="text-[64px] font-bold">
                                <?= $student_list[$current_index ?? 0]["QUEUE_NUMBER"] ?>
                            </h1>


                        </div>
                        <div class="flex justify-center items-center flex-col w-full space-y-8 overflow-hidden">
                            <h2 class="text-2xl font-bold"><?= $student_list[$current_index ?? 0]["FULL_NAME"] ?>
                            </h2>
                            <div class=" w-full">
                                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                    <span for="bordered-checkbox-1"
                                        class="w-full py-4 ms-2 text-sm grid grid-cols-[25%_auto]  font-medium text-gray-900 dark:text-gray-300 space-x-2">
                                        <span>Year Level: </span>
                                        <span
                                            class="badge bg-primary-600 text-white"><?= $student_list[$current_index ?? 0]["YEARLEVEL"] ?? "N/A" ?></span></span>
                                </div>

                                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                    <span for="bordered-checkbox-1"
                                        class="w-full grid grid-cols-[20%_auto] py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 space-x-3">
                                        <span>Course: </span>
                                        <span
                                            class="word-break"><?= $student_list[$current_index ?? 0]["COURSE"] ?? "N/A" ?></span></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="  flex justify-between items-center  gap-4">
                    <form
                        action="batch/queue/hold?id=<?= $queue_id ?>&selected=<?= $student_list[$current_index ?? 0]["STUDENT_ID"] ?>"
                        method="POST">
                        <input name="_method" value="PUT" hidden />
                        <button type="submit"
                            class="inline-flex w-full justify-center items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                            Hold
                        </button>
                    </form>

                    <button type="button" id="show-details-btn"
                        class="inline-flex w-full justify-center items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        Details
                    </button>


                    <form
                        action="batch/queue/next?id=<?= $queue_id ?>&selected=<?= $student_list[$current_index ?? 0]["STUDENT_ID"] ?>"
                        method="POST">
                        <input name="_method" value="PUT" hidden />
                        <button type="submit"
                            class="inline-flex w-full justify-center items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                            Next
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
</main>

<?php display("views/helper/components/ui/BookingDetailsModal.php", ["booking_details" => $student_list[$current_index]["BOOKING_DETAILS"]]) ?>

<!-- Script -->
<?php require from("views/helper/components/script/response.script.php"); ?>
<?php require from("views/helper/partials/footer.partials.php"); ?>