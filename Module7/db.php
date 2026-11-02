<?php
$conn = pg_connect(
    "host=localhost port=5433 dbname=study_planner user=postgres password=Abood1910"
);

if (!$conn) {
    exit("Database connection failed.");
} else {
    echo "Database connected successfully!";
}

?>