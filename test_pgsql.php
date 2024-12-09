<?php
try {
    $conn = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=jobsportal', 'Jobsportal', '1234');
    echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
