<?php

$grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

$query = "SELECT
les.id,
les.title
FROM lessons les LEFT JOIN subjects sub
ON les.subject_id = sub.id
WHERE sub.grade_level = $grade_level AND les.deleted_at IS NULL AND sub.deleted_at IS NULL";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);