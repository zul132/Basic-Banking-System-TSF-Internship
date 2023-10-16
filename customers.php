<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System</title>
    <link rel="stylesheet" href="customers.css">
</head>
<body>
    <div class="container">
        <div><img src="assets/bank_logo.jpg" class="logo"></div>
        <div class="title" >The Sparks Bank</div>

        <div class="navbar">
            <br />
            <a href="index.html">Home</a>
            <a href="https://github.com/zul132" target="_blank">About Us</a>
            <a class="active" href="customers.php">View Customers</a>
            <a href="transferMoney.php">Transfer Money</a>
            <a href="transactions.php">Transaction History</a>
            <a href="https://www.linkedin.com/in/fathima-zulaikha-2741a4217/" target="_blank">Contact Us</a>
            <br />
        </div>
    </div>

    <div class="contentbox" cellspacing="20px" cellpadding="20px">
        <h1> ALL CUSTOMERS </h1>

        <table class="customer" style="font-color: white">
            <tr>
                <th> Name </th>
                <th> Email </th>
                <th> Account No </th>
                <th> Balance </th>
            </tr>

            <?php
                $server="localhost";
                $username="root";
                $password="";
                $dbname="bankingsystem";

                //establish db connections
                $con=mysqli_connect( $server, $username, $password, $dbname);
                //check for connection success
                if (!$con){
                    die("Connection to this database failed due to ".mysqli_connect_error());
                }

                $sql="Select Name, Email, Account_no, Balance from customers";
                $result= $con-> query($sql);
                if ($result-> num_rows>0){
                    while ($row = $result-> fetch_assoc()){
                        echo "<tr><td>".$row["Name"]."</td><td>".$row["Email"]."</td><td>".$row["Account_no"]."</td><td>".$row["Balance"]."</td></tr>";
                    }
                    echo "</table>";
                }
                else{
                    echo "0 Result Found!";
                }
                $con->close();
            ?>

    <div class="footer">
        Designed and Developed by Fathima Zulaikha
    </div>
</body>
</html>