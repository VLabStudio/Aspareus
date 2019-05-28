<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Make Test</title>
  <link rel="stylesheet" type="text/css" href="../Menus/Css/Style.css">
  <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Base.css">
  <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Styles/Metro.css">
  <link rel="icon" href="../Icons/Favicon.ico" type="image/x-icon"/>
  <link rel="shortcut icon" href="../Icons/Favicon.ico" type="image/x-icon"/>
</head>
<body>
    <?php
        header('Cache-Control: no cache');
        session_cache_limiter('private_no_expire');

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

              $userSession = new UserSession();

              if ($userSession->IsSession())
              {
                $helper = new Helper();

                $user = $userSession->GetSession();

                  if($userSession->GetUserType($userSession->FindID($user[0], $user[1])) == "Company")
                  {
                    $UIGenerator->StartClass("UIBoxMedium GridViewCenterElementMedium TopSpacingSmall");
                      $UIGenerator->StartFormAutomatic("POST");
                        $UIGenerator->GenerateCustomElementWithClass("h1","Make Test","TextCenter TopSpacingMedium BottomSpacingMedium");
                        $UIGenerator->GenerateInputWithClassRequired("text","inputTitle","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter title");
                        $UIGenerator->GenerateCustomInputWithClass("textarea",'name="inputDescription" rows="3" cols="50" placeholder="Enter description here..."',"","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig TextStyle");
                        $UIGenerator->GenerateCustomInputWithClass("input",'type="number" min="1" max="20" value="1" name="inputNumQuestions" placeholder="Enter the number of test"',"","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig TextStyle");
                        $UIGenerator->GenerateInputWithClass("submit","submit","Next","SubmitButton Medium ElementCenter TopSpacingSmall BottomSpacingSmall","");
                      $UIGenerator->EndForm();
                    $UIGenerator->EndClass();
                  }
                  if (!empty($_POST["inputTitle"]) && !empty($_POST["inputDescription"]) && !empty($_POST["inputNumQuestions"]))
                  {
                      $randomTestId = rand(100000000, 999999999);

                      $title = $_POST["inputTitle"];
                      $description = $_POST["inputDescription"];
                      $questions = $_POST["inputNumQuestions"];

                      if($questions <= 20 && $questions >= 1)
                      {
                        $statement = $DBH->prepare('INSERT INTO `tests` (`ID`, `TestID`, `Name`, `Description`) VALUES (NULL, ?, ?, ?);');
                        $statement->bindParam(1, $randomTestId);
                        $statement->bindParam(2, $title);
                        $statement->bindParam(3, $description);
                        $statement->execute();

                        $statement = $DBH->prepare('INSERT INTO `companytests` (`TestID`, `CompanyID`) VALUES (?, ?);');
                        $statement->bindParam(1, $randomTestId);
                        $statement->bindParam(2, $user[4]);
                        $statement->execute();

                        $DBH = null;

                        setcookie("TestID", $randomTestId, time() + (86400 * 30), "/");
                        setcookie("QuestionCount", $questions, time() + (86400 * 30), "/");
                        setcookie("QuestionIndex", 1, time() + (86400 * 30), "/");

                        header('Location: ControlPanelNextQuestion.php');
                     }
                  }
               }
          $UIGenerator->EndClass();
       $UIGenerator->EndGridView();
      ?>
  </body>
</html>
