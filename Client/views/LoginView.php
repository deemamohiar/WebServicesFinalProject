<html>
<head>
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="../css/login-style.css">
</head>
<body>
    <a href="/WebServicesFinalProject/Client/ClientController/register">No Account? Sign Up Here!</a>

    <h1>L&D Country Lookup</h1>
    <center class="main">
        <h2>Login</h2> 
        <form action='' method='post'>
            <p>Email</p> <input class='loginInput' type='text' name='email'> 
            <br>
            <br>
            <p>Password</p> <input class="loginInput" type='password' name='password'> 
            <br>
            <br>
            <input id="submit" type='submit' name='loginB' value='Log in'>
        </form>

        <?php 
            if ($data != null) {
                if (!empty($data)) {
                    echo "<p id='error' style='color:red;'>$data</p><br>";
                }
            }
        ?>
    </center>
</body>
</html>