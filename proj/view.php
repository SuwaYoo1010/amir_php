<div class="record-card">
    <div class="rec-head">
        <h3>All Student Records</h3>
    </div>
    <div class="search-box">
        <form method="get" action="admin_dashboard.php">
            <label for="search"><h4>Search by Name:</label>   
            <input type="text" id="search" name="search" value="<?php echo $search; ?>">
            <button type="submit">Search</h4></button>  
        </form>
    </div>
    <div class="record">
        <table border="0">
            <tr>
                <!--<th>        </th> <td>{$row['row_number']}</td> -->
                <th>Student ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Email</th>
                <th>Course</th>
                <th>GPA</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($resultAllStudentRecords)) {
                echo "<tr>
                        
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['course']}</td>
                        <td>{$row['gpa']}</td>
                        <td>
                            <button class='edit-button'><a href='update_student.php?id={$row['id']}' class='action-btn'>Update</a></button>
                            <button class='delete-button'><a href='admin_dashboard.php?delete_id={$row['id']}&page=$page&search=$search' class='action-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a></button>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>
        <?php
        $sqlCountRecords = "SELECT COUNT(*) AS total FROM student s
                            JOIN login l ON s.id = l.id
                            WHERE s.name LIKE '%$search%'";
        $resultCountRecords = mysqli_query($conn, $sqlCountRecords);
        $rowCount = mysqli_fetch_assoc($resultCountRecords)['total'];
        $totalPages = ceil($rowCount / $recordsPerPage);

        echo "<div class='pagination'>";

        if ($page > 1) {
            echo "<a href='admin_dashboard.php?page=" . ($page - 1) . "&search=$search'>Previous</a>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='admin_dashboard.php?page=$i&search=$search'>$i</a>";
        }

        if ($page < $totalPages) {
            echo "<a href='admin_dashboard.php?page=" . ($page + 1) . "&search=$search'>Next</a>";
        }

        echo "</div>";
    ?>
</div>
