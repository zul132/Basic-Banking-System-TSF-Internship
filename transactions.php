<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System</title>
    <link rel="stylesheet" href="transactions.css">
</head>
<body>
    <div class="container">
        <div><img src="assets/bank_logo.jpg" class="logo"></div>
        <div class="title" >The Sparks Bank</div>

        <div class="navbar">
            <br />
            <a href="index.html">Home</a>
            <a href="https://github.com/zul132" target="_blank">About Us</a>
            <a href="customers.php">View Customers</a>
            <a href="transferMoney.php">Transfer Money</a>
            <a class="active" href="transactions.php">Transaction History</a>
            <a href="https://www.linkedin.com/in/fathima-zulaikha-2741a4217/" target="_blank">Contact Us</a>
            <br />
        </div>
    </div>

    <div class="contentbox">
        <h1> Transaction History </h1>
        <table class="transaction">
            <tr>
                <th> ID </th>
                <th> SENDER'S ACCOUNT NO. </th>
                <th> SENDER'S NAME </th>
                <th> RECEIVER'S ACCOUNT NO. </th>
                <th> RECEIVER'S NAME </th>
                <th> AMOUNT TRANSFERRED </th>
                <th> SENDER'S BALANCE </th>
                <th> RECEIVER'S BALANCE </th>
                <th> TRANSACTION STATUS </th>
                <th> TIME </th>
            </tr>

            <?php
                $server="localhost";
                $username="root";
                $password="";
                $dbname="bankingsystem";

                //establish db connection
                $con=mysqli_connect( $server, $username, $password, $dbname);
                //check for connection success
                if (!$con){
                    die("Connection to this database failed due to ".mysqli_connect_error());
                }
                $sql="Select * from transactions";
                $result= $con-> query($sql);
                if ($result-> num_rows>0){
                    while ($row = $result-> fetch_assoc()){
                        echo "<tr><td>".$row["ID"]."</td><td>".$row["Sender_AccountNo"]."</td><td>".$row["Sender_Name"]."</td><td>".$row["Receiver_AccountNo"]."</td><td>".$row["Receiver_Name"]."</td><td>".$row["Amount_transferred"]."</td><td>".$row["Sender_Balance"]."</td><td>".$row["Receiver_Balance"]."</td><td>".$row["Status"]."</td><td>".$row["Transaction_Time"]."</td></tr>";
                    }
                    echo "</table>";
                }
                else{
                        echo "</table> <br>";
                        echo "0 Result Found!";
                }
                $con->close();
            ?>

    </div>

    <div class="footer">
        Designed and Developed by Fathima Zulaikha
    </div>
</body>
</html>