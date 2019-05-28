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

        if($userSession->IsSession())
         {
          $user = $userSession->GetSession();
          if($userSession->GetUserType($userSession->FindID($user[0],$user[1])) == "Company")
           {
              $statement = $DBH->prepare("SELECT tests.TestID,Name FROM tests RIGHT JOIN companytests ON tests.TestID=companytests.TestID WHERE companytests.CompanyID=?;");
              $statement->bindParam(1, $userSession->FindID($user[0],$user[1]));
              $statement->execute();

              $Fetch = null;

              while ($row = $statement->fetch())
              {
                 $Fetch[] = $row['TestID'];
                 $Fetch[] = $row['Name'];
                 $Fetch[] = '
                 <form action="ControlPanelTestsEdit.php" method="post">
                   <input type="hidden" name="UserID" value="'.$row['TestID'].'">
                   <button type="submit" class="SubmitButton">Edit</button>
                 </form>';
              }

              if(count($Fetch) > 0) {
              $UIGenerator->GenerateTableWithClass(array("Test ID","Name","Edit"),$Fetch,"TableStyle LeftSpacingSmall TopSpacingSmall");
              } else {
                $UIGenerator->GenerateCustomElementWithClass("h1","No Tests","GridViewCenterElementExtraBig ExtraBig TextCenter TextStyle");
              }

              $DBH = null;
            }
         }
      $UIGenerator->EndClass();
     $UIGenerator->EndGridView();
    ?>
  </body>
</html>
