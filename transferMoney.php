<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System</title>
    <link rel="stylesheet" href="transfermoney.css">
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
            <a class="active" href="transferMoney.php">Transfer Money</a>
            <a href="transactions.php">Transaction History</a>
            <a href="https://www.linkedin.com/in/fathima-zulaikha-2741a4217/" target="_blank">Contact Us</a>
            <br />
        </div>
    </div>

    <div class="contentbox">
        <h1> Make a Transaction </h1>

        <div class="subcontent">
            <form action="transferMoney.php" method="POST">    
                <h3> Sender Account </h3>
    
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

                echo "<select id='sender' name='sender'>";
                echo "<option value='' disabled selected hidden>Choose the sender</option>";
                $sql1="Select Name, AccountNo from customers";
                $result= $con-> query($sql1);
                if ($result-> num_rows>0){
                    while ($row = $result-> fetch_assoc()){
                        echo "<option value=".$row["AccountNo"].">".$row["Name"]."<p> &nbsp; &nbsp;</p>". $row["AccountNo"]."</option>";
                    }
                }
                echo "</select>";
                echo "<br> <br> <h3> Receiver Account </h3>";

                echo "<select id='receiver' name='receiver'>";
                echo "<option value='' disabled selected hidden>Choose the receiver</option>";
                $result= $con-> query($sql1);
                if ($result-> num_rows>0){
                    while ($row = $result-> fetch_assoc()){
                        echo "<option value=".$row["AccountNo"].">".$row["Name"]."<p> &nbsp; &nbsp;</p>". $row["AccountNo"]."</option>";
                    }
                }
                echo "</select>";
                $con->close();
            ?>

                <br><br>
                <h3> Amount </h3>
                <input class='input' type="text" name="amount" id="amount" placeholder="Enter the amount"><br>
                <br>
                <button class="button" value="submit"> Send Money</button>
                <br> <br>
            </form>

            <?php
                if (isset($_POST['sender'])){
                    $server="localhost";
                    $username="root";
                    $password="";
                    $dbname="bankingsystem";
                    $tablename="customers";

                    $con=mysqli_connect( $server, $username, $password, $dbname);
                    if (!$con){
                        die("Connection to this database failed due to ".mysqli_connect_error());
                    }

                    $sender=$_POST['sender'];
                    $receiver=$_POST['receiver'];
                    $amount=$_POST['amount'];

                    $sql1 = "SELECT Name, Balance FROM customers WHERE AccountNo=$sender"; 
                    $sql2 = "SELECT Name, Balance FROM customers WHERE AccountNo=$receiver"; 
                    //query to select the amounts from the database for R and S
                    $res1= $con-> query($sql1);
                    $res2= $con-> query($sql2);
                    $sender_bal=$receiver_bal=$sender_name=$receiver_name=0;

                    while($row = $res1-> fetch_assoc()){
                        $sender_bal=$row['Balance'];
                        $sender_name=$row['Name'];
                    }

                    while($row=$res2-> fetch_assoc()){
                        $receiver_bal=$row['Balance'];
                        $receiver_name=$row['Name'];
                    }

                    //if amount doesn't excedd sender's balance then calculate final balance
                    if($sender_bal>=$amount){
                        $receiver_bal=$receiver_bal+$amount;
                        $sender_bal=$sender_bal-$amount;

                        $update1="UPDATE customers SET Balance=$receiver_bal WHERE AccountNo=$receiver";
                        $update2="UPDATE customers SET Balance=$sender_bal WHERE AccountNo=$sender";
  
                        $updatebal_rec=$con-> query($update1);
                        $updatebal_sender=$con-> query($update2);

                        if ($updatebal_sender==true && $updatebal_rec==true){
                            echo "<h3 style='color: green'> Transaction Successful! </h3>";
                            $status="Transaction Successful";

                            //add the record of successful transaction
                            $query_rec="INSERT INTO transactions(Sender_AccountNo, Sender_Name, Receiver_AccountNo, Receiver_Name, Amount_transferred, Sender_Balance, Receiver_Balance, Status) VALUES('$sender', '$sender_name', '$receiver', '$receiver_name','$amount', '$sender_bal', '$receiver_bal', '$status')";
                            if ($con->query($query_rec)==true){
                                $insert=true;
                            }
                            else{
                                echo "ERROR : $sql <br> $con->error";
                            }
                        }
                        else{
                            echo "<h3 style='color: brown'> ERROR! Invalid Account Number  </h3>";
                            echo "ERROR : $sql <br> $con->error";
                        }
                    }
                    if ($amount>$sender_bal){
                        //add the record of failed transactions
                        $status="Transaction Failed";

                        $query_rec="INSERT INTO transactions(Sender_AccountNo,Sender_Name, Receiver_AccountNo, Receiver_Name, Amount_transferred, Sender_Balance, Receiver_Balance, Status) VALUES('$sender', '$sender_name', '$receiver','$receiver_name', '0', '$sender_bal', '$receiver_bal', '$status')";
                        if ($con->query($query_rec)==true){
                            $insert=true;
                        }
                        else{
                            echo "ERROR : $sql <br> $con->error";
                        }
                        echo "<h3 style='color: red'> Transaction Failed! Insufficient Balance in Sender's Account </h3>";
                    }
                    $con->close();
                }
            ?>
 
        </div>
    </div>

    <div class="footer">
        Designed and Developed by Fathima Zulaikha
    </div>
</body>
</html>
