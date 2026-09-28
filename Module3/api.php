<?php
ob_start();

header("Content-Type: application/json");

$students = [
    [
        "id" => 1,
        "name" => "John",
        "course" => "CMPS361"
    ],
    [
        "id" => 2,
        "name" => "Sarah",
        "course" => "CMPS361"
    ],
    [
        "id" => 3,
        "name" => "Michael",
        "course" => "CMPS361"
    ]
];

echo json_encode($students, JSON_PRETTY_PRINT);

ob_end_flush();

?>