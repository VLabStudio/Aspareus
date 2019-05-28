<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - My Account</title>
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
              if($userSession->IsSession())
              {
                $user =  $userSession->GetSession();

                if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Admin" || $userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Company")
                {
                  $UIGenerator->StartClass("UIBoxSmall GridViewCenterElementSmall TopSpacingSmall Big");

                      $UIGenerator->GenerateCustomElement("h1","My Account");

                      $UIGenerator->StartFormAutomatic("POST");
                        $UIGenerator->GenerateInputWithClassRequired("text","inputName",$user[2],"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter Admin Name");
                        $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                      $UIGenerator->EndForm();

                      $UIGenerator->StartFormAutomatic("POST");
                        $UIGenerator->GenerateInputWithClassRequired("text","inputPassword",$user[1],"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter Admin Name");
                        $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                      $UIGenerator->EndForm();

                      $UIGenerator->StartFormAutomatic("POST");
                        $UIGenerator->GenerateInputWithClassRequired("text","inputCompanyInitials",$user[3],"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter Company Initials");
                        $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                      $UIGenerator->EndForm();
                  }
               }

               if($userSession->IsSession())
               {
                 $user =  $userSession->GetSession();
               }

               if (!empty($_POST["inputName"]) && $userSession->IsSession())
                {
                  $name = str_replace(" ", "-", $_POST["inputName"]);
                  $statement = $DBH->prepare("UPDATE users SET Name=? WHERE UserID = ".$userSession->FindID($user[0],$user[1]).";");
                  $statement->bindParam(1, $name);
                  $statement->execute();

                  $DBH = null;
                  header('Location: ControlPanelMyAccount.php?update=The Name is Successfully updated and the new username is <br>'.$userSession->UpdateUserName($name,$user[3]));
                }
                else if (!empty($_POST["inputPassword"]) && $userSession->IsSession())
                {
                  $statement = $DBH->prepare("UPDATE users SET Password=? WHERE UserID = ".$userSession->FindID($user[0],$user[1]).";");
                  $statement->bindParam(1, $_POST["inputPassword"]);
                  $statement->execute();

                  $userSession->SetSession($user[0], $_POST["inputPassword"]);

                  $DBH = null;
                  header('Location: ControlPanelMyAccount.php?update=The password is successfully updated');
                }
                else if (!empty($_POST["inputCompanyInitials"]) && $userSession->IsSession())
                {
                  $statement = $DBH->prepare("UPDATE users SET CompanyInitials=? WHERE UserID = ".$userSession->FindID($user[0],$user[1]).";");
                  $statement->bindParam(1, $_POST["inputCompanyInitials"]);
                  $statement->execute();

                  $DBH = null;
                  header('Location: ControlPanelMyAccount.php?update=The Company initials is successfully updated and the new username is <br>'.$userSession->UpdateUserName($user[2],$_POST["inputCompanyInitials"]));
                }
                else if (!empty($_GET["update"]))
                {
                    $UIGenerator->GenerateCustomElementWithClass("h4",$_GET["update"],"TextCenter TextStyle TopSpacingMedium BottomSpacingMedium");
                }
             $UIGenerator->EndClass();
          $UIGenerator->EndClass();
       $UIGenerator->EndGridView();
      ?>
  </body>
</html>
