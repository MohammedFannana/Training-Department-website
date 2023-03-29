<?php
    session_start();
    ob_start();
    include "./init.php";

    if(isset($_SESSION['email'])){
        include "./templete/NavbarS.php";

        $sessionUser = $_SESSION['email'];

        // use This Way to divide page into many internal page
        $page ='';

        //to collect var page from link
        if(isset($_GET['page'])){
            $page =$_GET['page'];

        }else{
            $page = 'Home';
        }



        if($page == "Home"){
            //Start Home Page

            $stat = "SELECT * FROM users WHERE Email='$sessionUser'";
            $result2 =$conn->query($stat);

            $row2 =$result2->fetch_assoc();
?>
            <div class="container mt-5 mb-3">

                <h2 class="mb-4 text-capitalize"> Welcome back، <?php echo $row2['UserName'] ?> 👋  </h2>
                <hr style="margin-bottom:30px">
                <div class="row grid">

                

<?php 

                    //This IS user define function in function.php use to select data from table 
                    //The full information of this function in function.php

                    $companuResult = getLatest( '*' ,'company' , 'ID' , 4);

                    if($companuResult->num_rows >0){

                        while($company = $companuResult ->fetch_assoc()){

                            echo "<div class='col-sm-6 col-md-3'>";
                                    echo '<div class="card mb-5 pt-3 pb-3 item-box Studenthome" >';
                                            

                                            echo'<div>'; 
                                        
                                                if(empty($company["Image"])){

                                                    echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads/image/default.jpg" class="card-img-top" alt="...">';

                                                }else{
                                                    echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads\image\\'.$company["Image"].'" class="card-img-top" alt="...">';
                                                }

                                            echo'</div>';

                                            echo '<div class="card-body">

                                                <h4 class="card-title text-center"> <a class="text-decoration-none" href="companyProfile?compId='.$company["ID"].'">'.$company["UserName"].'</a> </h3>
                                                <h6 class="text-center mb-4" style="color:#000000b3;">'.$company["Address"].'</h6>

                                                <p class="card-text text-center mb-4">'.$company["Description"].'</p>
                                                <a href="?page=request_training&compId='.$company["ID"].'" class="btn btn-primary d-block">Training Request</a>

                                                
                                            </div>
                                    </div>';    
                            echo "</div>";
                        }

                    }else{
                        echo "<div class='alert alert-secondary'> there Is No Companies To Show </div>";
                    }
?>
        </div>
            </div>

<?php

        }elseif($page == "company"){


            // $stat = "SELECT * FROM users WHERE Email='$sessionUser'";
            // $result2 =$conn->query($stat);

            //     $row2 =$result2->fetch_assoc();
?>
            <div class="container mt-5 mb-3">
                <h2 class="mb-4"> Welcome 👋 ! Choose Your Company </h2>
                <hr style="margin-bottom:30px">
                <div class="row grid">

<?php 

                    // Use to select All companies from data base
                    $sql    = "SELECT * FROM company";
                    $result = $conn->query($sql);

                    if($result->num_rows >0){

                        while($rows = $result->fetch_assoc()){

                            echo "<div class='col-sm-6 col-md-3'>";
                                    echo '<div class="card mb-5 pt-3 pb-3 item-box Studenthome" >';
                                            
                                            echo'<div>'; 
                                                    
                                                if(empty($rows['Image'])){

                                                    echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads/image/default.jpg" class="card-img-top" alt="...">';

                                                }else{

                                                    echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads\image\\'.$rows["Image"].'" class="card-img-top" alt="...">';
                                                }

                                            echo'</div>';

                                            echo '<div class="card-body">

                                                <h4 class="card-title text-center"> <a class="text-decoration-none" href="companyProfile?compId='.$rows["ID"].'">'.$rows["UserName"].'</a> </h3>
                                                <h6 class="text-center mb-4" style="color:#000000b3;">'.$rows["Address"].'</h6>

                                                <p class="card-text text-center mb-4">'.$rows["Description"].'</p>
                                                
                                                <a href="student.php?page=request_training&compId='.$rows["ID"].'" class="btn btn-primary d-block">Training Request</a>

                                                
                                            </div>

                                    </div>';    
                            echo "</div>";
                        }

                    }else{
                        echo "<div class='alert alert-secondary'> There Is No Companies To Show </div>";
                    }
?>

            </div>
                </div>




<?php

        }elseif($page == "request_training"){

            if(isset($_GET['compId']) && is_numeric($_GET['compId'])){

                $compid = intval($_GET['compId']);
            }


            $sql = "SELECT * FROM users WHERE Email = '$sessionUser' AND (Status = 1 OR Status = 2)";
            $resultS = $conn->query($sql);

            if($resultS->num_rows >0){

                    echo "<div class='container mt-3'>";
                        $theMsg = "<div class ='alert alert-danger'>You can not apply to more than one company at the same time</div> ";
                        redirectHome($theMsg,'back');
                    echo "</div>";
                    
            }else{

                $result_cv = getRecord('*','cv','Email',$sessionUser);

                if($result_cv->num_rows>0){

                    $insert = "UPDATE cv SET Comp_ID ='$compid'";

                    $conn->query($insert);

                    $update = "UPDATE users SET Status = 1 WHERE  Email = '$sessionUser'";
                    $conn->query($update);

                    echo "<div class='container mt-3'>";

                        $theMsg = "<div class='alert alert-success mt-3' role='alert'> The training request has been submitted successfully </div>";
                        redirectHome($theMsg,'back');

                    echo "</div>";

                }else{

                    echo "<div class='container mt-3'>";
                        $theMsg = "<div class ='alert alert-danger'>You cannot apply for a training application without filling out a CV</div> ";
                        echo  $theMsg;
                        echo "<div class='alert alert-info'>You Will Be Redirected to CV page After 3 Seconds.</div>";
                        header("refresh:3;url=CV.php");
                        exit;
                    echo "</div>";

                }

                
            }
            

        }elseif($page == "profile"){

            //open My Profile based on session not id beacuse the id should not appere in link 
            //THIS if to prevent any one to go this page direct use link
            //

            $sessionUser = $_SESSION['email'];
            $Stat        = "SELECT * FROM users WHERE Email = '$sessionUser'";
            $results1    = $conn->query($Stat);
            $rows1       = $results1->fetch_assoc();
?>
        


            <div class="container">
                <div class="S_profile mt-5">


                    <h1 class="mb-4" style="color:#000000b3;"> My Profile </h1>

                    <div class="mb-4">

                        <div class="panel-body bg-white p-3">

                            <div style="padding: 10px 15px; font-size:18px; text-shadow: 0px 0px 1px black;"> My Information </div>


                            <ul class="list-unstyled">
                                <li>
                                    <i class="fa-solid fa-file-signature"></i>
                                    <span> Name          </span>  : <?php echo $rows1['Name'] ?>
                                </li> 
                                
                                <li>
                                    <i class="fa-regular fa-envelope"></i>
                                    <span> Email         </span>  : <?php echo $rows1['Email']    ?> 
                                </li> 
                                
                                <li>
                                    <i class="fa-solid fa-tag"></i>
                                    <span> specialty  </span>  : <?php echo $rows1['Specialization']    ?> 
                                </li>

                                <li>
                                    <i class="fa-solid fa-user"></i>
                                    <span> User Name     </span>  : <?php echo $rows1['UserName']     ?>
                                </li>  
                                <li>
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <span> Register Date </span>  : <?php echo $rows1['Date']     ?>
                                </li>  
                                <li>
                                    <i class="fa-solid fa-square-phone"></i>
                                    <span> Phone         </span>  : <?php echo $rows1['Phone']    ?>                                   
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>

<?php
        }elseif($page == "EditProfile"){

            $result = getRecord('*','users','Email',$sessionUser);

            if($result->num_rows >0){

                $row =$result->fetch_assoc();
?>

                <div class="container mt-5">

                    <form class="form-horizontal" method="post" action="?page=Update">

                        <input type="hidden" name="userid" value="<?php echo $row['ID']?>">

                        <!-- Start UserName Field -->

                            <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Full Name</label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row['Name'] ?>" name="name" class="form-control" autocomplete="off" required>
                                </div>
                            </div>

                        <!-- End UserName Field -->


                        <!-- Start password Field -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-md-4">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
                                    <input type="password" name="newpassword" class="form-control" autucomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">
                                </div>
                            </div>

                        <!-- End password Field -->


                        <!-- Start Email Field -->

                            <div class="form-group  row mb-3">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="email"  value="<?php echo $row['Email'] ?>" name="email" class="form-control" required disabled>
                                </div>
                            </div>

                        <!-- End Email Field -->


                        <!-- Start FullName Field -->
                            <div class="form-group row mb-3">
                                <label class="col-md-2 cont  rol-label">User Name</label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row['UserName'] ?>"  name="username" class="form-control" required>
                                </div>
                            </div>

                        <!-- End FullNmae Field -->

                        <!-- Start Phone Field -->
                        <div class="form-group row mb-3">
                                <label class="col-md-2 cont  rol-label"> Phone </label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row['Phone'] ?>"  name="phone" class="form-control" required>
                                </div>
                            </div>

                        <!-- End phone Field -->

                        <!-- Start Submit Field -->
                                <div class="form-group">
                                    <div class="col-md-4 offset-md-2">
                                        <input type="submit" value="Save" class="btn btn-primary btn-md" >
                                    </div>
                                </div>

                        <!-- End Submit Field -->

                    </form>
                </div>

<?php
            }else{
                echo "<div class='container'>";
                    $theMsg = "<div class ='alert alert-danger'>Error, Theres No Such ID</div> ";
                    echo $theMsg;
                    redirectHome($theMsg);
                echo "</div>";    

            }


        }elseif($page == "Update"){

            echo "<div class='container'>";

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $ID          = test_input($_POST['userid']);
                    $name        = test_input($_POST['name']);
                    $user        = test_input($_POST['username']);
                    $phone       = test_input($_POST['phone']);

                    $oldpassword = test_input($_POST['oldpassword']);
                    $newpassword = test_input($_POST['newpassword']);

                    //Password Track
                    $pass = "";

                    if(empty($newpassword)){
                        $pass = $oldpassword;

                    }else{
                        $pass = sha1($newpassword);
                    } 


                    $FormErrors = array();

                    if(empty($name)){
                        $FormErrors[] ='Full Name Cant Be Empty ';
                    }

                    if(empty($user)){
                        $FormErrors[] ='UserName Cant Be Empty ';
                    }

                    if(empty($phone)){
                        $FormErrors[] ='Phone Cant Be Empty ';
                    }


                    //Loop Into Errors Array And Echo It

                    foreach($FormErrors as $errors){
                        echo '<div class="alert alert-danger" role="alert">' .$errors.'</div>';
                    }

                    //Check If There's No Error proceed The Update Opreation

                    if(empty($FormErrors)){

                        //update date
                        $stat ="UPDATE users SET Name='$name' , Password ='$pass', UserName= '$user', Phone= '$phone' WHERE ID='$ID' ";
                        $result = $conn->query($stat);
                        $theMsg = "<div class='alert alert-success mt-3' role='alert'> Record Update </div>";
                        redirectHome($theMsg,'back');
                
                    }  

                }else{
                    $theMsg = "<div class='alert alert-danger mt-3'> Sorry, you cant browser This Page Directly</div>";
                    redirectHome($theMsg);
                }

            echo "</div>";

        }elseif($page == "estimates"){

            $result6 = getRecord('*','users','Email',$sessionUser);

            if($result6->num_rows >0){
                $row6 = $result6->fetch_assoc();
                $studId = $row6['ID'];
?>
                <div class="container bg-white mt-4 p-4">
                    <h2 class="mb-4 text-capitalize" style="color: #000000b3;"><?php echo $row6['Name'] ?></h2>
                    <h5 class="mb-5" style="color: #000000b3;">Field Training Completed</h5>
<?php
                    $stat7 ="SELECT
                                evaluation.*,
                                company.CompanyName
                            FROM 
                                evaluation
                            INNER JOIN
                                company
                            ON
                                company.ID = evaluation.Comp_ID
                            WHERE
                                Stud_ID='$studId'";
                    
                    $result7 =$conn->query($stat7);

                    if($result7->num_rows >0){
                        $row7 = $result7->fetch_assoc();

?>
                        <div class="table-responsive">
                            <table class="table">

                                <hr class="m-0">
                                <tr>
                                    <th>Company Name</th>
                                    <th>Training Summary</th>
                                    <th>Evaluation</th>
                                </tr>


                                <tr>
                                    <td><?php echo $row7['CompanyName'] ?></td>
                                    <td><?php echo $row7['summary']     ?></td>
                                    <td><?php echo $row7['mark']        ?> /100</td>
                                </tr>
                            </table>
                        </div>    
                </div>
    
<?php
                    }else{
                        echo "<div class='alert alert-secondary'> There Is No Estimates To Show </div>";
                    }

            }else{

                echo "<div class='container'>";
                    $theMsg = "<div class ='alert alert-danger'>Error, Theres No Such ID</div> ";
                    redirectHome($theMsg);
                echo "</div>";
            }
            
        }
?>

<?php
        }else{
            header('Location:index.php');
            exit();
        }
    

    include "./templete/footer.php";

    ob_end_flush();
?>