<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Edit</title>
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

        if ($userSession->IsSession())
        {
          $userSession = new UserSession();
          $helper = new Helper();

          if (!empty($_POST['UserID']))
          {
            $ID = $_POST['UserID'];
            setcookie("ID", $ID, time() + (86400 * 30) , "/");
          }
          else if (!empty($_COOKIE['ID']))
          {
            $ID = $_COOKIE['ID'];
          }
          else
          {
            $ID = - 1;
          }

          if (!empty($_COOKIE['ID']))
          {
            $userWithID = $userSession->GetSessionWithID($ID);

            $UIGenerator->StartClass("UIBoxSmall GridViewCenterElementSmall TopSpacingSmall Big");

                $UIGenerator->GenerateCustomElement("h1","Edit");

                $UIGenerator->StartFormAutomatic("POST");
                  $UIGenerator->GenerateInputWithClassRequired("text","inputName",$userWithID[2],"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter Name");
                  $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                $UIGenerator->EndForm();

                $UIGenerator->StartFormAutomatic("POST");
                  $UIGenerator->GenerateInputWithClassRequired("text","inputPassword",$userWithID[1],"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter Password");
                  $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                $UIGenerator->EndForm();

                if($userSession->GetUserType($ID) != "User") {
                  $UIGenerator->StartFormAutomatic("POST");
                    $UIGenerator->GenerateInputWithClassRequired("text","inputCompanyInitials",$userWithID[3],"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter CompanyInitials");
                    $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                  $UIGenerator->EndForm();
                }

                $UIGenerator->StartFormAutomatic("POST");
                  $UIGenerator->GenerateInputWithClass("submit","inputSubmit","Delete","SubmitButton ElementCenter Medium TopSpacingSmall","");
                $UIGenerator->EndForm();

              $UIGenerator->EndForm();

              $ID = $_COOKIE['ID'];
              $userWithID = $userSession->GetSessionWithID($ID);
              if (!empty($_POST["inputName"]))
              {
                $name = str_replace(" ", "-", $_POST["inputName"]);
                $statement = $DBH->prepare("UPDATE users SET Name=? WHERE UserID = " . $ID . ";");
                $statement->bindParam(1, $name);
                $statement->execute();
                $DBH = null;
                header('Location: ControlPanelClientsAndUsersEdit.php?update=The name is Successfully updated and the new username is <br />' . $userSession->UpdateUserNameWithID($name, $userWithID[3], $ID));
              }
              else if (!empty($_POST["inputPassword"]))
              {
                $statement = $DBH->prepare("UPDATE users SET Password=? WHERE UserID = " . $userSession->FindID($userWithID[0], $userWithID[1]) . ";");
                $statement->bindParam(1, $_POST["inputPassword"]);
                $statement->execute();
                $DBH = null;
                header('Location: ControlPanelClientsAndUsersEdit.php?update=The password is successfully updated');
              }
              else if (!empty($_POST["inputCompanyInitials"]) && $userSession->GetUserType($ID) != "User")
              {
                $companyInitials = str_replace(" ", "-", $_POST["inputCompanyInitials"]);
                $statement = $DBH->prepare("UPDATE users SET CompanyInitials=? WHERE UserID = " . $ID . ";");
                $statement->bindParam(1, $companyInitials);
                $statement->execute();
                $DBH = null;
                header('Location: ControlPanelClientsAndUsersEdit.php?update=The initials is Successfully updated and the new username is <br />' . $userSession->UpdateUserNameWithID($userWithID[2], $companyInitials, $ID));
              }
              else if (!empty($_POST["inputSubmit"]))
              {
                $statement = $DBH->prepare("DELETE FROM users WHERE UserID = ?;  DELETE FROM usertypes WHERE UserID = ?;");
                $statement->bindParam(1, $ID);
                $statement->bindParam(2, $ID);
                $statement->execute();
                $DBH = null;
                header('Location: ControlPanelClientsAndUsers.php');
              }
              else if (!empty($_GET["update"]))
              {
                $UIGenerator->GenerateCustomElementWithClass("h4",$_GET["update"],"TextCenter TextStyle TopSpacingMedium BottomSpacingMedium");
              }
            }
          }
          $UIGenerator->EndClass();
       $UIGenerator->EndGridView();
      ?>
  </body>
</html>
