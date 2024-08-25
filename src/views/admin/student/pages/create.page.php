<?php
require from("views/helper/partials/head.partials.php");
require from("views/helper/partials/navbar.partials.php");
require from("views/helper/partials/sidebar.partials.php");
?>


<main class="p-4 md:ml-64 h-auto pt-20 overflow-hidden">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add New Student</h2>


            <form class="space-y-4 md:space-y-6" action="/student/create" method="POST">

                <div class="space-y-4">
                    <!-- Student ID -->
                    <div>
                        <label for="STUDENT_ID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Student ID</label>
                        <input type="text" name="STUDENT_ID" id="STUDENT_ID"
                            class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter your First name" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">

                        <!-- First Name -->
                        <div>
                            <label for="FIRST_NAME"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                First Name</label>
                            <input type="FIRST_NAME" name="FIRST_NAME" id="FIRST_NAME"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your First name" required>
                        </div>

                        <!-- Last name -->
                        <div>
                            <label for="LAST_NAME"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                Name</label>
                            <input type="LAST_NAME" name="LAST_NAME" id="LAST_NAME"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your Last name" required=>
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
                                placeholder="Enter your phone number" required>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Email -->
                        <div>
                            <label for="EMAIL" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email</label>
                            <input type="email" name="EMAIL" id="EMAIL"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your email" required>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="PASSWORD"
                                class=" block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="PASSWORD" id="PASSWORD" placeholder="••••••••"
                                class=" input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Course -->
                        <div>
                            <label for="COURSE" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Course</label>
                            <input type="text" name="COURSE" id="COURSE"
                                class="input input-bordered bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your email" required>
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="DEPARTMENT"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Department</label>
                            <select name="DEPARTMENT" id="DEPARTMENT"
                                class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option disabled selected>Select your Department</option>
                                <option value="CAS">College of Arts and Science</option>
                                <option value="CENG">College of Engineering</option>
                                <option value="CA">College of Agriculture</option>
                                <option value="CA">College of Agriculture</option>

                            </select>
                        </div>

                        <!-- Yearlevel -->
                        <div>
                            <label for="YEARLEVEL" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Year level</label>
                            <select name="YEARLEVEL" id="YEARLEVEL"
                                class="select select-bordered w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option disabled selected>Select your Year level</option>
                                <option value="1">1st year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>

                            </select>
                        </div>


                    </div>



                </div>



                <div class="flex justify-center items-center flex-col gap-4">

                    <button type="submit"
                        class="btn w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 max-w-sm">Create
                        Student</button>
                </div>

            </form>
        </div>
    </section>
</main>



<!-- Script -->
<?php

require from("views/helper/components/script/response.script.php"); ?>
<?php require from("views/helper/partials/footer.partials.php"); ?>