<?php

    $page_title = "Homepage";
    include_once("./layoutHeader.php");
    include_once("./config/config.php");

?>


    <!-- Modal -->
<div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

        <!-- creating form tag here so it is inside of modal-body -->
        <form id="saveStudent">

            <div class="modal-body">

                    <!-- d-none hides the warning message until there is one -->
                <div class="alert alert-warning d-none"></div>

                <!-- first name input field -->
                <div class="mb-3">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" class="form-control" required/>
                </div>

                <!-- last name input field -->
                <div class="mb-3">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" class="form-control" required/>
                </div>

                <!-- email input field -->
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required/>
                </div>
                <!-- Phone input field-->
                <div class="mb-3">
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required/>
                </div>
                <!-- course input field -->
                <div class="mb-3">
                    <label for="course">Course</label>
                    <input type="text" name="course" id="course" class="form-control" required/>
                </div>

            </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Save Student</button>
                </div>
        </form>
        </div>
    </div>
</div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Using PHP and Ajax for Crud Operations
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end"
                            data-bs-toggle="modal" data-bs-target="#studentAddModal">
                            Add Student
                            </button>
                        </h4>
                    </div>
                    <!-- fetching the data -->
                    <div class="card-body">

                        <!-- table design -->
                        <table id="databaseTable" class="table table-bordered table-striped">
                            <!-- table head -->
                            <thead>
                                <!-- table row -->
                                <tr>
                                    <!-- table headings -->
                                    <th id="id_header">ID</th>
                                    <th id="fname_header">First Name</th>
                                    <th id="lname_header">Last Name</th>
                                    <th id="email_header">Email</th>
                                    <th id="course_header">Course</th>
                                    <th id="phone_header">Phone Number</th>
                                    <th id="action_header">Action</th>
                                </tr>
                            </thead>
                            <!-- table body -->
                            <tbody>
                                <?php
                                    $conn = CONNECT_MYSQL();
                                    SELECT_EVERYTHING_FROM_STUDENTS($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jquery script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 
    <script>
        // to save the data
        $(document).on('submit', '#saveStudent', function (e) {
            
            // when the form is submit, prevent the page being reloaded
            e.preventDefault();

            // storing form into formData variable
            var formData = new FormData(this); // this refers to the saveStudent form

            // appending the submit button
            formData.append("save_student", true);

            // ajax code
            $.ajax({
                type: "POST", // method type
                url: "code.php", // after code is executed where we'll go
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) { // if successful

                    var res = $.parseJSON(response); // getting this from json response in code.php
                    if (res.status == 422 ) { // for input errors

                        $('#errorrMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);

                    } else if (res.status == 200) { // when successful

                        $('#errorrMessage').addClass('d-none');
                        $('#studentAddModal').modal('hide');

                        // once modal is hidden. must empty the form inputs
                        $('#saveStudent')[0].reset();

                        // refreshing the table once a new student is added
                        $('#databaseTable').load(location.href + " #databaseTable");

                    }
                    
                }
            });
        });

        // for edit student button in modal
        $(document).on('click', '.editStudentBtn', function () {
            
            // storing students id from btn
            var student_id = $(this).val();
            alert(student_id);

            // getting the data
            $.ajax({
                type: "GET",
                url: "code.php?student_id=" + student_id,
                success: function (response) {
                    
                }
            });
        });
    </script>
</body>
</html>