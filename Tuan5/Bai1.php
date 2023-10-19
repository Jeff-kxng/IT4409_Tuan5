<?php
// Initialize variables to store user data and errors
$name = $email = $comment = "";
$name_err = $email_err = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the name
    if (empty($_POST["name"])) {
        $name_err = "Họ tên là bắt buộc";
    } else {
        $name = test_input($_POST["name"]);
        if (!ctype_alpha(str_replace(' ', '', $name)) || trim($name) === '') {
            $name_err = "Chỉ chấp nhận ký tự và dấu cách, không được có toàn bộ là dấu cách";
        }
    }

    // Check email
    if (empty($_POST["email"])) {
        $email_err = "Email là bắt buộc";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Email không đúng định dạng";
        }
    }

    // Get the comment if provided
    if (!empty($_POST["comment"])) {
        $comment = test_input($_POST["comment"]);
    }
}

// Function to sanitize user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<h2>Bình luận</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Họ tên: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $name_err;?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $email_err;?></span>
    <br><br>
    Bình luận: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
    <br><br>
    <input type="submit" name="submit" value="Gửi">
</form>

<?php
if ($name_err == "" && $email_err == "" && $_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Bình luận của bạn đã được ghi nhận</h2>";
    echo "<p>Họ tên: ".$name."</p>";
    echo "<p>Email: ".$email."</p>";
    echo "<p>Bình luận: ".$comment."</p>";
}
?>
</body>
</html>
