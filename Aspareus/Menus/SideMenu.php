<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../Menus/Css/Style.css">
  </head>
   <body>
      <script>
        document.querySelector(".IconSmall").className = "IconBig";
      </script>

      <div class="SideMenu">
          <?php
            require_once '../Classes/UserSession.php';
            $userSession = new UserSession();

            if($userSession->IsSession())
            {
                $user =  $userSession->GetSession();

               if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Admin")
               {
                 echo '
                 <a href="../Pages/ControlPanelDashboard.php"><img src="../Menus/Icons/Dashboard.png" alt="Dashboard image"> <br>Dashboard</a>
                 <a href="../Pages/ControlPanelAddClientsAndUsers.php"><img src="../Menus/Icons/Add-Client.png" alt="Add Client image"> <br>Add Client</a>
                 <a href="../Pages/ControlPanelClientsAndUsers.php"><img src="../Menus/Icons/Clients-Users.png" alt="Control Panel Add Clients And Users image"> <br>Clients</a>
                 <a href="../Pages/ControlPanelMyAccount.php"><img src="../Menus/Icons/My-Account.png" alt="My Account image"> <br>My Account</a>
                 ';
               }
               else if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Company")
               {
                 echo '
                 <a href="../Pages/ControlPanelDashboard.php"><img src="../Menus/Icons/Dashboard.png" alt="Dashboard image"> <br>Dashboard</a>
                 <a href="../Pages/ControlPanelAddClientsAndUsers.php"><img src="../Menus/Icons/Add-Client.png" alt="Add Client image"> <br>Add User</a>
                 <a href="../Pages/ControlPanelClientsAndUsers.php"><img src="../Menus/Icons/Clients-Users.png" alt="Control Panel Add Clients And Users image"> <br>Users</a>
                 <a href="../Pages/ControlPanelMakeTests.php"><img src="../Menus/Icons/Make-Test.png" alt="Make Test image"> <br>Make Test</a>
                 <a href="../Pages/ControlPanelTests.php"><img src="../Menus/Icons/Tests.png" alt="Tests image"> <br>Tests</a>
                 <a href="../Pages/ControlPanelTestResult.php"><img src="../Menus/Icons/Results.png" alt="Results image"> <br>Results</a>
                 <a href="../Pages/ControlPanelMyAccount.php"><img src="../Menus/Icons/My-Account.png" alt="My Account image"> <br>My Account</a>
                 ';
               }
            }
          ?>
      </div>
  </body>
</html>
