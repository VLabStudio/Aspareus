<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Take Test</title>
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

        header('Cache-Control: no cache');
        session_cache_limiter('private_no_expire');

        // Test ID
        if (!empty($_GET["id"]))
        {
          setcookie("TestID", $_GET["id"], time() + (86400 * 30), "/");
          header('Location: TakeTest.php');
        }
          $UIGenerator->StartClass("GridViewCenter");
            $UIGenerator->StartFormAutomatic("POST");
              $UIGenerator->StartClass("UIBoxExtraBig GridViewCenterElementExtraBig TopSpacingSmall");
                 $helper = new Helper();
                 $UIGenerator->GenerateCustomElementWithClass("h1",$helper->GetTestName($_COOKIE['TestID']),"TextCenter TextStyle");

                 $statement = $DBH->prepare("SELECT questions.QuestionID,questions.Title FROM questions WHERE questions.TestID=?;");
                 $statement->bindParam(1, $_COOKIE['TestID']);
                 $statement->execute();
                 $questionNum = 0;
                 while ($row = $statement->fetch())
                 {
                    echo "<li> <fieldset> <legend>Question ".($questionNum + 1)."</legend>";
                    $UIGenerator->GenerateCustomElementWithClass("h4",$row['Title'],"TextLeft TextStyle");

                    $statementOption = $DBH->prepare("SELECT Option FROM options WHERE OptionID=?;");
                    $statementOption->bindParam(1, $row['QuestionID']);
                    $statementOption->execute();
                    while ($rowOption = $statementOption->fetch())
                    {
                        $rt = rand(1000, 9999);

                        $option = $rowOption['Option'];
                        $codeCharacters = array('"', "{", "}", "}", "'", "[", "]", ";");
                        $safeCharacters = array("SC_1", "SC_2", "SC_3", "SC_4","SC_5", "SC_6", "SC_7", "SC_8");

                        $safeOption = str_replace($codeCharacters, $safeCharacters, $option);

                        $UIGenerator->GenerateCheckboxWithClassWithId("question_".$questionNum,$option,$safeOption,false,"CheckboxStyle Big",$rt);
                    }

                    echo "<br> </fieldset> </li>";
                    $questionNum++;
                 }
                 $UIGenerator->GenerateInputWithClass("submit","submitForm","Test Results","SubmitButton Medium ElementCenter TopSpacingSmall BottomSpacingSmall","");
               $UIGenerator->EndClass();
            $UIGenerator->EndForm();
         $UIGenerator->EndClass();

         if (!empty($_POST["submitForm"]))
            {
              $numTests =  $helper->GetNumberOfTests($_COOKIE['TestID']);

              $questions = array();
              $answers  = array();

              $statement = $DBH->prepare("SELECT questions.Answer FROM tests LEFT JOIN questions ON tests.TestID=questions.TestID WHERE tests.TestID=?;");
              $statement->bindParam(1, $_COOKIE['TestID']);
              $statement->execute();
              while ($row = $statement->fetch())
              {
                  $questions[] = $row['Answer'];
              }

              for ($i=0; $i < $numTests; $i++) {
                if (!empty($_POST["question_" . $i]))
                {
                  $codeCharacters = array('"', "{", "}", "}", "'", "[", "]", ";");
                  $safeCharacters = array("SC_1", "SC_2", "SC_3", "SC_4","SC_5", "SC_6", "SC_7", "SC_8");

                  $answers[$i] = str_replace($safeCharacters, $codeCharacters, $_POST["question_" . $i]);
                }
              }

              $numCorrectAnswers = 0;
              for ($i=0; $i < count($answers); $i++) {
                if($answers[$i] == $questions[$i]){
                  $numCorrectAnswers++;
                }
              }

              $resultID = rand(100000000, 999999999);
              $userSession = new UserSession();
              $user =  $userSession->GetSession();

              $statement = $DBH->prepare("INSERT INTO `companyuserresults` (`ResultID`, `TestID`, `UserID`, `Result`) VALUES (?, ?, ?, ?);");
              $statement->bindParam(1, $resultID);
              $statement->bindParam(2, $_COOKIE['TestID']);
              $statement->bindParam(3, $user[4]);
              $statement->bindParam(4, $numCorrectAnswers);
              $statement->execute();

              if($numCorrectAnswers != 0)
              {
                  echo("<script>location.href = 'TestResult.php?Result=You have correctly answered ".$numCorrectAnswers." of ".$numTests." questions'</script>");
              }
              else {
                  echo("<script>location.href = 'TestResult.php?Result=You werent paying attention!'</script>");
              }
            }
           $UIGenerator->EndGridView();
         ?>
  </body>
</html>
