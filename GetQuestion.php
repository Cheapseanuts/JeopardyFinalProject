<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'trivia');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
    die('Could not connect: ' . mysql_error());
}

$question = array();

$sql = "SELECT categories.title, questions.question, questions.answer, questions.value, questions.airdate FROM categories INNER JOIN questions ON categories.id = questions.catId ORDER BY RAND() LIMIT 1";

$result = $con->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //echo "Title: " . $row["title"] . "<br>" . "Question: " . $row["question"] . "<br>" . "Answer: " . $row["answer"] . "<br>" . "Value: " . $row["value"]  . "<br>" . "Airdate: " . $row["airdate"];
    $question = array($row["title"], $row["question"], $row["answer"], $row["value"], $row["airdate"]);
  }
}

header('Content-Type: application/json');

echo json_encode($question);

$con->close();