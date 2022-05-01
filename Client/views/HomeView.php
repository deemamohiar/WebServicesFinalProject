<!-- This is the home page of a client. This is what they see when they log in -->
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="/WebServicesFinalProject/css/home-style.css">
    </head>
    <body>
        <table>
            <tr>
            <td style="width:10%; text-align:left;">
                <td style="width:1%; text-align:right;">
                    <form action="/WebServicesFinalProject/Client/ClientController/logout">
                        <input id='logout' type="submit" value="Logout" style="float: right;">
                    </form>
                </td>
            </tr>
        </table>

        <center class="main">
            <h1 style="margin-top: 50px;">Welcome!</h1>
            <h3 style="margin: 30px;">
                Please select a category from the
                dropdown and input the corresponding 
                value that you are looking for <i>(if applicable)</i>
            </h3>

            <hr>

            <form action='' method='post' style="margin-top: 20px;">
                <table id='search' cellpadding="5px">
                    <tr style="height: 30px;">
                        <th>Search By:</th>
                        <th>Corresponding Value:</th>
                    </tr>
                    <tr style="height: 30px;">
                        <td>
                            <select name="category" id="category" >
                                <option disabled>--Select a Category--</option>
                                <option>All Country Data</option>
                                <option>Country Name</option>
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
                            <input type='text' name='value' id='value' disabled=true>
                        </td>

                        <!-- Enable / disable input based on category selected -->
                        <script>
                            var select = document.getElementById("category");
                            document.getElementById("category").addEventListener('change', function() {
                                console.log(this.value);
                                if (this.value == 'All Country Data') {
                                    document.getElementById("value").disabled = true;
                                    document.getElementById("value").placeholder = "";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Country Name') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: united";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Country Code') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: pe";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'List of Country Codes') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: col,pe,at";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Currency') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: CAD";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Language') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: german";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Capital City') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: ottawa";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Region') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: europe";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Subregion') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: south";
                                    document.getElementById("value").value = "";
                                }
                                else if (this.value == 'Demonym') {
                                    document.getElementById("value").disabled = false;
                                    document.getElementById("value").placeholder = "Ex: peruvian";
                                    document.getElementById("value").value = "";
                                }
                            });
                        </script> 
                    </tr>
                </table>

                <br><br>
                <input id='submit' type='submit' name='searchB' value='Search'>
                <?php 
                    if ($data != null) {
                        if (!empty($data)) {
                            echo "<p id='error' style='color:red;'>$data</p><br>";
                        }
                    }
                ?>
            </form>
        </center>
    </body>
</html>