<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Add</title>
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

        $UIGenerator->StartGridView();
            $UIGenerator->StartClass("GridViewTop");
              include '../Menus/MainMenu.php';
            $UIGenerator->EndClass();

            $UIGenerator->StartClass("GridViewLeft");
             include '../Menus/SideMenu.php';
            $UIGenerator->EndClass();

            $UIGenerator->StartClass("GridViewCenter");

            if ($userSession->IsSession()) {

                $userSession = new UserSession();
                $user = $userSession->GetSession();

                $helper = new Helper();

                $user = $userSession->GetSession();

                $UIGenerator->StartClass("UIBoxSmall GridViewCenterElementSmall TopSpacingSmall");

                    $UIGenerator->StartFormAutomatic("POST");

                    if ($userSession->GetUserType($userSession->FindID($user[0], $user[1])) == "Admin") {
                        $UIGenerator->GenerateCustomElementWithClass("h2","Add Company","TextLeft TopSpacingMedium BottomSpacingMedium TextStyle");
                        $type = "Company";
                        $typeID = 2;
                    } else if ($userSession->GetUserType($userSession->FindID($user[0], $user[1])) == "Company") {
                        $UIGenerator->GenerateCustomElementWithClass("h2","Add User","TextLeft TopSpacingMedium BottomSpacingMedium TextStyle");
                        $type = "User";
                        $typeID = 3;
                    }

                    $UIGenerator->GenerateInputWithClassRequired("text","inputName","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Name");

                    $UIGenerator->GenerateInputWithClassRequired("text","inputPassword","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Password");

                    if($type == "Company")
                    $UIGenerator->GenerateInputWithClassRequired("text","inputInitials","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Initials");

                    $UIGenerator->GenerateInputWithClass("submit","submit","Add","SubmitButton Medium ElementCenter TopSpacingSmall BottomSpacingSmall","");

                  $UIGenerator->EndForm();

               $UIGenerator->EndClass();
             $UIGenerator->EndClass();
          $UIGenerator->EndGridView();

          if (!empty($_POST["inputName"]) && !empty($_POST["inputPassword"]))
          {
            $randomUserId = rand(100000000, 999999999);

            $statement = $DBH->prepare('INSERT INTO usertypes (UserID, TypeID) VALUES (?, ?);');
            $statement->bindParam(1, $randomUserId);
            $statement->bindParam(2, $typeID);
            $statement->execute();

            $name = str_replace(" ", "-", $_POST["inputName"]);
            $password = str_replace(" ", "-", $_POST["inputPassword"]);


            if (!empty($_POST["inputInitials"]))
            {
              $companyInitials = strtolower(str_replace(" ", "-", $_POST["inputInitials"]));
            } else {
              $companyInitials =  $user[3];
            }

            $userName = $helper->GenerateUserName($name,$companyInitials,$type);

            $statement = $DBH->prepare('INSERT INTO users (UserID, UserName, Password, Name, CompanyInitials) VALUES (?, ?, ?, ?, ?);');
            $statement->bindParam(1, $randomUserId);
            $statement->bindParam(2, $userName);
            $statement->bindParam(3, $password);
            $statement->bindParam(4, $name);
            $statement->bindParam(5, $companyInitials);
            $statement->execute();

            // A.K.A it is a company
            if($type == "User")
            {
              $statement = $DBH->prepare('INSERT INTO companyusers (UserID, CompanyID) VALUES (?, ?);');
              $statement->bindParam(1, $randomUserId);
              $statement->bindParam(2, $userSession->FindID($user[0], $user[1]));
              $statement->execute();
            }

            $DBH = null;
            header('Location: ControlPanelClientsAndUsers.php');
          }
        }
      ?>
  </body>
</html>
