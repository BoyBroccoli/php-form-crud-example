<?php



function CONNECT_MYSQL()
{

    $host = "localhost";
    $username = "admin";
    $pword = "p@ssw0rd";
    $dbName = "studentFormDB";

    try {

        // create connection
        $conn = new mysqli($host, $username, $pword, $dbName);

        // check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {

            return $conn;
        }
    } catch (mysqli_sql_exception $exception) {

        // if there is an error with the connection
        die("Connection Failed " . $conn->connect_error);
    }
    

}

function SELECT_EVERYTHING_FROM_STUDENTS(&$conn)
{
    try {

        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);

        // checking if data exists
        if (mysqli_num_rows($result) > 0) {

            // for each to show query
            foreach ($result as $student)
            {
                // closing php and echoing inside html table data row
                ?>
                <tr>
                    <td><?= $student['id']?></td>
                    <td><?= $student['firstName']?></td>
                    <td><?= $student['lastName']?></td>
                    <td><?= $student['email']?></td>
                    <td><?= $student['course']?></td>
                    <td><?= $student['phone']?></td>

                    <!-- for CRUD btns -->
                    <td>
                        <a href="" class="btn btn-info">View</a>
                        <button type="button" value="<?=$student['id'];?>"
                                class="editStudentBtn btn btn-success">Edit</button>
                        <button type="button" value="<?$student['id'];?>
                                "class="deleteStudentBtn btn btn-danger">Delete</button>
                    </td>
                </tr>
                <?php
            }
        }

    } catch (mysqli_sql_exception $exception) {

        die("SQL ERROR: " . $conn->connect_error);

    }
}
?>