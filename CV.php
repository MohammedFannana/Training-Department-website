<?php
    session_start();
    ob_start();

    include "./init.php";
    include "./templete/NavbarS.php";

    if(isset($_SESSION['email'])){

        $sessionUser = $_SESSION['email'];

        // if(isset($_GET['compId']) && is_numeric($_GET['compId'])){

        //     $compid = intval($_GET['compId']);
        // }

        //use This Way to divide page into many internal page
        $page ='';

        //to collect var page from link
        if(isset($_GET['page'])){
            $page =$_GET['page'];

        }else{
            $page ='cv';
        }

        // $result = getRecord('*','users','Email',$sessionUser);


        // $row =$result->fetch_assoc();
        // $userid = $row['ID'];


        $resultCv = getRecord('*','cv','Email',$sessionUser);

        if($resultCv->num_rows>0){
            $row =$resultCv->fetch_assoc();

        }

        



        if($page == "cv"){
            //Start Basic Information Page

            //This Function select data from database
            // $result =$conn->query($stat);

            $result = getRecord('*','users','Email',$sessionUser);

            if($result->num_rows>0){
                $rows =$result->fetch_assoc();
    
            }

?>

                <div class="container mt-5">
                    <div class="row">

                        <div class="col-md-3 p-0">
                            <div id="list-example" class="list-group">

                                <ul class="list-unstyled">
                                    <li> <a class="list-group-item list-group-item-action" href="#list-item-1">Basic Information </a> </li>
                                    <li> <a class="list-group-item list-group-item-action" href="#list-item-2">Work experiences  </a> </li>
                                    <li> <a class="list-group-item list-group-item-action" href="#list-item-3">Qualifications    </a> </li>
                                    <li> <a class="list-group-item list-group-item-action" href="#list-item-4">Education         </a> </li>
                                    <li> <a class="list-group-item list-group-item-action" href="#list-item-5">Skills            </a> </li>
                                    <li> <a class="list-group-item list-group-item-action" href="#list-item-6">Interests         </a> </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-9 bg-white" style="padding-right:0px">
                            <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0" style="height:520px; overflow: auto;">

                                <!-- Start  Basic Informations section-->
                                    <h4 id="list-item-1" class="pt-3 mb-4">Basic Informations</h4>

                                <form class="form-horizontal row col-md-11" method="post" action="<?php echo htmlspecialchars('CV.php?page=Save_CV') ?>">

                                    <input type="hidden" name="userid" value="<?php echo $rows['ID']?>">

                                    <!-- Start FullName Field -->

                                        <div class="form-group col-md-6  mb-3">
                                                <label class="control-label mb-2">Full Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="<?php echo $rows['Name']?>" class="form-control" autocomplete="off" required disabled>
                                                    <input type="hidden" name="Sname" value="<?php echo $rows['Name']?>">
                                                </div>
                                        </div>

                                    <!-- End Full Name Field -->

                                    <!-- Start Email Field -->

                                        <div class="form-group col-md-6  mb-3" >
                                                <label class="control-label mb-2">Email</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="<?php echo $rows['Email'] ?>" class="form-control" required disabled>
                                                    <input type="hidden" name="email" value="<?php echo $rows['Email'] ?>">

                                                </div>
                                        </div>

                                        
                                    <!-- End Email Field -->

                                    <!-- Start Email Field -->

                                    <div class="form-group col-md-6  mb-3" >
                                                <label class="control-label mb-2">specialty</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="<?php echo $rows['Specialization'] ?>" class="form-control" required disabled>

                                                </div>
                                        </div>


                                    <!-- End Email Field -->


                                    <!-- Start Phone Field -->
                                    
                                        <div class="form-group col-md-6  mb-3" >
                                                <label class="control-label mb-2">Phone</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="<?php echo $rows['Phone'] ?>" name="Sphone" class="form-control"  required>
                                                </div>
                                        </div>

                                    <!-- End phone Field -->

                                    <!-- Start Address Field -->
                                
                                        <div class="form-group col-md-6  mb-3">
                                                <label class="control-label mb-2">Address</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="Saddress" value="<?php  if($resultCv->num_rows>0){ echo $row['Address'] ; } ?>" class="form-control"  required>
                                                </div>
                                        </div>


                                    <!-- End Address Field -->
<?php
        


                                // Start  work Experience section

                                    // $results = getRecord('*','company','ID',$compid);

                                    // $row1 =$results->fetch_assoc();
?>                                        

                                        <h4 class="pt-2 mb-4 mt-4" id="list-item-2">Work experience</h4>

                                    
                                        <!-- Start JobTitle Field -->

                                            <div class="form-group col-md-6  mb-3">
                                                <label class="control-label mb-2">Jop title</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="jop" value="<?php if($resultCv->num_rows>0){ echo $row['Jop'] ; } ?>" class="form-control"  required>
                                                </div>
                                            </div>

                                        <!-- End JobTitle Field -->

                                        

                                        <!-- Start textarea Field -->

                                            <div class="form-group col-md-12 mb-3">

                                                <label class="control-label mb-3"> Other Information</label>
                                        
                                                <textarea name="experience" class="form-control" placeholder="Optinal Details such as job ,achievement" style="height:180px"><?php if($resultCv->num_rows>0){ echo $row['experience'] ; }  ?></textarea>


                                            </div>

                                        <!-- End textarea Field -->


                                        <!-- Start Qualifications Section -->

                                        <h4 class="pt-2 mb-4 mt-5" id="list-item-3">Qualifications</h4>

                                        <!-- Start textarea Field -->

                                            <div class="form-group col-md-12 mb-3" >

                                                <textarea name="qualification" class="form-control" placeholder="Details such as job ,achievement" style="height:180px" required><?php if($resultCv->num_rows>0){ echo $row['qualification'] ; }  ?></textarea>

                                            </div>

                                        <!-- End textarea Field -->


                                        <!-- Start Education Section -->

                                        <h4 class="pt-2 mb-4 mt-4" id="list-item-4">Education</h4>

                                        <!-- Start JobTitle Field -->

                                        <div class="form-group col-md-6 mb-3" >

                                                <label class="control-label mb-2">Course Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="courseName"  class="form-control" value="<?php if($resultCv->num_rows>0){ echo $row['course']; }  ?>" required>
                                                </div>
                                        </div>

                                        <!-- End Full Name Field -->

                                        <!-- Start Email Field -->


                                        <div class="form-group col-md-6 mb-3">

                                                <label class="control-label mb-2">Institution Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="institutionName"  class="form-control" value="<?php if($resultCv->num_rows>0){ echo $row['Institution_Name']; } ?>" required>
                                                </div>
                                        </div>


                                        <!-- End Email Field -->

                                        <!-- Start textarea Field -->

                                            <div class="form-group col-md-12 mb-3">

                                                <label class="control-label mb-3"> Other Information</label>
                                                <textarea name="Institution" class="form-control" placeholder="Optional details such as job ,achievement" style="height:140px"><?php if($resultCv->num_rows>0){ echo $row['Education'] ; }  ?></textarea>
                                            </div>

                                        <!-- End textarea Field -->


                                        <!-- Start Skills Section -->

                                        <h4 class="pt-2 mb-4 mt-4" id="list-item-5">Skills</h4>

                                        <!-- Start JobTitle Field -->

                                        <div class="form-group col-md-6 mb-3" >

                                                <label class="control-label mb-2">Language</label>
                                                <div class="col-md-12">
                                                    <textarea  name="lang"  class="form-control" placeholder="Please enter the languages, Arabic, English, ...." required><?php  if($resultCv->num_rows>0){ echo  $row['languages']; }  ?></textarea>
                                                </div>
                                        </div>

                                        <!-- End Full Name Field -->

                                        <!-- Start Email Field -->


                                        <div class="form-group col-md-6 mb-3">

                                                <label class="control-label mb-2">Programming languages</label>
                                                <div class="col-md-12">
                                                    <textarea name="prog_lang" class="form-control" placeholder="Enter the programming languages you masters" required><?php if($resultCv->num_rows>0){ echo $row['Prog_languages'] ; }  ?></textarea>
                                                </div>
                                        </div>


                                        <!-- End Email Field -->

                                        <!-- Start textarea Field -->

                                            <div class="form-group col-md-12 mb-3">

                                                <label class="control-label mb-3"> Other Skills </label>
                                                <textarea name="skill" class="form-control" placeholder="Optional details about your skills" style="height:140px"><?php if($resultCv->num_rows>0){  echo $row['Skills'] ; } ?></textarea>

                                            </div>

                                        <!-- End textarea Field -->



                                        <!-- Start Interests Section -->

                                        <h4 id="list-item-6" class="pt-2 mb-4 mt-4">Interests</h4>

                                        <!-- Start textarea Field -->

                                        <div class="form-group col-md-12 mb-3" >

                                            <textarea name="Interests" class="form-control" placeholder="Interests" style="height:180px" required><?php if($resultCv->num_rows>0){ echo $row['Interests'] ; }  ?></textarea>

                                        </div>

                                        <!-- End textarea Field -->  
                                        
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <input class="btn btn-primary form-control  mb-3 " style="width:140px" type="submit"  value="Save"> 
                                            </div>
                                        </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                


<?php

        }elseif($page == "Save_CV"){
            // This page is deal with previous cv form (backend)

            echo "<div class='container'>";



                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    //colloct data from basic Information section
                    $UserID               = test_input($_POST['userid'])          ;
                    $Stud_name            = test_input($_POST['Sname'])           ;
                    $phone                = test_input($_POST['Sphone'])          ;
                    $S_email              = test_input($_POST['email'])           ;  
                    $Address              = test_input($_POST['Saddress'])        ;


                    //colloct data from Work experience section
                    // $Comp_ID              = test_input($_POST['companyid'])       ;
                    $Jop                  = test_input($_POST['jop'])             ;
                    $Experience           = test_input($_POST['experience'])      ; 

                    //colloct data from  Qualification section
                    $Qualification        = test_input($_POST['qualification'])   ;

                    //colloct data from  Education section
                    $Course_Name          = test_input($_POST['courseName']); 
                    $Institution_Name     = test_input($_POST['institutionName']) ; 
                    $Institution          = test_input($_POST['Institution'])     ;

                    //colloct data from  Skill section
                    $languages            = test_input($_POST['lang']); 
                    $prog_languages       = test_input($_POST['prog_lang']) ; 
                    $Skills               = test_input($_POST['skill'])     ;

                    //colloct data from  Interests section
                    $Interests            = test_input($_POST['Interests'])       ; 


                    $FormErrors = array();

                    // //check data from basic Information section

                    if(empty($Stud_name)){
                        $FormErrors[] ='Full Name Cant Be Empty ';
                    }

                    if(empty($phone)){
                        $FormErrors[] ='Phone Cant Be Empty ';
                    }

                    if(empty($Address)){
                        $FormErrors[] ='Address Cant Be Empty ';
                    }

                    //Check data from Work experience section


                    if(empty($Jop)){
                        $FormErrors[] ='Jop Title Cant Be Empty ';
                    }

                    //Check data from  Qualification section

                    if(empty($Qualification)){
                        $FormErrors[] ='Qualification Cant Be Empty ';
                    }

                    // //Check data from  Skills section


                    if(empty($languages)){
                        $FormErrors[] ='languages Cant Be Empty ';
                    }

                    if(empty($prog_languages)){
                        $FormErrors[] ='programming languages Cant Be Empty ';
                    }

                    //Check data from  Education section


                    if(empty($Course_Name)){
                        $FormErrors[] ='Course Name Cant Be Empty ';
                    }

                    if(empty($Institution_Name)){
                        $FormErrors[] ='Institution Name Cant Be Empty ';
                    }

                    //Check data from  Interests section

                    if(empty($Interests)){
                        $FormErrors[] ='Interests Cant Be Empty ';
                    }

        
                    // //Loop Into Errors Array And Echo It

                    foreach($FormErrors as $errors){
                        echo '<div class="alert alert-danger" role="alert">' .$errors.'</div>';
                    }

                    //Check If There's No Error proceed The Update Opreation

                    if(empty($FormErrors)){


                        $sql2 ="SELECT * FROM cv WHERE Email = '$S_email'";
                        $result2 = $conn->query($sql2);
                        
                        if($result2 ->num_rows >0){

                            $updateCV = "UPDATE cv SET Phone ='$phone',Address ='$Address',Jop ='$Jop',experience ='$Experience',qualification ='$Qualification',course ='$Course_Name',Institution_Name ='$Institution_Name',Education ='$Institution',languages ='$languages',Prog_languages ='$prog_languages',Skills ='$Skills',Interests ='$Interests' WHERE  Email = '$S_email'";
                            $conn->query($updateCV);

                            $theMsg = "<div class='alert alert-success mt-3' role='alert'> The Data has been Update successfully </div>";
                            redirectHome($theMsg,'back');
                        
                        }else{

                            //update date
                            $date =date('m/d/Y');
                            $statSign = $conn->prepare("INSERT INTO cv(Name,Email,Phone,Address,Jop,Stud_ID,experience,qualification,course,Institution_Name,Education,languages,Prog_languages,Skills,Interests,Date)
                                                                VALUES(?   ,    ?,    ?,    ?  , ?   ,    ?  ,     ?    ,     ?       ,  ?   ,      ?         ,    ?    ,?    ,?    ,?    ,    ?    ,STR_TO_DATE('$date','%m/%d/%Y'))");

                            $statSign->bind_param("sssssssssssssss",$S_name,$S_mail,$zphone,$zaddress,$zjop,$zuserid,$experience,$qualification,$zcourse,$institution_name,$education,$zlang,$zprog_lang,$zskills,$interests);

                            $S_name            = $Stud_name         ;
                            $S_mail            = $S_email           ;
                            $zphone            = $phone             ;
                            $zaddress          = $Address           ;

                            $zjop              = $Jop               ;
                            // $zcompid           = $Comp_ID        ;
                            $zuserid           = $UserID            ;
                            $experience        = $Experience        ;

                            $qualification     = $Qualification     ;
                            $zcourse           = $Course_Name       ;

                            $institution_name  = $Institution_Name  ;
                            $education         = $Institution       ;

                            $zlang             = $languages         ;
                            $zprog_lang        = $prog_languages    ;
                            $zskills           = $Skills            ;


                            $interests         = $Interests         ;




                            $statSign->execute();


                            // $stat ="UPDATE users SET Status= '1' WHERE ID='$UserID'";
                            // $result = $conn->query($stat);

                            $theMsg = "<div class='alert alert-success mt-3' role='alert'> The CV is Save successfully </div>";
                            redirectHome($theMsg,'back');

                        } 
                    }    

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
    ob_end_flush();

?>