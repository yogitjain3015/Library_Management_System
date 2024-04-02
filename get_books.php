<?php

// Check if the 'category' parameter is set in the GET request
if(isset($_GET['category'])) {
    $category = $_GET['category'];

    // Database connection parameters
    $servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password
    $dbname = "library"; // Change this to your MySQL database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define an array to store book information
    $books = array();

    // Construct SQL query based on the selected category
    $sql = "SELECT * FROM " . $category;

    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        // Fetch rows from the result set
        while ($row = $result->fetch_assoc()) {
            // Add each row to the books array
            $books[] = $row;
        }

        // Close result set
        $result->close();
    } else {
        // If query execution failed, return an error message
        $books['error'] = "Error executing query: " . $conn->error;
    }

    // Close connection
    $conn->close();

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($books);
} else {
    // If 'category' parameter is not set, return an error message
    echo json_encode(array('error' => 'Category parameter is not set.'));
}

?>
