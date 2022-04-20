<html>
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/home-style.css">
    </head>
    <body>
        <table>
            <tr>
            <td style="width:10%; text-align:left;">
                <td style="width:1%; text-align:right;">
                    <form action="/ClientController/logout">
                        <input type="submit" value="Logout" style="float: right;">
                    </form>
                </td>
            </tr>
        </table>

        <center>
            <h1 style="margin-top: 50px;">Welcome!</h1>
            <h3 style="margin: 30px;">
                Please <span style='color:#2D9B00'>select a category</span> from the
                dropdown and <span style='color:#2D9B00'>input the corresponding 
                value</span> that you are looking for <i>(if applicable)</i>
            </h3>

            <hr>

            <form action='' method='post' style="margin-top: 20px;">
                <table cellpadding="5px">
                    <tr style="height: 30px;">
                        <th>Search By:</th>
                        <th>Corresponding Value:</th>
                    </tr>
                    <tr style="height: 30px;">
                        <td>
                            <select name="category">
                                <option disabled>--Select a Category--</option>
                                <option>All Country Data</option>
                                <option>Country Name</option>
                                <option>Full Country Name</option>
                                <option>Country Code</option>
                                <option>List of Country Codes</option>
                                <option>Currency</option>
                                <option>Language</option>
                                <option>Capital City</option>
                                <option>Region</option>
                                <option>Subregion</option>
                                <option>Demonym</option>
                            </select>
                        </td>
                        <td>
                            <input type='text' name='value'>
                        </td>
                    </tr>
                </table>

                <br><br>
                <input type='submit' name='searchB' value='Search'>
            </form>
        </center>
    </body>
</html>