<html>
<head>
    <title>Login</title>

    <!-- <link rel="stylesheet" type="text/css" href="../LDHospital/css/login-style.css"> -->
</head>
<body>
    <?php 
    if ($data != null) {
        if (!empty($data)) {
            echo "<p style='color:red;'>$data</p><br>";
        }
    }
    ?>

    <a href="/UserController/register">New User? Click to Register Here!</a>

    <center class="main">
        <h1>Login</h1> 
        <form action='' method='post'>
            <p class="loginInfo">Email</p> <input class='loginInput' type='text' name='email'> 
            <br>
            <br>
            <p class="loginInfo">Password</p> <input class="loginInput" type='password' name='password'> 
            <br>
            <br>
            <input id="submit" type='submit' name='loginB' value='Log in'>
        </form>
    </center>
</body>
</html>