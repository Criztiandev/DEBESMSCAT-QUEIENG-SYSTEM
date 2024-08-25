<?php

require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");
?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add New Operator</h2>


            <form action="/operator/create" method="POST">
                <!-- Operator ID -->
                <div class="w-full mb-4">
                    <label for="OPERATOR_ID"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Operator ID</label>
                    <input type="text" name="OPERATOR_ID" id="OPERATOR_ID"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter Operator ID" required="">
                </div>
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    <!-- FIRST NAME -->
                    <div class="w-full">
                        <label for="FIRST_NAME"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <input type="text" name="FIRST_NAME" id="FIRST_NAME"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your first name" required="">
                    </div>

                    <!-- LAST NAME -->
                    <div class="w-full">
                        <label for="LAST_NAME" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                            Name</label>
                        <input type="text" name="LAST_NAME" id="LAST_NAME"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your last name" required="">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="GENDER" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Gender</label>
                        <select name="GENDER" id="GENDER"
                            class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option disabled selected>Select your Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>


                    <!-- PHONE NUMBER -->
                    <div class="w-full">
                        <label for="PHONE_NUMBER"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                            Number</label>
                        <input type="tel" name="PHONE_NUMBER" id="PHONE_NUMBER"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your last name" required="">
                    </div>


                    <!-- EMAIL -->
                    <div class="w-full">
                        <label for="EMAIL"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="EMAIL" id="EMAIL"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your email" required="">
                    </div>

                    <!-- PASSWORD -->
                    <div class="w-full">
                        <label for="PASSWORD"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="PASSWORD" id="PASSWORD"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your password" required="">
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="ROLE"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select id="ROLE" name="ROLE" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected disabled value="">Select role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role ?>" class="capitalize"><?= $role ?></option>
                            <?php endforeach ?>
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