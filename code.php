<?php

    include_once("config/config.php");


    // create connection
    $conn = CONNECT_MYSQL();

    // for edit button in modal
    if (isset($_GET['student_id'])) {

        // preventing sql injection
        $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

        $sql = "SELECT * FROM students WHERE id='$student_id'";
    }

    if (isset($_POST['save_student'])) {
        // protecting sql injection
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $course = mysqli_real_escape_string($conn, $_POST['course']);


        // checkcing to make sure the inputs are not null
        if ($fname == null || $lname == null || $email == null || $phone == null || $course == null) {

            // creating an error. status 422 means input error
            $response = [
                'status' => 422,
                'message' => 'All fields are mandatory'
            ];
            echo json_encode($response);
            return false; // if empty returning false
        }

        // if not empty inserting the fields
        $sql = "INSERT INTO students (firstName , lastName ,
                            email , phone, course)
                            VALUE (?, ?, ?, ?, ?)";

        // creating a prepared statement obj
        $stmt = $conn->stmt_init();

        // preparing statement
        if ($stmt->prepare($sql)) {

            // bind parameters
            $stmt->bind_param("sssss",
                                $fname,
                                $lname,
                                $email,
                                $phone,
                                $course
                            );

            // execute statement
            if ($stmt->execute()) {

                $response = [
                    'status' => 200,
                    'messagae' => 'Student created successfully'
                ];
                echo json_encode($response);
                return true;

            } else {

                $response = [
                    'status' => 500,
                    'message' => 'Student Not Created Successfully'
                ];
                echo json_encode($response);
               return false;
            }
        } else {

            die("SQL ERROR: " . mysqli_error($conn));

        }

        // close statement
        $stmt->close();

    }
?>