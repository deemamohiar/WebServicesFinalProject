<html>
<head>
    <title>Register</title>

    <!-- <link rel="stylesheet" type="text/css" href="../LDHospital/css/register-style.css"> -->
</head>
<body>
    <a href="/ClientController/login">Already have an account? Login Here!</a>

    <?php 
        if (!empty($data)) {
            echo "<p style='color:red;'>$data</p>";
        }
    ?>

    <center>
        <h1>Register</h1> 
        <form action='' method='post'>
            <table cellpadding="5px">
                <tr style="height: 30px;">
                    <td><p>Name:</p></td>
                    <td><input type='text' name='name'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Email:</p></td>
                    <td><input type='text' name='email'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Password:</p></td>
                    <td><input type='password' name='password'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Confirm Password:</p></td>
                    <td><input type='password' name='passwordConfirm'></td>
                </tr>
            </table>
            
            <!-- For now let's leave this be because we have no clue how to 
            to API keys or license numbers or wtv -->
            <!-- <h3>API </h3> -->
            <!-- <table cellpadding="5px">
                <tr style="height: 30px;">
                    <td><p>Street Address:</p></td>
                    <td><input type='text' name='street_address'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>City:</p></td>
                    <td><input type='text' name='city'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Postal Code:</p></td>
                    <td><input type='text' name='postal_code'></td>
                </tr>
            </table> -->
            <br>
            <input type='submit' name='registerB' value='Register'>
        </form>
    </center>
</body>
</html>