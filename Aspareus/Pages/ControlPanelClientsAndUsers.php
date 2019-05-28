<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Clients</title>
  <link rel="stylesheet" type="text/css" href="../Menus/Css/Style.css">
  <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Base.css">
  <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Styles/Metro.css">
  <link rel="icon" href="../Icons/Favicon.ico" type="image/x-icon"/>
  <link rel="shortcut icon" href="../Icons/Favicon.ico" type="image/x-icon"/>
</head>
<body>
    <?php
        require '../UIGenerator/Classes/UIGenerator.php';
        require_once '../Classes/UserSession.php';
        require '../Classes/Helper.php';
        require '../Classes/ConnectDB.php';
        $UIGenerator = new UIGenerator();
        $userSession = new UserSession();

        $UIGenerator->StartGridView();
            $UIGenerator->StartClass("GridViewTop");
              include '../Menus/MainMenu.php';
            $UIGenerator->EndClass();

            $UIGenerator->StartClass("GridViewLeft");
               include '../Menus/SideMenu.php';
            $UIGenerator->EndClass();

             $UIGenerator->StartClass("GridViewCenter");

               $user = $userSession->GetSession();

               if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Admin") {
                 $t = "Company";
                 $statement = $DBH->prepare("SELECT users.UserName,users.Password,users.Name,users.UserID FROM users JOIN usertypes ON usertypes.UserID = users.UserID JOIN types ON types.TypeID = usertypes.TypeID WHERE types.TypeName=?;");
                 $statement->bindParam(1, $t);
                 $statement->execute();

                 $Fetch = null;

                 while ($row = $statement->fetch())
                 {
                    $Fetch[] = $row['Name'];
                    $Fetch[] = $row['UserName'];
                    $Fetch[] = $row['Password'];
                    $Fetch[] = $row['UserID'];
                    $Fetch[] = '
                    <form action="ControlPanelClientsAndUsersEdit.php" method="post">
                      <input type="hidden" name="UserID" value="'.$row['UserID'].'">
                      <button type="submit" class="SubmitButton">Edit</button>
                    </form>';
                 }

                 if(count($Fetch) > 0) {
                 $UIGenerator->GenerateTableWithClass(array("Company Name","User Name", "Password","Client Key","Edit"),$Fetch,"TableStyle LeftSpacingSmall TopSpacingSmall");
                 } else {
                   $UIGenerator->GenerateCustomElementWithClass("h1","No Company","GridViewCenterElementExtraBig ExtraBig TextCenter TextStyle");
                 }
               } else if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Company"){

                 $statement = $DBH->prepare("SELECT users.UserName,users.Password,users.Name,users.UserID FROM users JOIN companyusers ON companyusers.UserID=users.UserID WHERE companyusers.CompanyID=?;");
                 $statement->bindParam(1, $userSession->FindID($user[0],$user[1]));
                 $statement->execute();

                 $Fetch = null;

                 while ($row = $statement->fetch())
                 {
                    $Fetch[] = $row['Name'];
                    $Fetch[] = $row['UserName'];
                    $Fetch[] = $row['Password'];
                    $Fetch[] = $row['UserID'];
                    $Fetch[] = '
                    <form action="ControlPanelClientsAndUsersEdit.php" method="post">
                      <input type="hidden" name="UserID" value="'.$row['UserID'].'">
                      <button type="submit" class="SubmitButton">Edit</button>
                    </form>';
                 }

                 if(count($Fetch) > 0){
                    $UIGenerator->GenerateTableWithClass(array("Name","User Name", "Password","Client Key","Edit"),$Fetch,"TableStyle LeftSpacingSmall TopSpacingSmall");
                 } else {
                   $UIGenerator->GenerateCustomElementWithClass("h1","No User","GridViewCenterElementExtraBig ExtraBig TextCenter TextStyle");
                 }

               }
               $DBH = null;
             $UIGenerator->EndClass();
          $UIGenerator->EndGridView();
        ?>
  </body>
</html>
