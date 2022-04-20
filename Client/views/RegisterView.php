<html>
<head>
    <title>Register</title>

    <link rel="stylesheet" type="text/css" href="/WebServicesFinalProject/css/register-style.css">
</head>
<body>
    <a href="/WebServicesFinalProject/Client/ClientController/login">Already have an account? Login Here!</a>
    
    <h1>Register</h1> 

    <center class="main">
        <form action='' method='post'>
            <table cellpadding="5px">
                <tr style="height: 30px;">
                    <td><p>Name:</p></td>
                    <td><input class='loginInput' type='text' name='name'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Email:</p></td>
                    <td><input class='loginInput' type='text' name='email'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Password:</p></td>
                    <td><input class='loginInput' type='password' name='password'></td>
                </tr>
                <tr style="height: 30px;">
                    <td><p>Confirm Password:</p></td>
                    <td><input class='loginInput' type='password' name='passwordConfirm'></td>
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
            <input id="submit" type='submit' name='registerB' value='Register'>

            <?php 
                if (!empty($data)) {
                    echo "<p id='error' style='color:red;'>$data</p>";
                }
            ?>
        </form>
    </center>
</body>
</html>