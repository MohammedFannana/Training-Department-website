<?php
    session_start();

    include "./init.php" ;
    echo "<head> <title>Company Profile</title> </head>";

    //send companyId to companyProfile to show Information about Company

    if(isset($_GET['compId']) && is_numeric($_GET['compId'])){

        $compid = intval($_GET['compId']);
    }   
    
        $sql1 ="SELECT * FROM company WHERE ID = '$compid' "; 
        $result1 = $conn->query($sql1);

        if($result1->num_rows > 0){

            $rows = $result1->fetch_assoc();
?>

            <div class="container">

                <div class="panel information  mt-5">

                    <div class="panel-heading bg-primary text-white" style="padding: 10px 20px;"> Company Information </div>

                    <div class="panel-body bg-white pt-3 pb-3">
                        <div class="row">

                            <div class="col-md-9">
                                <ul class="list-unstyled pb-4 m-0">
                                    <li>
                                        <i class="fa-solid fa-file-signature"></i>
                                        <span class="head"> Company Name </span>    : <p> <?php echo $rows['CompanyName'] ?> </p>
                                    </li>  
                                    <li>
                                        <i class="fa-solid fa-file-signature"></i>
                                        <span class="head"> Description </span>     : <p> <?php echo $rows['Description'] ?> </p> 
                                    </li>  
                                    <li>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span class="head">  Address </span>        : <p> <?php echo $rows['Address'] ?> </p>
                                    </li>
                                    
                                    <li>
                                        <i class="fa-solid fa-square-phone"></i>
                                        <span class="head"> Phone         </span>  : <p> <?php echo $rows['Phone'] ?> </p>                                 
                                    </li> 

                                    <li>
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span class="head"> Register Date </span>   : <p> <?php echo $rows['Date']  ?>  </p>
                                    </li>  

                                </ul>
                            </div>    

                            <div class="col-md-3">
                                
                                <?php 

                                    if(empty($rows["Image"])){

                                        echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads/image/default.jpg" class="card-img-top" alt="..." width="200px">';

                                    }else{
                                        echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads\image\\'.$rows["Image"].'" class="card-img-top" alt="...">';
                                    }

                                ?>            

                            </div>
                        </div>    

                    </div>            
                </div>

            </div> 

<?php
        }else{

            echo "<div class='container'>";
                $theMsg = "<div class ='alert alert-danger mt-3 mb-3'>Error, There's No Such ID</div> ";
                echo $theMsg;
                // redirectHome($theMsg);
            echo "</div>"; 

        } 
?>






<?php include "./templete/footer.php" ?>



