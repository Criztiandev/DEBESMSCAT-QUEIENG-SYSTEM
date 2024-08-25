<?php
require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");

?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update User</h2>


            <form action="/student/update?id=<?= $UID ?>" method="POST">
                <input name="_method" value="PUT" hidden />

                <!-- Student ID -->
                <div class="space-y-4">
                    <!-- Student ID -->
                    <div>
                        <label for="STUDENT_ID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Student ID</label>
                        <input type="text" name="STUDENT_ID" id="STUDENT_ID"
                            class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter your First name" value="<?= $details["STUDENT_ID"] ?>" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">

                        <!-- First Name -->
                        <div>
                            <label for="FIRST_NAME"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                First Name</label>
                            <input type="FIRST_NAME" name="FIRST_NAME" id="FIRST_NAME"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your First name" value="<?= $details["FIRST_NAME"] ?>" required>
                        </div>

                        <!-- Last name -->
                        <div>
                            <label for="LAST_NAME"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                Name</label>
                            <input type="LAST_NAME" name="LAST_NAME" id="LAST_NAME"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your Last name" value="<?= $details["LAST_NAME"] ?>" required=>
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

                        <!-- Phone number -->
                        <div>
                            <label for="PHONE_NUMBER"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Phone number</label>
                            <input type="tel" name="PHONE_NUMBER" id="PHONE_NUMBER"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your phone number" value="<?= $details["PHONE_NUMBER"] ?>" required>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Email -->
                        <div>
                            <label for="EMAIL" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email</label>
                            <input type="email" name="EMAIL" id="EMAIL"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your email" value="<?= $details["EMAIL"] ?>" required>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Course -->
                        <div>
                            <label for="COURSE" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Course</label>
                            <input type="text" name="COURSE" id="COURSE"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your email" value="<?= $details["COURSE"] ?>" required>
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="DEPARTMENT"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Department</label>
                            <select name="DEPARTMENT" id="DEPARTMENT"
                                class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>

                                <option value="" <?= !isset($details["DEPARTMENT"]) ? 'selected' : '' ?>>Select
                                    DEPARTMENT
                                </option>
                                <option value="CAS" <?= isset($details["DEPARTMENT"]) && $details["DEPARTMENT"] == 'CAS' ? 'selected' : '' ?>>College of Arts and Science</option>
                                <option value="CENG" <?= isset($details["DEPARTMENT"]) && $details["DEPARTMENT"] == 'CENG' ? 'selected' : '' ?>>College of Engineering</option>
                                <option value="CA" <?= isset($details["DEPARTMENT"]) && $details["DEPARTMENT"] == 'CA' ? 'selected' : '' ?>>College of Agriculture</option>
                            </select>
                        </div>

                        <!-- Yearlevel -->
                        <div>
                            <label for="YEARLEVEL" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Year level</label>
                            <select name="YEARLEVEL" id="YEARLEVEL"
                                class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option value="" <?= !isset($details["YEARLEVEL"]) ? 'selected' : '' ?>>Select
                                    Year Level
                                </option>

                                <option value="1" <?= isset($details["YEARLEVEL"]) && $details["YEARLEVEL"] == '1' ? 'selected' : '' ?>>1st Year</option>
                                <option value="2" <?= isset($details["YEARLEVEL"]) && $details["YEARLEVEL"] == '2' ? 'selected' : '' ?>>2nd Year</option>
                                <option value="3" <?= isset($details["YEARLEVEL"]) && $details["YEARLEVEL"] == '3' ? 'selected' : '' ?>>3rd Year</option>
                                <option value="4" <?= isset($details["YEARLEVEL"]) && $details["YEARLEVEL"] == '4' ? 'selected' : '' ?>>4th Year</option>


                            </select>
                        </div>


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