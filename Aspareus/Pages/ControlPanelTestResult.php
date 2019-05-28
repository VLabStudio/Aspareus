<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Results</title>
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

              $user = $userSession->GetSession();
              $ID = $user[4];

              if($userSession->GetUserType($ID) == "Company")
              {
                $UIGenerator->GenerateCustomElementWithClass("h1","Tests","TextLeft TextStyle");

                $statement = $DBH->prepare("SELECT UserName,tests.Name,Result,companyuserresults.TestID FROM companyuserresults JOIN companytests ON companytests.TestID=companyuserresults.TestID JOIN tests ON companytests.TestID=tests.TestID JOIN users ON users.UserID=companyuserresults.UserID WHERE companytests.CompanyID=?");
                $statement->bindParam(1, $ID);
                $statement->execute();
                while ($row = $statement->fetch())
                {
                   $UIGenerator->StartClass("UIBoxExtraBig GridViewLeftElementExtraBig TopSpacingSmall");
                      $UIGenerator->GenerateCustomElementWithClass("h3","Result for ".$row['UserName'] ." in ".$row['Name'],"TextLeft");
                      $UIGenerator->GenerateCustomElementWithClass("p",$row['UserName']." have correctly answered ".$row['Result']." of ".$helper->GetNumberOfTests($row['TestID'])." questions","TextLeft");
                   $UIGenerator->EndClass();
                }
                if(count($row) <= 0)
                {
                  $UIGenerator->GenerateCustomElementWithClass("h1","No Results","GridViewCenterElementExtraBig ExtraBig TextCenter TextStyle");
                }
              }
            }
         $UIGenerator->EndClass();
       $UIGenerator->EndGridView();
      ?>
  </body>
</html>
