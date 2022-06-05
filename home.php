<?php
// Include GitHub API config file
require_once 'gitConfig.php';


require_once 'User.class.php';
$user = new User();

if(isset($access)){
    // Get the user profile info from Github
    $gitUser = $gitClient->apiRequest($access);
    
    if(!empty($gitUser)){
      
        $gitUserData = array();
        $gitUserData['oauth_provider'] = 'github';
        $gitUserData['oauth_uid'] = !empty($gitUser->id)?$gitUser->id:'';
        $gitUserData['name'] = !empty($gitUser->name)?$gitUser->name:'';
        $gitUserData['username'] = !empty($gitUser->login)?$gitUser->login:'';
        $gitUserData['email'] = !empty($gitUser->email)?$gitUser->email:'';
        $gitUserData['location'] = !empty($gitUser->location)?$gitUser->location:'';
        $gitUserData['picture'] = !empty($gitUser->avatar_url)?$gitUser->avatar_url:'';
        $gitUserData['link'] = !empty($gitUser->html_url)?$gitUser->html_url:'';
        
       
        $userData = $user->checkUser($gitUserData);
        
        
        $_SESSION['userData'] = $userData;
        
        
        $output  = '<h2>Github Profile Details</h2>';
        $output .= '<img src="'.$userData['picture'].'" />';
        $output .= '<p>ID: '.$userData['oauth_uid'].'</p>';
        $output .= '<p>Name: '.$userData['name'].'</p>';
        $output .= '<p>Login Username: '.$userData['username'].'</p>';
        $output .= '<p>Email: '.$userData['email'].'</p>';
        $output .= '<p>Location: '.$userData['location'].'</p>';
        $output .= '<p>Profile Link :  <a href="'.$userData['link'].'" target="_blank">Click to visit GitHub page</a></p>';
        $output .= '<p>Logout from <a href="logout.php">GitHub</a></p>'; 
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
    
}elseif(isset($_GET['code'])){
    // Verify the state matches the stored state
    if(!$_GET['state'] || $_SESSION['state'] != $_GET['state']) {
        header("Location: ".$_SERVER['PHP_SELF']);
    }
    
    // Exchange the auth code for a token
    $accessToken = $gitClient->getAccessToken($_GET['state'], $_GET['code']);
  
    $_SESSION['access_token'] = $access;
  
    header('Location: ');
}else{
    // Generate a random hash and store in the session for security
    $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
    
    // Remove access token from the session
    unset($_SESSION['access_token']);
  
    // Get the URL to authorize
    $loginURL = $gitClient->getAuthorizeURL($_SESSION['state']);
    
    // Render Github login button
    $output = '<a href="'.htmlspecialchars($loginURL).'"><img src="images/github-login.png">continue with github</a>';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="boostrap\css\bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/boostrap\js\bootstrap.bundle.min.js"></script>

    <title>home</title>
</head>

<body>

    <form >
        <header class="text-white p-1 text-center" style="background-color:black;">
            <h6>IREMBO Special CAT</h6>
        </header>


        <div class="d-flex justify-content-center align-items-center my-3">

            <div class="border my-4 px-3 pt-4 position-relative text-center w-30 " style="height:70vh; width: 60vh;">
            <img src="pro.PNG" alt="" style="font-size:30px;position:absolute;top:-40px">    
      
                <div class=" my-5">
                    <h6 style="font-size:20px;padding:2">Welcome Nsengimana,</h6>
                </div>
                <div class=" mt-1">
                    <h6 style="font-size:20px;padding:2">elinsengimana@gmail.com</h6>
                </div>



                <div class="position-relative" style="top: 200px; width: 80px; ">
                    <button type="button" class=" text-white fw-light w-100 text-start btn-sm " style="background-color:black;margin-left:80px;"> <a href="logout.php">Log Out</a></button>
                    

                </div>
            </div>
        </div>
    </form>

 </html>
</body>
</html>