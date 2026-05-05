<?php
session_start(); // nyalain session
include 'koneksi.php'; // konek db

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $q = mysqli_query($koneksi,"
    SELECT * FROM user 
    WHERE username='$username' 
    AND password='$password'
    ");

    if(mysqli_num_rows($q) > 0){

        $data = mysqli_fetch_assoc($q);

        $_SESSION['login'] = true; // tanda login
        $_SESSION['user'] = $data['username']; // simpen user
        $_SESSION['role'] = $data['role']; // simpen role

        header("Location: utama.php"); // masuk dashboard
        exit;

    } else {
        $error = true; // animasi error
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login E-Raport</title>

<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet" href="rapot_css/login.css">
</head>

<body>

<div class="bg-anim"></div> <!-- background animasi -->

<div class="login-wrapper">

    <div class="login-card <?php if(isset($error)) echo 'shake'; ?>"> <!-- card + efek goyang -->

        <div class="login-icon">
            <i class="fa-solid fa-user-lock"></i>
        </div>

        <h4 class="text-center mb-3">Login E-Raport</h4>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger text-center">
                Login Gagal!
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>

                <div class="password-box">
                    <input type="password" id="password" name="password" class="form-control" required>

                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
            </div>

            <button name="login" class="btn btn-login w-100">
                Login
            </button>

        </form>

    </div>

</div>

<script>
// show hide password
function togglePassword(){
    var input = document.getElementById("password");
    var icon = document.querySelector(".toggle-password i");

    if(input.type === "password"){
        input.type = "text";
        icon.classList.replace("fa-eye","fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }
}
</script>

</body>
</html>