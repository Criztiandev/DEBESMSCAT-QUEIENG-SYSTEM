<div id="modal" hidden class="fixed top-0 left-0 w-screen h-screen" style="z-index: 999">

    <!-- Backdrop -->
    <div id="backdrop" class="w-full h-full bg-black/50"></div>

    <!-- Modal Section -->
    <section class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <div class="relative w-full  h-full md:h-auto">
            <div class="relative text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">


                <div>
                    <section class="min-h-[200px] antialiased dark:bg-gray-900">
                        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                            <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Available
                                    Batches</h2>

                                <!-- X Buton -->
                                <button type="button" id="close-btn"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <form id="reschedule-form" method="POST">

                                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                    <?php foreach ($batch_list as $items): ?>
                                        <button id="batch-btn" name="BATCH_ID" value="<?= $items["BATCH_ID"] ?>"
                                            class="flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <input name="_method" value="PUT" hidden />
                                            <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1Z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-white"><?= $items["BATCH_NAME"] ?></span>
                                        </button>
                                    <?php endforeach ?>

                                </div>
                            </form>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        const $modal = $('#modal');
        const rescheduleForm = $("#reschedule-form")

        const closeIDs = ["#backdrop", "#closeModal", "#"]


        function toggleModal(show) {
            $modal.toggle(show);
            $('body').css('overflow', show ? 'hidden' : 'auto');
        }

        $(document).on('click', '.reschedule-modal-btn', function () {
            toggleModal(true)
        });

        $("#batch-btn").click(function () {
            const student_id = $(".reschedule-modal-btn").data("student-id")
            rescheduleForm.attr("action", `/booking/reschedule?id=${student_id}`);
        })

        $('#cancel-btn, #backdrop, #close-btn').click(function () {
            toggleModal(false);
        });

    });
</script>