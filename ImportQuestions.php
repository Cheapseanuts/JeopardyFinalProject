<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'trivia');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
    die('Could not connect: ' . mysql_error());
}

$i = 1;

while ($i <= 100) {
    echo $i. ": ";
    
    // Code from:
    //https://www.educative.io/answers/how-to-use-the-php-curl-function
    // Create a new cURL resource
    $curl = curl_init();
    if (!$curl) {
        die("Couldn't initialize a cURL handle");
    }
    // Set the file URL to fetch through cURL
    curl_setopt($curl, CURLOPT_URL, "https://jservice.io/api/random");
    // Fail the cURL request if response code = 400 (like 404 errors)
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    // Returns the status code
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Wait 10 seconds to connect and set 0 to wait indefinitely
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    // Execute the cURL request for a maximum of 50 seconds
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    // Do not check the SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // Fetch the URL and save the content in $html variable
    $html = curl_exec($curl);
    // Check if any error has occurred
    if (curl_errno($curl)) {
        echo 'cURL error: ' . curl_error($curl);
    } else {
        // cURL executed successfully
        //print_r(curl_getinfo($curl));
        // will display the page contents i.e its html.
        //echo $html;
    }
    // close cURL resource to free up system resources
    curl_close($curl);

    $obj = json_decode($html, true);

    //SET VARIABLES
    $category = str_replace(array('<i>', '</i>', '\'', '\\', '\%', '\_'), '', $obj[0]['category']['title']);
    echo $category . ", ";
    $question = str_replace(array('<i>', '</i>', '\'', '\\', '\%', '\_'), '', $obj[0]['question']);
    echo $question . ", ";
    $answer = str_replace(array('<i>', '</i>', '\'', '\\', '\%', '\_'), '', $obj[0]['answer']);
    echo $answer . ", ";
    $value = $obj[0]['value'];
    echo $value . ", ";
    $airdate = $obj[0]['airdate'];
    echo $airdate . "<br>";
    
    //INSERT INTO DATABASE
    $insertCategories = "INSERT INTO `categories`(`title`) VALUES ('$category')";
    $exists = "SELECT `id` FROM `categories` WHERE `title` = $category";
    $category_id;
    $result = $con->query($exists);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $category_id = $row["id"];
        }
        echo "CATEGORY EXISTS. Category ID: " . $category_id;
    } elseif ($con->query($insertCategories) === TRUE) {
        $category_id = $con->insert_id;
        echo "New category created. Category ID: " . $category_id;
    } else {
        echo "Error: " . $insertCategories . "<br>" . $con->error . "<br>";
    }

    $insertQuestions = "INSERT INTO `questions`(`question`, `answer`, `value`, `airdate`, `catId`) VALUES ('$question','$answer','$value','$airdate','$category_id')";

    if ($con->query($insertQuestions) === TRUE) {
        $question_id = $con->insert_id;
        echo "New question created. Question ID: " . $question_id . "<br>";
    } else {
        echo "Error: " . $insertQuestions . "<br>" . $con->error;
    }
    $i++;
    echo "<br>";
}

$con->close();
