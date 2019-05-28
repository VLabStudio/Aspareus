<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Tests</title>
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
            $user = $userSession->GetSession();
            $ID = $user[4];

            if($userSession->GetUserType($ID) == "User")
            {
                $UIGenerator->GenerateCustomElementWithClass("h1","Tests","TextLeft ");

                $statement = $DBH->prepare("SELECT tests.TestID,Name,Description FROM tests RIGHT JOIN companytests ON tests.TestID=companytests.TestID WHERE companytests.CompanyID=?;");
                $statement->bindParam(1, $user[5]);
                $statement->execute();
                while ($row = $statement->fetch())
                {
                   echo '<a href="TakeTest.php?id='.$row['TestID'].'" class="LinkStyle" >';
                   $UIGenerator->StartClass("UIBoxExtraBig GridViewLeftElement TopSpacingSmall UIBoxSelected");
                      $UIGenerator->GenerateCustomElementWithClass("h2",$row['Name'],"TextLeft");
                      $UIGenerator->GenerateCustomElementWithClass("p",$row['Description'],"TextLeft");
                   $UIGenerator->EndClass();
                   echo '</a>';
                }
              }
            }
          $UIGenerator->EndClass();
        $UIGenerator->EndGridView();
      ?>
  </body>
</html>
