<?php
session_start();
$i = 0;

$xml[] = simplexml_load_file('company.xml');

if (isset($_POST["insert"])) {
    $employee = $xml[0]->addChild('employee');
    $employee->addchild('name', $_POST['name']);
    $employee->addChild('phone', $_POST['phonenumber']);
    $employee->addChild('address', $_POST['address']);
    $employee->addChild('email', $_POST['email']);
    file_put_contents('company.xml', $xml[0]->asXML());

} elseif (isset($_POST["update"])) {
    if (isset($_SESSION["id"])) {
        $i = $_SESSION["id"];
        $xml[0]->employee[$i]->name = $_POST["name"];
        $xml[0]->employee[$i]->phone = $_POST["phonenumber"];
        $xml[0]->employee[$i]->adress = $_POST["address"];
        $xml[0]->employee[$i]->email = $_POST["email"];
    } else {
        $i = 0;
        $xml[0]->employee[$i]->name = $_POST["name"];
        $xml[0]->employee[$i]->phone = $_POST["phonenumber"];
        $xml[0]->employee[$i]->adress = $_POST["address"];
        $xml[0]->employee[$i]->email = $_POST["email"];
    }
    $xml[0]->asXML('company.xml');
} elseif (isset($_POST["delete"])) {
    if (isset($_SESSION["id"])) {
        $i = $_SESSION["id"];
        if($i == (count($xml[0]->employee)-1))
        {
             unset($xml[0]->employee[$i]);
             $i-=1;
             $_SESSION["id"]=$i;
        }
        else
        {
            unset($xml[0]->employee[$i]);
        }
    
    } else {
        $i = 0;
        unset($xml[0]->employee[$i]);

    }
    $xml[0]->asXML('company.xml');
} elseif (isset($_POST["prev"])) {
    if ($_SESSION["id"] <= 0) {
        $i = 0;
        $_SESSION["id"] = $i;
    } else {
        $_SESSION["id"] = $_SESSION["id"] - 1;
        $i = $_SESSION["id"];
    }

} elseif (isset($_POST["searchbyname"])) {
    $key = $_POST["name"];
    $found = 0;
    for ($j = 0; $j < count($xml[0]->employee); $j++) {
        if (strcmp($key, $xml[0]->employee[$j]->name) == 0) {
            $i = $j;
            $_SESSION["id"] = $i;
            $found = 1;
        }
    }
    if (!$found) {
        echo "there is no employee with this name";
    } else {
        echo "found";
    }

} elseif (isset($_POST["next"])) {
    if (isset($_SESSION["id"])) {
        $_SESSION["id"] = $_SESSION["id"] + 1;
        if ($_SESSION["id"] < count($xml[0]->employee)) {
            $i = $_SESSION["id"];
        } else {
            $i = (count($xml[0]->employee))-1;
            $_SESSION["id"] = $i;
        }

    } else {
        $i++;
        $_SESSION["id"] = $i;}
}
/*highlight_string('<?php ' . var_export($xml, true) . ';?>');
echo count($xml[0]->employee);

foreach ($xml as $key => $value) {
    echo $value;
    echo "<br>";
    echo "<br>";
}*/

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles.css">


</head>
<body>
<div class="container">

    
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">

            <div class="col-25">
            <label for="name">Name</label>
            </div>

            <div class="col-75">
            <input type="text" placeholder="name" value="<?php echo $xml[0]->employee[$i]->name; ?>" name="name">
            </div>
       
            </div>
           

            <div class="row">

            <div class="col-25"> 
            <label for="phone">Phone</label>
            </div>
            <div class="col-75">
            <input type="text" placeholder="phone" value="<?php echo $xml[0]->employee[$i]->phone; ?>" name="phonenumber">
            </div>
          

            </div>
           
            <div class="row">

            <div class="col-25">
            <label for="address">Address</label>
            </div>

            <div class="col-75">
            <input type="text"  name="address" value="<?php echo $xml[0]->employee[$i]->adress; ?>" placeholder="Address">
            </div>

            </div>
       

           
            <div class="row">

            <div class="col-25">
            <label for="email">Email</label>
            </div>

            <div class="col-75">
            <input type="email" placeholder="E-mail" value="<?php echo $xml[0]->employee[$i]->email; ?>" name="email">
            </div>

            </div>

            <br><br>
            <div class="row buttons">
            <div class="col-12 ">
            <button type="submit" name="prev"><<<</button> 
            <button type="submit" name="next">>>></button>
            </div>
            <div class="col-12">
            <button type="submit"  name="searchbyname">Search by Name</button>
            </div> 
            <div class="col-12">
            <button type="submit" name="insert">Insert</button> 
            </div>
            <div class="col-12">
            <button type="submit"  name="update">Update</button>
            </div>
            <div class="col-12">
            <button type="submit" name="delete">Delete</button> 
            </div> 

        </form>
     
    
</div>
</body>
</html>