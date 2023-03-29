<nav class="navbar navbar-expand-lg navbar-light" style="background-color:#075395;">

    <div class="container">

        <div class="d-flex" style="align-items: center;">

            <a class="navbar-brand text-white" href="student.php" style="font-size:16px">Home</a>

            <!-- Start  Notifications content-->
            <?php
                        $sessionUser = $_SESSION['email'];

                        $result4 = getRecord('*','users','Email',$sessionUser);

                        $row4 =$result4->fetch_assoc();

                        $userID = $row4['ID']; 

                        $stat3 = "SELECT
                                evaluation.Comp_ID,
                                company.CompanyName
                            FROM 
                                evaluation
                            INNER JOIN
                                company
                            ON
                                company.ID = evaluation.Comp_ID
                            WHERE
                                Stud_ID='$userID' ";
                    
                            $result3 =$conn->query($stat3);

                            $row3 =$result3->fetch_assoc();

                            $counter = 0;

                            if($row4['Status'] == 1){
                                
                                $counter++;

                            }

                            if($row4['Status'] == -1){
                                $counter++;

                            }

                            if($row4['Status'] == 2){
                                $counter++;
                            }

                ?>

                <!-- End  Notifications content-->
        
        
            <div class="dropdown one ">

                <a class="nav-link dropdown-toggle text-white " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications"> 
                    <i class="fa-regular fa-bell text-white"></i>

                    <?php 
                        if($counter != 0){
                            echo  $counter;
                        }
                    ?>
            
                </a>

                

                    <ul class="dropdown-menu mt-2 pb-0 two">

                        <h6 class="p-2 pb-0">Notifications</h6>
                        <hr class="mb-0 mt-0">

                        <?php


                            if($row4['Status']  == 0){
                                
                                echo '<li class="three">
                                                    
                                        <a class="dropdown-item text-start p-0" href=""> There are no new notifications </a>

                                    </li>
                                    <hr class="mb-0 mt-0">';
                                    
                            }


                            if($row4['Status']  == 1){

                                echo '<li class="three one22" >
                                                    
                                            <a class="dropdown-item text-start p-0">The training request was submitted to a company successfully </a>
                                            <i class="fa-regular fa-lightbulb text-secondary" style="font-size:20px"></i>                                        

                                    </li>
                                    <hr class="mb-0 mt-0">';

                            }


                            if($row4['Status']  == -1){
                                    
                                echo '<li class="three one22">
                                                    
                                            <a class="dropdown-item text-start p-0">A company refused to train you  </a>
                                            <i class="fa-regular fa-lightbulb text-secondary" style="font-size:20px"></i>                                        

                                    </li>
                                    <hr class="mb-0 mt-0">';


                            }

                            if($row4['Status']  == 2){

                                    echo '<li class="three one22">
                                        
                                            <a class="dropdown-item text-start p-0">Your training has been accepted by a company '.$row3['CompanyName'].'</a>
                                            <i class="fa-regular fa-lightbulb text-secondary" style="font-size:20px"></i>
                                        </li>
                                    <hr class="mb-0 mt-0">';

                            }
                        ?>

                    </ul>

            </div>

        </div>   
        

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item"> <a class="nav-link active text-white" aria-current="page" href="student.php?page=profile" > My Profile  </a> </li>
                <li class="nav-item"> <a class="nav-link active text-white" aria-current="page" href="cv.php"  > CV  </a> </li>
                <li class="nav-item"> <a class="nav-link active text-white" aria-current="page" href="student.php?page=company" > Companies   </a> </li>


            </ul>
        
            
            <?php

                //To select username from data base
                $email = $_SESSION['email'];


                $stat = "SELECT UserName FROM users WHERE Email ='$email'";
                
                $result = $conn->query($stat);

                if($result->num_rows >0){

                    $rows =$result->fetch_assoc();
                    $logo = $rows['UserName'];
        
                }

            ?>


            <ul class="nav navbar-nav navbar-right">


                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle text-white text-capitalize" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $logo; ?> </a>

                    <ul class="dropdown-menu ul_style pt-2 pb-2" aria-labelledby="navbarDropdown" style="padding: 0rem 0;">

                        <li><a class="dropdown-item" href="student?page=EditProfile">Edit Porfile</a></li>
                        <li><a class="dropdown-item" href="student?page=estimates">Estimates</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>

                    </ul>

                </li>

            </ul>

        </div>
    </div>
</nav> 

