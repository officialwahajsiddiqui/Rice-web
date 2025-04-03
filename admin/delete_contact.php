<?php
// Ensure this script doesn't run if no 'id' is provided
if (isset($_GET['id'])) {
    $contactId = intval($_GET['id']); // Sanitize the input

    // Include your PDO database connection
    include 'db.php';  // Assuming db.php includes a PDO connection

    try {
        // Prepare the delete query
        $sql = "DELETE FROM contacts WHERE id = :id";
        $stmt = $conn->prepare($sql);

        // Bind the parameter and execute the deletion
        $stmt->bindParam(':id', $contactId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Successful deletion
            header("Location: contact?status=deleted");
        } else {
            // Deletion failed
            header("Location: contact?status=error");
        }

    } catch (PDOException $e) {
        // Catch any PDO errors and redirect with the error status
        header("Location: contact?status=db_error");
    }

    exit();
} else {
    // If no 'id' is present in the URL, redirect with an invalid status
    header("Location: contact?status=invalid");
    exit();
}
?>
