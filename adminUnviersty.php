<?php
    session_start();
    ob_start();
    include "./init.php";

    if(isset($_SESSION['email'])){
        include "./templete/NavbarA.php";

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

                    //The full information of this function in function.php

?>

            <div class="container home-stats text-center">

                <div class="row mb-5" style="margin-top: 80px;">

                    <div class="col-md-4 mb-2">

                        <div class="stat st-member">
                            <i class="fa-solid fa-users"></i>
                            <div class="info">
                                Total Student
                                <span><a href="adminUnviersty.php?page=Student"> <?php echo countItem2('GroupID' , 'users' , '0') ?> </a> </span>
                            </div>
                        </div>

                    </div>          

                    <div class="col-md-4 mb-2">

                        <div class="stat st-pending">
                            <i class="fa-solid fa-user-plus"></i>
                            <div class="info">
                                Students Being Trained            
                                <span><a href="adminUnviersty.php?page=StudentsBeingTrained"> <?php echo countItem2('Status' , 'users' ,'2') ?> </a> </span>
                            </div>  
                            
                        </div>
                        
                    </div>

                    <div class="col-md-4 mb-2">

                        <div class="stat st-item">
                            <i class="fa-solid fa-building"></i>
                            <div class="info">
                                Total Comapny
                                <span><a href="?page=Company"> <?php echo countItem('ID' , 'company') ?> </a> </span>
                            </div>
                        </div>
                        
                    </div>


                </div>
            </div>


            <div class="container latest">
                <div class="row mb-4">

                    <!--Start The Latest Student -->
                    <div class="col-sm-6">

                        <?php $latestUsers = 3;  ?>
                        <div class="heading mb-2">
                            Latest <?php echo $latestUsers   ?>  Registerd Student
                        </div>

                        <div class="body bg-white p-2">

<?php
                            //getLatest function in function.php return array to extract the data use foreach (member no admin)
                            //The more information about this function in function.php
                            $theLatest2 = getLatest2('*' ,'users' ,'GroupID','0' ,'ID',$latestUsers);

                            if($theLatest2->num_rows >0){

                                echo "<ul class='list-unstyled letest-users'>";

                                    while($row= $theLatest2->fetch_assoc()){

                                        echo '<li class="p-3">';
                                        echo "<span class='text-capitalize'>";
                                            echo $row['Name'];
                                        echo "</span>";    

                                            echo "<span>";
                                                echo "<a href='adminUnviersty?page=StudentProfile&studid=".$row['ID']."' class='btn btn-primary  btn-sm'> Show Profile  </a>";
                                            echo "</span>";    

                                        echo '</li>';
                                    }

                                echo "</ul>";

                            }else{
                                echo "There's No Students To Show.";
                            }

?>
                        </div>
                    </div>
                    <!--End The Latest User -->


                    <!--Start The Latest company -->

                    <div class="col-sm-6">

                        <?php $latestItems = 3;?>

                        <div class="heading mb-2">
                            Latest <?php echo $latestItems?> Registerd Companies
                        </div>

                        <div class="body bg-white p-2">

<?php
                            //getLatest function in function .php return array to extract the data use foreach
                            $theLatest = getLatest('*' ,'company' ,'ID' ,$latestItems);

                            if($theLatest->num_rows >0){

                                echo "<ul class='list-unstyled letest-company'>";

                                    while($rows = $theLatest->fetch_assoc()){
                                        echo '<li class="p-3">';
                                            echo "<span class='text-capitalize'>";
                                                echo $rows['CompanyName'];
                                            echo "</span>";

                                            echo "<span>";
                                                echo "<a href='companyProfile?compId=".$rows['ID']."' class='btn btn-primary  btn-sm'> Show Profile  </a>";
                                            echo "</span>";

                                        echo '</li>';
                                    }

                                echo "</ul>";

                            }else{
                                echo "There's No Company To Show.";
                            }
?>
                        </div>

                    </div>
                    <!--End The Latest item -->

                </div>
            </div>


<?php



        }elseif($page == "Student"){

            echo" <div class='container mt-4'>";

                $stat = "SELECT * FROM users WHERE GroupID = 0 ORDER BY ID DESC ";             

                $result =$conn->query($stat);

                if($result->num_rows >0){

                    echo"<div class='table-responsive'>

                        <table class='main-table table table-bordered text-center'>

                            <tr class='bg-primary text-white'>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Specialty</td>
                                <td>UserName</td>
                                <td>Phone </td>
                                <td>Date</td>
                                <td>Control</td>
                            </tr>";
    
                            //Extract the data from result array
                
                            while($row =$result->fetch_assoc()){

                                echo "<tr>
                                        <td>".$row['ID']."</td>
                                        <td>".$row['Name']."</td>
                                        <td>".$row['Email']."</td>
                                        <td>".$row['Specialization']."</td>
                                        <td>".$row['UserName']."</td>
                                        <td>".$row['Phone']."</td>
                                        <td>".$row['Date']."</td>
                    
                                        <td>
                                            
                                            <a href='adminUnviersty.php?page=StudentProfile&studid=".$row['ID']. "'class='btn btn-sm mb-1 text-white' style='background-color:#3498db;padding:4px 16px'> Show Profile </a>

                                            <a href='adminUnviersty.php?page=Estimates&studid=".$row['ID']. "'class='btn btn-sm mb-1 p-1 text-white' style='background-color:#3498db'> Show Evaluation </a>";

                                        echo "</td>

                                    </tr>";
                            } 

                        echo "</table>";

                    echo "</div>";

                }else{
                    
                    echo "<div class='container alert alert-secondary'>
                        There's No Students To Show.
                    </div>";
                }

                echo "<a href='adminUnviersty.php?page=AddStudent' class='btn btn-primary'> + Add New Student</a>";

        echo "</div>";


        }elseif($page == "StudentsBeingTrained"){

            echo" <div class='container mt-4'>";

                
                $stat = "SELECT * FROM users WHERE GroupID = 0 AND Status = 2 ORDER BY ID DESC ";  
                
                $result =$conn->query($stat);

                if($result->num_rows >0){


                    echo"<div class='table-responsive'>

                        <table class='main-table table table-bordered text-center'>

                            <tr class='bg-primary text-white'>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Specialty</td>
                                <td>UserName</td>
                                <td>Phone </td>
                                <td>Date</td>
                                <td>Company Name</td>
                                <td>Control</td>
                            </tr>";

                            //Extract the data from result array
                
                            while($row =$result->fetch_assoc()){

                                $studId = $row['ID'];

                                $stat7 ="SELECT
                                            cv.*,
                                            company.CompanyName
                                        FROM 
                                            cv
                                        INNER JOIN
                                            company
                                        ON
                                            company.ID = cv.Comp_ID
                                        WHERE
                                            Stud_ID= '$studId' ";
                                
                                $result7 =$conn->query($stat7);
            
                                $row7 = $result7->fetch_assoc();                                


                                echo "<tr>
                                        <td>".$row['ID']."</td>
                                        <td>".$row['Name']."</td>
                                        <td>".$row['Email']."</td>
                                        <td>".$row['Specialization']."</td>
                                        <td>".$row['UserName']."</td>
                                        <td>".$row['Phone']."</td>
                                        <td>".$row['Date']."</td>
                                        <td>".$row7['CompanyName']."</td>

                    
                                        <td>
                                            
                                            <a href='adminUnviersty.php?page=StudentProfile&studid=".$row['ID']. "'class='btn  btn-sm mb-1 text-white' style='background-color:#3498db;padding:4px 18px'> Show Profile </a>

                                            <a href='adminUnviersty.php?page=Estimates&studid=".$row['ID']. "'class='btn btn-sm mb-1 text-white' style='background-color:#3498db'> Show Evaluation </a>";

                                        echo "</td>

                                    </tr>";
                            } 

                        echo "</table>";

                    echo "</div>";

                }else{
                    
                    echo "<div class='container alert alert-secondary'>
                        There's No Students To Show.
                    </div>";
                }


            echo "</div>";


        }elseif($page == "AddStudent"){

?>
            <div class="container">

                <!-- Start Form To inter Data -->

                <form class="mt-5" action="<?php echo htmlspecialchars('adminUnviersty.php?page=InsertStudent')?>" method="post">

                    <!-- Start comapny Field -->
                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Student Name</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="Sname" placeholder="Enter The Quadruple Name " autocomplete="off" required>
                                </div>
                    </div>

                    <!-- End company Field -->

                    <!-- Start password Field -->
                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="password" name ="password"  placeholder=" Password"  autocomplete="new-password" minlength="4" required>
                                </div>
                    </div>

                    <!-- End password Field -->

                    <!-- Start C password Field -->
                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="password" name ="confirm-password"  placeholder="Confirm Password" autocomplete="new-password" minlength="4" required>
                                </div>
                    </div>

                    <!-- End C password Field -->


                    <!-- Start  UserName Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="email" name ="Semail" placeholder="Email" required>
                                </div>
                    </div>

                    <!-- End  UserName Field -->


                    <!-- Start  Email Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Specialty</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="special" placeholder="University specialization" required>
                                </div>
                    </div>

                    <!-- End  Email Field -->
                    

                    <!-- Start  UserName Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">UserName</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="Susername" placeholder="UserName" required>
                                </div>
                    </div>

                    <!-- End  UserName Field -->

            

                    <!-- Start  Phone Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Phone</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="Sphone"  name ="Sphone" placeholder="phone number" required>
                                </div>
                    </div>

                    <!-- End  Phone Field -->

                        
                    <div class="mb-3">
                        <div class="col-md-1">
                            <input class="btn btn-primary form-control submit mt-2" type="submit" value="Save">
                        </div>
                    </div>


                </form>

                </div>

<?php


        }elseif($page == "InsertStudent"){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $formErrors = array();
        
                // This for scurity filter
                $name        = test_input($_POST['Sname']);
        
                $password    = test_input($_POST['password']);
                $hassedpass1 = sha1($password);
        
                $C_password  = test_input($_POST['confirm-password']);
                $hassedpass2 = sha1($C_password);
        
                $email       = test_input($_POST['Semail'])    ;
                $Special     = test_input($_POST['special'])    ;


                
                $username    = test_input($_POST['Susername']) ;
                $phone       = test_input($_POST['Sphone'])    ;
        
        
        
                if(empty($name)){
                    $formErrors[] = "Sorry, The Name Can't Be Empty";
                }

                if(str_word_count($name) < 4){
                    $formErrors[] = "Sorry, Enter the quadruple name";

                }
        
                if(empty($password)){
                    $formErrors[] ="Sorry, The Password Can't Be Empty";
                }
        
                if(empty($C_password )){
                    $formErrors[] ="Sorry, The Confirm Password Can't Be Empty";
                }
        
                if($password !== $C_password ){
                    $formErrors[] ="Sorry, The Password is Not Match";
                }
        
                if(empty($email)){
                    $formErrors[] ="Sorry, The Email Can't Be Empty";
                }

                if(empty($Special)){
                    $formErrors[] ="Sorry, The University specialization Can't Be Empty";
                }
        
                if(empty($username)){
                    $formErrors[] ="Sorry, The UserName Can't Be Empty";
                }
        
                if(empty($phone)){
                    $formErrors[] ="Sorry, The Phone Can't Be Empty";
                }
        

                if(empty($formErrors)){
        
                    //Check if Email exist in database using this 
            
                    $sql = "SELECT Email FROM users WHERE Email = '$email'";
                    $Result = $conn->query($sql);
        
                    if($Result->num_rows > 0){
        
                        $formErrors[]= "Sorry, This Email is Exist";
        
                    }else{
        
                        $sql2    = "SELECT Email FROM company WHERE Email = '$email'";
                        $result2 = $conn->query($sql2);
        
                        if($result2->num_rows > 0){
                            
                            $formErrors[]= "Sorry, This Email is Exist";
        
                        }else{
        
                            $date =date('m/d/Y');
                            $statSign = $conn->prepare("INSERT INTO users(Name,Password,Email,UserName,Phone,Specialization,Status,GroupID,Date)
                                                        VALUES(?,?,?,?,?,?,0,0,STR_TO_DATE('$date', '%m/%d/%Y'))");
        
                            $statSign->bind_param("ssssss",$zname,$password,$zmail,$zuser,$zphone,$zspecial);
        
                            $zname     = $name        ;
                            $password  = $hassedpass1 ;
                            $zmail     = $email       ;
                            $zspecial  = $Special     ;
                            $zuser     = $username    ;
                            $zphone    = $phone       ;
        
        
                            $statSign->execute();

                            echo "<div class='container mt-3'>";
                                $theMsg="<div class='alert alert-success'>The Student Insert Successfully </div>";
                                redirectHome($theMsg,'back');
                            echo "</div>"; 
                        }
                    }
                }


                if(!empty($formErrors)){
                    foreach($formErrors as $errors){
                        echo "<div class='container mt-3'>";

                            $theMsg = '<div class="alert alert-danger">' .$errors .'</div>';
                            redirectHome($theMsg,'back');
                        echo "</div>";

                    }
                }
        
            }


        }elseif($page == "StudentProfile"){

            if(isset($_GET['studid']) && is_numeric($_GET['studid'])){

                $studId = intval($_GET['studid']);
            }

            $Stat1        = "SELECT * FROM users WHERE ID = '$studId'";
            $results1    = $conn->query($Stat1);
            $rows1       = $results1->fetch_assoc();
?>

            <div class="container">
                <div class="S_profile mt-5">


                    <h1 class="mb-4 text-capitalize" style="color:#000000b3;"> <?php echo $rows1['UserName'] ?> Profile </h1>

                    <div class="mb-4">

                        <div class="panel-body bg-white p-3">

                            <div style="padding: 10px 15px; font-size:20px; text-shadow: 0px 0px 1px black;"> Information </div>


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
    
        }elseif($page == "Estimates"){

            if(isset($_GET['studid']) && is_numeric($_GET['studid'])){

                $studId = intval($_GET['studid']);
            }


            $stat7 ="SELECT
                        evaluation.*,
                        company.CompanyName,
                        users.Name
                    FROM 
                        evaluation
                    INNER JOIN
                        company
                    ON
                        company.ID = evaluation.Comp_ID
                    INNER JOIN
                        users
                    ON
                        users.ID = evaluation.Stud_ID    
                    WHERE
                        Stud_ID=$studId";

                    $result7 =$conn->query($stat7);

                    if($result7->num_rows >0){
                        $row7 = $result7->fetch_assoc();    
?>
                        <div class="container bg-white mt-4 p-4">
                            <h2 class="mb-4" style="color: #000000b3;"><?php echo $row7['Name'] ?></h2>

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
                        echo "<div class='container mt-4'>";
                            echo "<div class='alert alert-secondary'> The Student Has Not Been Evaluated Yet </div>";
                        echo "</div>";
                    }
    



        }elseif($page == "Company"){

?>
            <div class="container mt-5 mb-3">
                <div style="display:flex;flex-wrap:wrap;justify-content: space-between; align-items: center;">
                    <h2 class="mb-4"> View All Enrolled Companies </h2>
                    <a href="adminUnviersty?page=AddCompany" class="btn btn-primary" style="Width:180px;">+ Add New Company</a>

                </div>
                <hr style="margin-bottom:30px">
                <div class="row ">
<?php 

                    // Use to select All companies from data base
                    $sql    = "SELECT * FROM company";
                    $result = $conn->query($sql);

                    if($result->num_rows >0){

                        while($rows = $result->fetch_assoc()){

                            echo "<div class='col-sm-6 col-md-3'>";
                                    echo '<div class="card mb-5 pt-3 pb-3 item-box Studenthome" >';
                                    
                                        echo'<div>'; 
                                        
                                            if(empty($rows["Image"])){

                                                echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads/image/default.jpg" class="card-img-top" alt="...">';

                                            }else{
                                                echo '<img class="img-responsive mx-auto d-block mt-3" src="uploads\image\\'.$rows["Image"].'" class="card-img-top" alt="...">';
                                            }

                                        echo'</div>

                                            <div class="card-body">

                                                <h4 class="card-title text-center"> <a class="text-decoration-none" href="companyProfile?compId='.$rows["ID"].'">'.$rows["UserName"].'</a> </h3>
                                                <h6 class="text-center mb-4" style="color:#000000b3;">'.$rows["Address"].'</h6>

                                                <p class="card-text text-center mb-4">'.$rows["Description"].'</p>

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

        }elseif($page == "AddCompany"){
            //  Start Add Company Page
?>
            <div class="container">

                <!-- Start Form To inter Data -->

                <form class="mt-5" action="<?php echo htmlspecialchars('adminUnviersty?page=InsertCompany')?>" method="post" enctype="multipart/form-data">

                    <!-- Start comapny Field -->
                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Company Name</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="name" placeholder="Company Name " autocomplete="off" required>
                                </div>
                    </div>

                    <!-- End company Field -->

                    <!-- Start password Field -->
                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="password" name ="password"  placeholder=" Password"  autocomplete="new-password" minlength="4" required>
                                </div>
                    </div>

                    <!-- End password Field -->

                    <!-- Start C password Field -->
                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="password" name ="confirm-password"  placeholder="Confirm Password" autocomplete="new-password" minlength="4" required>
                                </div>
                    </div>

                    <!-- End C password Field -->


                    <!-- Start  Email Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="email" name ="email" placeholder="Email" required>
                                </div>
                    </div>

                    <!-- End  Email Field -->

                    <!-- Start  Description Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="description" placeholder="Description" required>
                                </div>
                    </div>

                    <!-- End  Description Field -->

                    <!-- Start  UserName Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">UserName</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="username" placeholder="UserName" required>
                                </div>
                    </div>

                    <!-- End  UserName Field -->

                    <!-- Start  Address Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name ="address" placeholder="Address" required>
                                </div>
                    </div>

                    <!-- End  Address Field -->

                    <!-- Start  Phone Field -->

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 control-label">Phone</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="phone"  name ="phone" placeholder="phone number" required>
                                </div>
                    </div>

                    <!-- End  Phone Field -->

                    <!-- Start  Phone Field -->

                    <div class="form-group row mb-3">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-md-4">
                            <input class="form-control" type="file"  name ="image" placeholder="Company Logo" required>
                        </div>
                    </div>

                    <!-- End  Phone Field -->

                        
                    <div class="mb-3">
                        <div class="col-md-1">
                            <input class="btn btn-primary form-control submit mt-2" type="submit" value="Save">
                        </div>
                    </div>


                </form>
                
            </div>   



<?php
        }elseif($page == "InsertCompany"){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $formErrors = array();

                // This for scurity filter
                $name        = test_input($_POST['name']);

                $password    = test_input(($_POST['password']));
                $hassedpass1 = sha1($password);

                $C_password  = test_input(($_POST['confirm-password']));
                $hassedpass2 = sha1($C_password);

                //filter Email

                $email       = test_input($_POST['email'])       ;
                $username    = test_input($_POST['username'])    ;
                $phone       = test_input($_POST['phone'])       ;
                $address     = test_input($_POST['address'])     ;
                $desc        = test_input($_POST['description']) ;
                
                $ImageName       = $_FILES['image']['name']      ;
                $ImageSize       = $_FILES['image']['size']      ;
                $ImageTmp        = $_FILES['image']['tmp_name']  ;
                $ImageType       = $_FILES['image']['type']      ;

                //List of all allowed file typed to upload
                $ImageAllowedExtension  = array("jpeg","jpg","png","gif");

                //Get image Extension


                $ImageExtension =explode('.',$ImageName);
                $var = end($ImageExtension);                


                if(!empty($ImageName) && ! in_array($var,$ImageAllowedExtension)){
                    $formErrors[] = "Sorry, This Extension Is Not Allowed";
                }

                if(empty($ImageName)){
                    $formErrors[] = "Sorry, The Image Can't Be Empty";
                }

                if($ImageSize > 4194304){
                    $formErrors[] = "Sorry, The Image Can't Be Larger Than 4MB";
                }

                if(empty($name)){
                    $formErrors[] = "Sorry, The Name Can't Be Empty";
                }

                if(empty($password)){
                    $formErrors[] ="Sorry, The Password Can't Be Empty";
                }

                if(empty($C_password )){
                    $formErrors[] ="Sorry, The Confirm Password Can't Be Empty";
                }

                if($password !== $C_password ){
                    $formErrors[] ="Sorry, The Password is Not Match";
                }

                if(empty($email)){
                    $formErrors[] ="Sorry, The Email Can't Be Empty";
                }

                if(empty($desc)){
                    $formErrors[] ="Sorry, The description Can't Be Empty";
                }

                if(empty($username)){
                    $formErrors[] ="Sorry, The UserName Can't Be Empty";
                }

                if(empty($phone)){
                    $formErrors[] ="Sorry, The Phone Can't Be Empty";
                }

                if(empty($address)){
                    $formErrors[] ="Sorry, The Address Can't Be Empty";
                }


                if(empty($formErrors)){

                    //This rand To sure not same image uplode
                    $Image = rand(0, 1000000) . '_' .$ImageName;
                    move_uploaded_file($ImageTmp, "uploads\image\\" . $Image);

                    //Check if Email exist in database using this 
            
                    $sql = "SELECT Email FROM users WHERE Email = '$email'";
                    $Result = $conn->query($sql);

                    if($Result->num_rows > 0){

                        $formErrors[]= "Sorry, This Email is Exist";

                    }else{

                        $sql2    = "SELECT Email FROM company WHERE Email = '$email'";
                        $result2 = $conn->query($sql2);

                        if($result2->num_rows > 0){
                            
                            $formErrors[]= "Sorry, This Email is Exist";

                        }else{

                            $date =date('m/d/Y');
                            $statSign = $conn->prepare("INSERT INTO company(CompanyName,Password,Email,Description,UserName,Address,Phone,Image,Date)
                                                        VALUES(?,?,?,?,?,?,?,?,STR_TO_DATE('$date', '%m/%d/%Y'))");

                            $statSign->bind_param("ssssssss",$C_name,$password,$zmail,$zdesc,$zuser,$zaddress,$zphone,$zimage);

                            $C_name    = $name        ;
                            $password  = $hassedpass1 ;
                            $zmail     = $email       ;
                            $zdesc     = $desc        ;
                            $zuser     = $username    ;
                            $zaddress  = $address     ;
                            $zphone    = $phone       ;
                            $zimage    = $Image       ;


                            $statSign->execute();

                            echo "<div class='container mt-3'>";
                                $theMsg="<div class='alert alert-success'>The  Company Insert Successfully </div>";
                                redirectHome($theMsg,'back');
                            echo "</div>";

                        }
                    }
                }

                if(!empty($formErrors)){
                    foreach($formErrors as $errors){
                        echo "<div class='container mt-3'>";

                            $theMsg = '<div class="alert alert-danger">' .$errors .'</div>';
                            redirectHome($theMsg,'back');
                        echo "</div>";

                    }
                }

            } 




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