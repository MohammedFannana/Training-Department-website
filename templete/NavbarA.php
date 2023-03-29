<nav class="navbar navbar-expand-lg navbar-light" style="background-color:#075395;">

<div class="container">

    <a class="navbar-brand text-white" href="adminUnviersty.php" style="font-size:16px">Home</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item"> <a class="nav-link active text-white" aria-current="page" href="adminUnviersty?page=Student" > Students   </a> </li>
            <li class="nav-item"> <a class="nav-link active text-white" aria-current="page" href="adminUnviersty?page=Company" > Companies  </a> </li>


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

            <li class="nav-item dropdown ">

                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $logo; ?> </a>

                <ul class="dropdown-menu ul_style pt-2 pb-2" aria-labelledby="navbarDropdown" style="padding: 0rem 0;">

                    <li><a class="dropdown-item" href="adminUnviersty?page=EditProfile">Edit Porfile</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>

                </ul>

            </li>

        </ul>

    </div>
</div>
</nav> 

