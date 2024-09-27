<?php
session_start();
require 'connect.php';

// Retrieve item ID from the query string
$item_id = mysqli_real_escape_string($conn, $_GET['item_id']);

// Retrieve item details for editing
$sql = "SELECT * FROM additemsdata WHERE item_id = $item_id";
$result = mysqli_query($conn, $sql);
$item = mysqli_fetch_assoc($result);

// Check for change request
if (isset($_POST['update_item'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);

    // Handle image upload
    $image_file = $_FILES['new_image'];
    if ($image_file['error'] == 0) {
        $image_name = $image_file['name'];
        $image_tmp_name = $image_file['tmp_name'];
        $image_path = 'image/' . $image_name;

        // Move uploaded image to the image directory
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // Update database with new image path
            $sql = "UPDATE additemsdata SET name = '$new_name', image = '$image_name' WHERE item_id = $item_id";
        } else {
            $error_message = "Error uploading image.";
        }
    } else {
        // Update database without image change
        $sql = "UPDATE additemsdata SET name = '$new_name' WHERE item_id = $item_id";
    }

    if (mysqli_query($conn, $sql)) {
        header('Location: admindata.php');
    } else {
        $error_message = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Item Data</title>

<style>
    body {
  font-family: sans-serif;
  background-color: #f5f5f5;
  padding: 20px;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
}

form {
  width: 400px;
  margin: 0 auto;
  border: 1px solid #ccc;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="file"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  box-sizing: border-box;
  margin-bottom: 10px;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #3e8e41;
}

p {
  color: red;
  text-align: center;
  margin-bottom: 20px;
}

    </style>

</head>
<body>

<h1>Change Item Data</h1>

<?php if (isset($error_message)): ?>
<p><?php echo $error_message; ?></p>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="new_name">New Name:</label><br>
    <input type="text" id="new_name" name="new_name" value="<?php echo $item['name']; ?>"><br><br>

    <label for="new_image">New Image:</label><br>
    <input type="file" id="new_image" name="new_image"><br><br>

    <input type="submit" name="update_item" value="Update Item">
</form>

</body>
</html>
