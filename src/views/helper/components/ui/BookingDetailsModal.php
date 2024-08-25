<div id="modal" hidden class="fixed top-0 left-0 w-screen h-screen" style="z-index: 999">

    <!-- Backdrop -->
    <div id="backdrop" class="w-full h-full bg-black/50"></div>

    <!-- Modal Section -->
    <section class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <div class="relative w-full  h-full md:h-auto">
            <div class="relative text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">


                <div>
                    <section class="min-h-[200px] min-w-[600px] antialiased dark:bg-gray-900">
                        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                            <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Details</h2>

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
                            <div class="grid grid-cols-3 gap-4">
                                <?php
                                $request_form_items = json_decode($booking_details["REQUEST_FORM"], true);
                                if (is_array($request_form_items)) {
                                    foreach ($request_form_items as $key => $item):
                                        ?>
                                        <label for="<?= "REQUEST_FIELD-" . $key ?>"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 flex items-center gap-3">
                                            <span class="block my-1 text-sm font-medium text-gray-600 dark:text-white">
                                                <?= htmlspecialchars($item) ?>
                                            </span>
                                        </label>
                                        <?php
                                    endforeach;
                                } else {
                                    echo "<p>No request form items found.</p>";
                                }
                                ?>


                            </div>
                            <?php if (!empty($booking_details["PURPOSE"])): ?>
                                <div class="h-[200px] border rounded-md mt-4">
                                    <?= htmlspecialchars($booking_details["PURPOSE"]) ?>
                                </div>
                            <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        const $modal = $('#modal');

        function toggleModal(show) {
            $modal.toggle(show);
            $('body').css('overflow', show ? 'hidden' : 'auto');
        }

        // Add this new event listener for the show details button
        $('#show-details-btn').click(function () {
            toggleModal(true);
        });

        $('#cancel-btn, #backdrop, #close-btn').click(function () {
            toggleModal(false);
        });
    });
</script>