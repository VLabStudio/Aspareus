<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Next Question</title>
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
          $helper = new Helper();

          if ($userSession->IsSession())
          {
            // min 2 norm 5
            $numAnswers = 5;

            $user = $userSession->GetSession();

              if($userSession->GetUserType($userSession->FindID($user[0], $user[1])) == "Company")
              {
                ob_start();
                $UIGenerator->StartClass("UIBoxMedium GridViewCenterElementMedium TopSpacingSmall");
                  $UIGenerator->StartFormAutomatic("POST");
                   $UIGenerator->GenerateCustomElementWithClass("h1","Make Test","TextCenter TopSpacingMedium BottomSpacingMedium");
                    $UIGenerator->GenerateCustomElementWithClass("p","
                    Attention! Please don't make breaks while developing the quiz.
                    You have approximately 10 minutes per form to fill it in.
                    Otherwise data can be lost.
                    Please, enter the questions. It is only possible to enter the questions one by one.
                    You are at Question ".$_COOKIE['QuestionIndex']." of ".$_COOKIE['QuestionCount'].".",
                    "TextCenter TopSpacingMedium BottomSpacingMedium");
                    $UIGenerator->GenerateCustomInputWithClassRequired("textarea",'name="inputQuestion" rows="3" cols="50" placeholder="Enter Question here..."',"","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig TextStyle");
                    for ($i=1; $i <= $numAnswers; $i++) {
                      if($i <= 2) {$UIGenerator->GenerateInputWithClassRequired("text","inputAnswer". $i,"","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Answer ". $i);}
                      else {$UIGenerator->GenerateInputWithClass("text","inputAnswer". $i,"","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Answer ". $i." (you can leave it blank)");}
                    }
                    $UIGenerator->GenerateInputWithClassRequired("text","inputRightAnswer","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Right Answer");
                    $UIGenerator->GenerateInputWithClass("submit","submitButton","Next","SubmitButton Medium ElementCenter TopSpacingSmall BottomSpacingSmall","");
                  $UIGenerator->EndForm();
                $UIGenerator->EndClass();
              }

              if (!empty($_POST["inputQuestion"]) && !empty($_POST["inputAnswer1"]) && !empty($_POST["inputAnswer2"]) && !empty($_POST["inputRightAnswer"]))
              {
                 $randomQuestionId = rand(100000000, 999999999);

                 setcookie("QuestionIndex",$_COOKIE['QuestionIndex'] + 1, time() + (86400 * 30), "/");

                 $statement = $DBH->prepare('INSERT INTO `questions` (`ID`, `QuestionID`, `TestID`, `Title`, `Answer`) VALUES (NULL, ?, ?, ?, ?);');
                 $statement->bindParam(1, $randomQuestionId);
                 $statement->bindParam(2, $_COOKIE['TestID']);
                 $statement->bindParam(3, $_POST["inputQuestion"]);
                 $statement->bindParam(4, $_POST["inputRightAnswer"]);
                 $statement->execute();

                 for ($i=1; $i < $numAnswers; $i++) {
                  if(!empty($_POST["inputAnswer".$i]))
                  {
                    $statement = $DBH->prepare('INSERT INTO `options` (`ID`, `OptionID`, `Option`) VALUES (NULL, ?, ?);');
                    $statement->bindParam(1, $randomQuestionId);
                    $statement->bindParam(2, ($_POST["inputAnswer".$i]));
                    $statement->execute();
                  }
                 }

                $DBH = null;

                if($_COOKIE['QuestionIndex'] >= $_COOKIE['QuestionCount'])
                {
                    setcookie("TestID", -1, time() + (86400 * 30), "/");
                    header('Location: ControlPanelTests.php');
                    ob_end_flush();
                }
                else {
                    header('Location: ControlPanelNextQuestion.php');
                    ob_end_flush();
                }
            }
          }
          $UIGenerator->EndClass();
       $UIGenerator->EndGridView();
      ?>
  </body>
</html>
