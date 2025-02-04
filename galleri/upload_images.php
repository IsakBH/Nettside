<?php
$db = new mysqli('localhost', 'isak', 'some_pass', 'mydb');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$picture_dir = "../Pictures/";
$allowed_types = array('jpg', 'jpeg', 'png', 'gif');

// scan pictures mappen
$files = scandir($picture_dir);

foreach ($files as $file) {
    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_types)) {
        $image_path = $picture_dir . $file;
        $image_data = file_get_contents($image_path);

        // Prepare and execute the INSERT query
        $stmt = $db->prepare("INSERT INTO images (name, image_data) VALUES (?, ?)");
        $stmt->bind_param("ss", $file, $image_data);

        if ($stmt->execute()) {
            echo "Successfully uploaded: " . $file . "<br>";
        } else {
            echo "Failed to upload: " . $file . "<br>";
        }

        $stmt->close();
    }
}

$db->close();
?>
