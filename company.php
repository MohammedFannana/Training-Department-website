<?php
    session_start();
    include "./init.php";

    if(isset($_SESSION['c_email'])){
        include "./templete/NavbarC.php";

        $sessionEmail = $_SESSION['c_email'];

        // use This Way to divide page into many internal page
        $page ='';

        //to collect var page from link
        if(isset($_GET['page'])){
            $page =$_GET['page'];

        }else{
            $page = 'Home';
        }


        $result = getRecord('*','company','Email',$sessionEmail);

        $row =$result->fetch_assoc();

                $compid = $row['ID'];

        if($page == "Home"){
            //Start Home Page

            //The full information of this function in function.php

            if($result->num_rows >0){

?>

                <div class="container">
                    <div class="row S_profile mt-5 mb-5">

                        <h1 class="mb-5 p-0 " style="color:#000000b3;"> Company Information  </h1>

                        <div class="panel-body row bg-white p-0 pt-4">

                            <div class="col-md-9">

                                <ul class="list-unstyled">
                                    <li>
                                        <i class="fa-solid fa-file-signature"></i>
                                        <span> Company Name  </span>  : <?php echo $row['CompanyName'] ?>
                                    </li> 
                                    
                                    <li>
                                        <i class="fa-regular fa-envelope"></i>
                                        <span> Email         </span>  : <?php echo $row['Email']       ?> 
                                    </li>  
                                    <li>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span> Address      </span>  : <?php echo $row['Address']      ?>
                                    </li>  
                                    <li>
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span> Register Date </span>  : <?php echo $row['Date']        ?>
                                    </li>  
                                    
                                    <li>
                                        <i class="fa-solid fa-square-phone"></i>
                                        <span> Phone         </span>  : <?php echo $row['Phone']        ?>                                   
                                    </li>

                                    <li>
                                        <i class="fa-solid fa-file-signature"></i>
                                        <span> Description   </span>  : <?php echo $row['Description']  ?>                                   
                                    </li>

                                </ul>

                            </div>
                            
                            <div class="col-md-3">
                                <?php 

                                    if(empty($row["Image"])){

                                        echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads/image/default.jpg" class="card-img-top" alt="..." width="200px">';

                                    }else{
                                        echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads\image\\'.$row["Image"].'" class="card-img-top" alt="...">';
                                    }

                                ?>      
                            </div>

                        </div>

                    </div>
                </div>
<?php
            }else{
                echo "<div class='alert alert-secondary'> There Is No Companies To Show </div>";
            }
        

        }elseif($page == "AdvancedStudents"){
            // All students applying for training in the company
?>
            <div class="container">
                <div class="row offer_student mt-5 mb-5">
<?php                    

                    $stat3 = "SELECT
                                cv.*,
                                users.Status
                            FROM 
                                cv
                            INNER JOIN
                                users
                            ON
                                users.ID = cv.Stud_ID
                            WHERE
                                Comp_ID='$compid' AND Status = 1 ";
                    
                    $result3 =$conn->query($stat3);

                    if($result3->num_rows >0){

                                echo '<h3 class="mb-5" style="color:#000000b3; padding-left:12px;"> Students Applying for Training  </h3>';

                                while($row3 =$result3->fetch_assoc()){                                    
                                    
                                    //this session to store student id to show special  cv in next page show cv 
                                    
?>
                                    <form action="<?php echo htmlspecialchars('company.php?page=ShowCV') ?>" method="post">
                                        <ul class="list-unstyled p-0">

                                            <li class="bg-white p-3 pt-2 pb-2">
                                                <span class="text-capitalize"> <?php echo $row3['Name'] ?>  </span> 
                                                <input type="hidden" name="CV_ID" value="<?php  echo $row3['ID'] ?>">

                                                <input type="Submit"  class="btn btn-primary btn-md" value="Show CV"> 
                                                
                                            </li> 
                                            

                                        </ul>
                                    </form>    
                                        
<?php
                                }



                    }else{
                        echo "<div class='alert alert-secondary'> There Is No Students Applying For Training To Show </div>";
                    }    
?>
            </div>
                </div>

<?php




        }elseif($page == "ShowCV"){

            echo "<div class='container'>";

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $cvId = test_input($_POST['CV_ID']);
                    
                    $resultCv = getRecord('*','cv','ID',$cvId);

                    $rowCv =$resultCv->fetch_assoc();

                        $studid = $rowCv['Stud_ID'];

                        $resultspecial = getRecord('Specialization','users','ID',$studid);

                        $row_special =$resultspecial->fetch_assoc();

?>


                    <div class="pt-4">


                        <form class="form-horizontal row" method="post" action="<?php echo htmlspecialchars('company.php?page=Trainning') ?>">

                            <input type="hidden" name="cvid"   value="<?php echo $rowCv['ID'] ?>">
                            <input type="hidden" name="userid" value="<?php echo $rowCv['Stud_ID'] ?>">



                            <!-- Start  Basic Informations section-->


                            <h4 class="pt-3 mb-4">Basic Informations</h4>

                            <!-- Start FullName Field -->

                                <div class="form-group col-md-6  mb-3">
                                        <label class="control-label mb-2">Name</label>
                                        <div class="col-md-10">
                                            <input type="text" value="<?php echo $rowCv['Name']?>"  class="form-control"  disabled>
                                        </div>
                                </div>

                            <!-- End Full Name Field -->

                            <!-- Start Email Field -->

                                <div class="form-group col-md-6  mb-3" >
                                        <label class="control-label mb-2">Email</label>
                                        <div class="col-md-10">
                                            <input type="text" value="<?php echo $rowCv['Email']?>" class="form-control"  disabled>
                                        </div>
                                </div>

                
                            <!-- End Email Field -->

                            <!-- Start Specialization Field -->

                            <div class="form-group col-md-6  mb-3" >
                                        <label class="control-label mb-2">specialty</label>
                                        <div class="col-md-10">
                                            <input type="text" value="<?php echo $row_special['Specialization']?>" class="form-control"  disabled>
                                        </div>
                                </div>

                
                            <!-- End Specialization Field -->


                            <!-- Start Phone Field -->
                            
                                <div class="form-group col-md-6  mb-3" >
                                        <label class="control-label mb-2">Phone</label>
                                        <div class="col-md-10">
                                            <input type="text" value="<?php echo $rowCv['Phone']?>"  class="form-control"  disabled>
                                        </div>
                                </div>

                            <!-- End phone Field -->

                            <!-- Start Address Field -->
                        
                                <div class="form-group col-md-6  mb-3">
                                        <label class="control-label mb-2">Address</label>
                                        <div class="col-md-10">
                                            <input type="text"  class="form-control" value="<?php echo $rowCv['Address']?>" disabled>
                                        </div>
                                </div>


                            <!-- End Address Field -->

    


                            <!-- Start  work Experience section -->

                    

                                <h4 class="pt-2 mb-4 mt-4">Work experience</h4>

                            
                                <!-- Start JobTitle Field -->

                                    <div class="form-group col-md-6  mb-3">
                                        <label class="control-label mb-2">Jop title</label>
                                        <div class="col-md-10">
                                            <input type="text"  class="form-control" value="<?php echo $rowCv['Jop']?>" disabled>
                                        </div>
                                    </div>

                                <!-- End Full Name Field -->

                                <!-- Start Email Field -->

                                <div class="form-group col-md-6 mb-3">

                                        <label class="control-label mb-2">Company Name</label>
                                        <div class="col-md-10">
                                            <?php
                                                $result5 = getRecord('CompanyName','company','Email',$sessionEmail);
                                                $row5    =$result5->fetch_assoc();
                                            ?>
                                            <input type="text"  value="<?php echo $row5['CompanyName']?>" class="form-control" disabled>
                                        </div>
                                </div>


                                <!-- End Email Field -->

                                <!-- Start textarea Field -->

                                    <div class="form-group col-md-11 mb-3">

                                        <label class="control-label mb-3"> Other Information</label>
                                        <textarea name="experience" class="form-control" style="height:140px" disabled> <?php echo $rowCv['experience']?> </textarea>

                                    </div>

                                <!-- End textarea Field -->


                                <!-- Start Qualifications Section -->

                                <h4 class="pt-2 mb-4 mt-5">Qualifications</h4>

                                <!-- Start textarea Field -->

                                    <div class="form-group col-md-11 mb-3" >

                                        <textarea name="qualification" class="form-control"   style="height:180px" disabled> <?php echo $rowCv['qualification']?> </textarea>

                                    </div>

                                <!-- End textarea Field -->


                                <!-- Start Education Section -->

                                <h4 class="pt-2 mb-4 mt-4" >Education</h4>

                                <!-- Start JobTitle Field -->

                                <div class="form-group col-md-6 mb-3" >

                                        <label class="control-label mb-2">Course Name</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" value="<?php echo $rowCv['course']?>" disabled>
                                        </div>
                                </div>

                                <!-- End Full Name Field -->

                                <!-- Start Email Field -->


                                <div class="form-group col-md-6 mb-3">

                                        <label class="control-label mb-2">Institution Name</label>
                                        <div class="col-md-10">
                                            <input type="text"  class="form-control" value="<?php echo $rowCv['Institution_Name']?>" disabled>
                                        </div>
                                </div>


                                <!-- End Email Field -->

                                <!-- Start textarea Field -->

                                    <div class="form-group col-md-11 mb-3">

                                        <label class="control-label mb-3"> Other Information</label>
                                        <textarea name="Institution" class="form-control" style="height:140px" disabled> <?php echo $rowCv['Education']?> </textarea>
                                    </div>

                                <!-- End textarea Field -->


                                <!-- Start Skills Section -->

                                <h4 class="pt-2 mb-4 mt-4">Skills</h4>

                                <!-- Start JobTitle Field -->

                                <div class="form-group col-md-6 mb-3" >

                                        <label class="control-label mb-2">Language</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control"  disabled> <?php echo $rowCv['languages']?> </textarea>
                                        </div>
                                </div>

                                <!-- End Full Name Field -->

                                <!-- Start Email Field -->


                                <div class="form-group col-md-6 mb-3">

                                        <label class="control-label mb-2">Programming languages</label>
                                        <div class="col-md-10">
                                            <textarea  class="form-control"  disabled> <?php echo $rowCv['Prog_languages']?> </textarea>
                                        </div>
                                </div>


                                <!-- End Email Field -->

                                <!-- Start textarea Field -->

                                    <div class="form-group col-md-11 mb-3">

                                        <label class="control-label mb-3"> Other Skills </label>
                                        <textarea name="skill" class="form-control"  style="height:140px" disabled> <?php echo $rowCv['Skills']?> </textarea>

                                    </div>

                                <!-- End textarea Field -->



                                <!-- Start Interests Section -->

                                <h4 class="pt-2 mb-4 mt-4">Interests</h4>

                                <!-- Start textarea Field -->

                                <div class="form-group col-md-11 mb-3" >

                                    <textarea name="Interests" class="form-control "  style="height:140px" disabled> <?php echo $rowCv['Interests']?> </textarea>

                                </div>

                                <!-- End textarea Field -->  

                                <!-- <input type="submit" name="y" class="btn btn-success  form-control  mb-3 "  style="width:140px" value="y"> -->

                                <div class="form-group mt-3 mb-4">
                                    <div class="col-md-4">

                                        <input type="submit" name="accept"  value="Accept Training"   class="btn btn-success btn-md" style="width:140px">
                                        <input type="submit" name="refusal" value="Refusal Training" class="btn btn-danger btn-md" style="width:140px">

                                    </div>
                                </div>

                        </form>

                    </div>

<?php           
                }else{
                    $theMsg = "<div class='alert alert-danger mt-3'> Sorry, you cant browser This Page Directly</div>";
                    redirectHome($theMsg);
                }

            echo "</div>";
            
            
        }elseif($page == "Trainning"){

            $cv_id   = $_POST['cvid']   ;
            $stud_id = $_POST['userid'] ;

            if($_SERVER['REQUEST_METHOD'] == 'POST'){


                if(isset($_POST['accept'])){


                    echo "<div class='container'>";
                    //update date
                        $stat ="UPDATE users SET Status= '2' WHERE ID='$stud_id'";
                        $result = $conn->query($stat);

                        
                        $theMsg = "<div class='alert alert-success mt-3' role='alert'> Student training approved </div>";
                        echo  $theMsg;
                        echo "<div class='alert alert-info'>You Will Be Redirected to previes After 3 Seconds.</div>";
                        header("refresh:3;url=company.php?page=AdvancedStudents");
                        exit;

                    echo "</div>";    

                }elseif(isset($_POST['refusal'])){

                    echo "<div class='container'>";

                        //update date
                        $stat ="UPDATE users SET Status= '-1' WHERE ID='$stud_id'";
                        $result = $conn->query($stat);
                        
                        $theMsg = "<div class='alert alert-success mt-3' role='alert'> Student training refusaled </div>";
                        echo  $theMsg;
                        echo "<div class='alert alert-info'>You Will Be Redirected to previes After 3 Seconds.</div>";
                        header("refresh:3;url=company.php?page=AdvancedStudents");
                        exit;

                    echo "</div>"; 

                }

            }else{
                $theMsg = "<div class='alert alert-danger mt-3'> Sorry, you cant browser This Page Directly</div>";
                redirectHome($theMsg);
            }



        }elseif($page == "StudentApprovedTraining"){
            //All students who have been approved to train in the company for training in the 
            
?>
            <div class="container mt-5">
                <!-- <div class="accordion" id="accordionExample"> -->
<?php                    

                    $stat4 ="SELECT
                                cv.*,
                                users.Status
                            FROM 
                                cv
                            INNER JOIN
                                users
                            ON
                                users.ID = cv.Stud_ID
                            WHERE
                                Comp_ID='$compid' AND Status = 2 
                            ORDER BY
                                ID DESC ";

                    $result4 =$conn->query($stat4);

                    if($result4->num_rows >0){

                        echo '<h3 class="mb-5" style="color:#000000b3; padding-left:12px;"> Approved Students For Training  </h3>';

                            while($row4 =$result4->fetch_assoc()){                                    
                    
                                //This is to select data summary and old mark 
                                $sid = $row4['Stud_ID'];
                                $sql = "SELECT * FROM evaluation WHERE Stud_ID = '$sid'";
                                $result = $conn->query($sql);
?>

                                <p class="p-3 pt-2 pb-2 offer_Evaluation bg-white ">
                                    <span> <?php echo $row4['Name'] ?>  </span>

                                    <span style="font-size:17px">
                                        <?php
                                            if($result->num_rows >0){
                                                echo "<span class='text-success'> Evaluated Done </span>";
                                            }
                                        ?>
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $row4['ID']?>" aria-expanded="false" aria-controls="collapseExample<?php echo $row4['ID']?>" style="margin-left:15px;">
                                            Evaluation
                                        </button>
                                    </span>    
                                </p>
                                <div class="collapse mb-3" id="collapseExample<?php echo $row4['ID']?>">
                                    <div class="card card-body">

                                        <?php
                                            
                                            if($result->num_rows >0){
                                                $row5 = $result->fetch_assoc();
                                        ?>
                                                <form action="?page=Evaluation" method="post">

                                                    <input type="hidden" name="stud_id" value="<?php echo $row4['Stud_ID'] ?>">
                                                    <input type="hidden" name="comp_id" value="<?php echo $row4['Comp_ID'] ?>">

                                                    <!-- Start textarea Field -->

                                                    <div class="form-group  mb-3">

                                                        <label class="control-label mb-3"> Training summary </label>
                                                        <textarea name="training_summary" class="form-control"  style="height:140px" disabled> <?php echo $row5['summary'] ?> </textarea>


                                                    </div>

                                                    <!-- End textarea Field -->

                                                    <!-- Start Email Field -->


                                                    <div class="form-group col-md-6 mb-3">

                                                        <label class="control-label mb-2">Evaluation</label>
                                                        <div class="col-md-10">
                                                            <input type="text" min="0" max="100"  value="<?php echo $row5['mark'] ?> / 100" class="form-control" name="evaluation"  disabled>
                                                        </div>
                                                    </div>


                                                    <!-- End Email Field -->


                                                </form>
                                        <?php
                                            }else{
                                        ?>        
                                                <form action="?page=Evaluation" method="post">

                                                <input type="hidden" name="stud_id" value="<?php echo $row4['Stud_ID'] ?>">
                                                <input type="hidden" name="comp_id" value="<?php echo $row4['Comp_ID'] ?>">

                                                <!-- Start textarea Field -->

                                                <div class="form-group  mb-3">

                                                    <label class="control-label mb-3"> Training summary </label>
                                                    <textarea name="training_summary" class="form-control" placeholder="Please, Fill in the training summary" style="height:140px" required></textarea>


                                                </div>

                                                <!-- End textarea Field -->

                                                <!-- Start Email Field -->


                                                <div class="form-group col-md-6 mb-3">

                                                    <label class="control-label mb-2">Evaluation</label>
                                                    <div class="col-md-10">
                                                        <input type="text" min="0" max="100" placeholder="Evaluation (between 0 and 100)"  class="form-control" name="evaluation"  required>
                                                    </div>
                                                </div>


                                                <!-- End Email Field -->


                                                <div class="form-group mt-3 mb-4">
                                                    <div class="col-md-4">

                                                        <input type="submit" value="Save"   class="btn btn-primary btn-md" style="width:140px">

                                                    </div>
                                                </div>


                                            </form>
                                        <?php    
                                            }
                                        ?>
                                        
                                    </div>
                                </div>
<?php
                            }


                    }else{
                        echo "<div class='alert alert-secondary'> There Is No Approved Students For Training To Show </div>";
                    }    
?>
                    
                
                <!-- </div> -->
            </div>    

<?php
        }elseif($page == "Evaluation"){
            echo "<div class='container'>";

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $StudID                  = test_input($_POST['stud_id'])          ;
                    $Comp_ID                 = test_input($_POST['comp_id'])          ;
                    $training_summary        = test_input($_POST['training_summary']) ;
                    $mark                    = test_input($_POST['evaluation'])       ;


                    $FormErrors = array();

                    if(empty($training_summary)){
                        $FormErrors[] ='Training Summary Cant Be Empty ';
                    }

        
                    if(empty($mark)){
                        $FormErrors[] ='Evaluation Cant Be Empty ';
                    }

                    if(empty($mark)){
                        $FormErrors[] ='Evaluation Cant Be Empty ';
                    }

                    if($mark >100 || $mark < 0){
                        $FormErrors[] ='Evaluation Must Be between <strong>0</strong> and <strong>100</strong> ';
                    }



                    //Loop Into Errors Array And Echo It

                    foreach($FormErrors as $errors){
                        echo '<div class="alert alert-danger" role="alert">' .$errors.'</div>';
                    }

                    //Check If There's No Error proceed The Update Opreation

                    if(empty($FormErrors)){

                            $date =date('m/d/Y');
                            $statSign = $conn->prepare("INSERT INTO evaluation(Stud_ID,Comp_ID,summary,mark,Date)
                                                                VALUES(    ?  ,    ?  ,   ?   , ?  ,STR_TO_DATE('$date','%m/%d/%Y'))");

                            $statSign->bind_param("ssss",$S_ID,$C_ID,$T_summary,$T_mark);

                            $S_ID            = $StudID            ;
                            $C_ID            = $Comp_ID           ;
                            $T_summary       = $training_summary  ;
                            $T_mark          = $mark              ;


                            $statSign->execute();

                            $theMsg = "<div class='alert alert-success mt-3' role='alert'> Record Update </div>";
                            redirectHome($theMsg,'back');
                    }  

                }else{
                    $theMsg = "<div class='alert alert-danger mt-3'> Sorry, you cant browser This Page Directly</div>";
                    redirectHome($theMsg);
                }

            echo "</div>";


    


        }elseif($page == "EditProfile"){

            $result1 = getRecord('*','company','Email',$sessionEmail);

            if($result1->num_rows >0){

                $row1 =$result1->fetch_assoc();
?>

                <div class="container mt-5">

                    <form class="form-horizontal" method="post" action="?page=Update">

                        <input type="hidden" name="compid" value="<?php echo $row1['ID']?>">

                        <!-- Start Name Field -->

                            <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Company Name</label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row1['CompanyName'] ?>" name="name" class="form-control" autocomplete="off" required>
                                </div>
                            </div>

                        <!-- End Name Field -->


                        <!-- Start password Field -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-md-4">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row1['Password'] ?>">
                                    <input type="password" name="newpassword" class="form-control" autucomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">
                                </div>
                            </div>

                        <!-- End password Field -->


                        <!-- Start Email Field -->

                            <div class="form-group  row mb-3">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="email"  value="<?php echo $row1['Email'] ?>" name="email" class="form-control" required disabled>
                                </div>
                            </div>

                        <!-- End Email Field -->


                        <!-- Start FullName Field -->
                            <div class="form-group row mb-3">
                                <label class="col-md-2 cont  rol-label">User Name</label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row1['UserName'] ?>"  name="username" class="form-control" required>
                                </div>
                            </div>

                        <!-- End FullNmae Field -->

                        <!-- Start Phone Field -->
                        <div class="form-group row mb-3">
                                <label class="col-md-2 cont  rol-label"> Phone </label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row1['Phone'] ?>"  name="phone" class="form-control" required>
                                </div>
                            </div>

                        <!-- End phone Field -->

                        <!-- Start Phone Field -->
                            <div class="form-group row mb-3">
                                <label class="col-md-2 cont  rol-label"> Address </label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row1['Address'] ?>"  name="address" class="form-control" required>
                                </div>
                            </div>

                        <!-- End phone Field -->

                        <!-- Start Phone Field -->

                        <div class="form-group row mb-3">
                                <label class="col-md-2 cont  rol-label"> Description </label>
                                <div class="col-md-4">
                                    <input type="text" value="<?php echo $row1['Description'] ?>"  name="description" class="form-control" required>
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
                    redirectHome($theMsg);
                echo "</div>";    

            }



        }elseif($page == "Update"){

            echo "<div class='container'>";

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $ID          = test_input($_POST['compid'])      ;
                    $C_name      = test_input($_POST['name'])        ;
                    $user        = test_input($_POST['username'])    ;
                    $phone       = test_input($_POST['phone'])       ;
                    $C_address   = test_input($_POST['address'])     ;
                    $desc        = test_input($_POST['description']) ;




                    $oldpassword = test_input($_POST['oldpassword']) ;
                    $newpassword = test_input($_POST['newpassword']) ;

                    //Password Track
                    $pass = "";

                    if(empty($newpassword)){
                        $pass = $oldpassword;

                    }else{
                        $pass = sha1($newpassword);
                    } 


                    $FormErrors = array();

                    if(empty($C_name)){
                        $FormErrors[] ='Company Name Cant Be Empty ';
                    }

        
                    if(empty($user)){
                        $FormErrors[] ='UserName Cant Be Empty ';
                    }

                    if(empty($phone)){
                        $FormErrors[] ='Phone Cant Be Empty ';
                    }

                    if(empty($C_address)){
                        $FormErrors[] ='Address Cant Be Empty ';
                    }

                    if(empty($desc)){
                        $FormErrors[] ='Description Cant Be Empty ';
                    }


                    //Loop Into Errors Array And Echo It

                    foreach($FormErrors as $errors){
                        echo '<div class="alert alert-danger" role="alert">' .$errors.'</div>';
                    }

                    //Check If There's No Error proceed The Update Opreation

                    if(empty($FormErrors)){

                                //update date
                                $stat ="UPDATE company SET CompanyName='$C_name' , Password ='$pass', UserName= '$user', Phone= '$phone', Address= '$C_address', Description= '$desc' WHERE ID='$ID' ";
                                $conn->query($stat);
                                $theMsg = "<div class='alert alert-success mt-3' role='alert'> Record Update </div>";
                                redirectHome($theMsg,'back');
                    }  

                }else{
                    $theMsg = "<div class='alert alert-danger mt-3'> Sorry, you cant browser This Page Directly</div>";
                    redirectHome($theMsg);
                }

            echo "</div>";

        }
?>
<?php        
            
    }else{
        header('Location:index.php');
        exit();
    }
    

    include "./templete/footer.php";
?>