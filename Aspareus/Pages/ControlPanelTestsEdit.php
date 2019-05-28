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
              if($userSession->GetUserType($ID) != "Company")
              {
                $userWithID = $userSession->GetSessionWithID($ID);

                $UIGenerator->StartClass("UIBoxSmall GridViewCenterElementSmall TopSpacingSmall Big");

                $UIGenerator->GenerateCustomElement("h1","Edit");

                $UIGenerator->StartFormAutomatic("POST");
                  $UIGenerator->GenerateInputWithClassRequired("text","inputName",$helper->GetTestName($ID),"TopSpacingSmall BottomSpacingSmall UserInput Big","Enter Name");
                  $UIGenerator->GenerateInputWithClass("submit","submit","Save","SubmitButton LeftSpacingSmall Medium","");
                $UIGenerator->EndForm();

                $UIGenerator->StartFormAutomatic("POST");
                  $UIGenerator->GenerateInputWithClass("submit","inputDelete","Delete","SubmitButton ElementCenter Medium TopSpacingSmall","");
                $UIGenerator->EndForm();
              }

              $ID = $_COOKIE['ID'];
              $userWithID = $userSession->GetSessionWithID($ID);

              if (!empty($_POST["inputName"]))
              {
                $statement = $DBH->prepare("UPDATE tests SET Name = ? WHERE TestID = ?");
                $statement->bindParam(1, $_POST["inputName"]);
                $statement->bindParam(2, $ID);
                $statement->execute();
                $DBH = null;
                header('Location: ControlPanelTestsEdit.php?update=The name of the test is successfully updated');
              }
              else if (!empty($_POST["inputDelete"]))
              {
                $optionID = -1;
                $statement = $DBH->prepare("SELECT QuestionID FROM questions WHERE TestID = ?;");
                $statement->bindParam(1, $ID);
                $statement->execute();
                while ($row = $statement->fetch())
                {
                  $optionID = $row['QuestionID'];
                }

                $statement = $DBH->prepare("DELETE FROM companytests WHERE TestID = ?; DELETE FROM tests WHERE TestID = ?;  DELETE FROM questions WHERE TestID = ?; DELETE FROM options WHERE OptionID = ?");
                $statement->bindParam(1, $ID);
                $statement->bindParam(2, $ID);
                $statement->bindParam(3, $ID);
                $statement->bindParam(4, $optionID);
                $statement->execute();
                $DBH = null;
                header('Location: ControlPanelTests.php');
              }
              else if (!empty($_GET["update"]))
              {
                echo '<div class="Message-Valid">' . $_GET["update"] . '</div>';
              }
            }
          }
         $UIGenerator->EndClass();
       $UIGenerator->EndGridView();
      ?>
  </body>
</html>
