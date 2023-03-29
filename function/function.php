<?php

function test_input($data){

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}


    //Home Redirect Function (This Function Accept Parameters)
    //$errorMsg = Echo The Error Message
    //$seconds =Seconds Before Redirecting

    function redirectHome($theMsg ,$url =null,$seconds =3){

        if($url === null){
            $url ='index.php';
            $link = "Home page";
        }else{
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
                $url = $_SERVER['HTTP_REFERER'];
                $link ="previous page";
            }else{
                $url ='index.php';
                $link = "Home page";
            }
        }

        echo  $theMsg;
        echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
        header("refresh:$seconds;url=$url");
        exit;
    }


    // Get  Records Function 
    // Function to get Records  from database(user , company ,)
    // $select = filed to select
    // $table = the table to choose from
    // $limit = Number of Records to get
    

    function getRecord($select,$table,$where,$condition){
        global $conn;
        $stat = "SELECT $select FROM $table WHERE $where='$condition'";
        $result =$conn->query($stat);
        return $result;
       //$rows ==> Array
    }







    // Count Number of member or item in data base V1
    // function to count number of item rows
    // $item = the item to count
    // $table = the table to choose from

    function countItem($item , $table){
        global $conn;
        $stat2 ="SELECT COUNT($item) FROM $table" ;
        $result =$conn ->query($stat2);
        $rows =$result->fetch_assoc();
        return $rows['COUNT('.$item.')'];

    }


    // Count Number of member or item in data base V2
    // function to count number of item rows
    // $item = the item to count
    // $table = the table to choose from

    function countItem2($item , $table ,$value){
        global $conn;
        $stat2 ="SELECT COUNT($item) FROM $table WHERE $item = $value" ;
        $result =$conn ->query($stat2);
        $rows =$result->fetch_assoc();
        return $rows['COUNT('.$item.')'];

    }


    // Get latest Records Function 
    // Function to get latest item from database(user , item ,comment)
    // $select = filed to select
    // $table = the table to choose from
    // $limit = Number of Records to get
    

        function getLatest($select ,$table ,$order ,$limit =5){
            global $conn;
            $sql ="SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit"; 
            $result = $conn ->query($sql);
            return $result;
           //$rows ==> Array
        }

    // Get latest Records Function v2
    // Function to get latest item from database(user , item ,comment)
    // $select = filed to select
    // $table = the table to choose from
    // $limit = Number of Records to get
    // $value 

    function getLatest2($select ,$table  ,$cond ,$value,$order ,$limit =5){
        global $conn;
        $sql ="SELECT $select FROM $table WHERE $cond =$value ORDER BY $order DESC LIMIT $limit"; 
        $result = $conn ->query($sql);
        return $result;
       //$rows ==> Array
    }    



?>

