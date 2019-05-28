<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="Menus/Css/Style.css">
  </head>
   <body>
       <div class="MainMenu">
        <div class="IconSmall"> <img src="../Menus/Icons/Navigation-Bar-Icon.png" alt="Icon"> </div>
          <?php
            require_once "../Classes/UserSession.php";
            $userSession = new UserSession();

            if($userSession->IsSession())
            {
                $user =  $userSession->GetSession();

               if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Admin")
               {
                 echo '
                 <div class="Link"> <a href="Home.php">Home</a> </div>
                 <div class="Link"> <a href="About.php">About</a> </div>
                 <div class="Link"> <a href="ControlPanelDashboard.php">Control Panel</a> </div>
                 <div class="Link"> <a href="SignOut.php">Sign Out</a> </div>
                 ';
               }
               else if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Company")
               {
                 echo '
                 <div class="Link"> <a href="Home.php">Home</a> </div>
                 <div class="Link"> <a href="About.php">About</a> </div>
                 <div class="Link"> <a href="ControlPanelDashboard.php">Control Panel</a> </div>
                 <div class="Link"> <a href="SignOut.php">Sign Out</a> </div>
                 ';
               }
               else if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "User")
               {
                 echo '
                 <div class="Link"> <a href="Home.php">Home</a> </div>
                 <div class="Link"> <a href="About.php">About</a> </div>
                 <div class="Link"> <a href="Tests.php">Tests</a> </div>
                 <div class="Link"> <a href="SignOut.php">Sign Out</a> </div>
                 ';
               }
            }
            else {
              echo '
              <div class="Link"> <a href="Home.php">Home</a> </div>
              <div class="Link"> <a href="About.php">About</a> </div>
              <div class="Link"> <a href="SignIn.php">Sign in</a> </div>
              ';
            }
          ?>
      </div>
  </body>
</html>
