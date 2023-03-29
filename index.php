<?php
    session_start();


    include "./init.php" ;
    echo "<head> <title>Login</title> </head>";


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        // This Array Store All Error For Echo

        $formErrors = array();



        //filter Email
        $filterEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

        if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){
            $formErrors[] ='Sorry, The Email Is Not Valid';
        }

        // login page collect data from form
        $email       = test_input($filterEmail)        ;
        $pass        =  test_input($_POST['password']) ;
        // the sha1 function to encryption password
        $hashedPass  = sha1($pass)                     ;


        if(empty($email)){
            $formErrors[] ="Sorry, The Email Can't Be Empty";
        }

        if(empty($pass)){
            $formErrors[] ="Sorry, The Password Can't Be Empty";
        }

    
        //Check if user exit in database

        $stat ="SELECT Email,Password,GroupID
                FROM users
                WHERE Email ='$email' AND Password = '$hashedPass'";
        
        $result = $conn->query($stat);
        
        if($result->num_rows >0){

            $rows =$result->fetch_assoc();
            $groupId = $rows['GroupID'];

            $_SESSION['email'] = $email ;
        
            if($groupId == 0){
                header('Location:student.php');
                exit();

            }elseif($groupId == 1){

                header('Location:adminUnviersty.php');
                exit();

            }

        }else{
            $formErrors[]= "Sorry, This Email is Not Exist";
        }

    }

?>

    <div class="container">
        <div style="background-color: #F4F4F4;">


            <form class="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

                <h3 class="text-center">Login</h3>

                <p class="text-center" >

                        <a class="text-decoration-none" href="index.php">
                            <span class="text-primary"> As User    </span>
                        </a> |

                        <a class="text-decoration-none " href="loginC.php">
                            <span>  As company </span>
                        </a>

                    </p>

                <i class="fa-solid fa-user"></i>
                <input class="form-control mb-0" type="email" name="email" placeholder="Email" autocomplete="off" required><br>

                <i class='fa-solid fa-lock'></i>
                <input class="form-control" type="password" name ="password" placeholder="Password" required><br>
                <input class="btn btn-primary form-control submit " type="submit" value="Login">
                
                <?php
                    if(!empty($formErrors)){
                            foreach($formErrors as $errors){
                                echo '<div class="text-danger text-center" >' .$errors .'</div>';
                            }
                        }
                ?>    

                <!-- <p class="mt-3"> Create an account? <a class="text-decoration-none" href="Signup.php"> Sign up </a> </p> -->

            </form>

        </div>


        <div class="row object mb-4" style="justify-content: space-between;">

            <div class="col-md-4 pt-3 pb-3  text-center" style="background-color:#d6dbe769;position:relative;">
                <i class="fa-solid fa-location-dot"></i>
                <h3 class="text-center " style="margin-top:30px;">Our Goals</h3>
                <p style="margin-top:15px;  color: #00000080;">
                    Facilitating the process of finding companies that allow field training for university students.
                </p>
            </div>

            <div class="col-md-4 pt-3 pb-3 text-center" style="background-color:#d6dbe769;position:relative;">
                <i class="fa-solid fa-chalkboard"></i>
                <h3 class="text-center " style="margin-top:30px;">Our Goals</h3>
                <p style="margin-top:15px; color: #00000080;">Facilitate the management and follow-up of field training.</p>
            </div>

            
            <div class="col-md-4 pt-3 pb-3 text-center" style="background-color:#d6dbe769;position:relative;">
                <i class="fa-solid fa-tower-broadcast"></i>
                <h3 class="text-center " style="margin-top:30px;">Our Goals</h3>
                <p style="margin-top:15px;    color: #00000080;">
                    Reducing the need for paper transactions and the cost to the university and students of the follow-up process.
                </p>
            </div>

        </div>

    </div>

<?php include "./templete/footer.php" ?>



