<!DOCTYPE html>
<html>
  <head>
    <title>Aspareus - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../Menus/Css/Style.css">
    <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Base.css">
    <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Styles/Metro.css">
    <link rel="icon" href="../Icons/Favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="../Icons/Favicon.ico" type="image/x-icon"/>
  </head>
  <body>
    <?php
        require '../UIGenerator/Classes/UIGenerator.php';
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
                require_once '../Classes/UserSession.php';
                $userSession = new UserSession();

                $user = $userSession->GetSession();

                if ($userSession->GetUserType($userSession->FindID($user[0], $user[1])) == "Admin") {
                    $UIGenerator->GenerateCustomElementWithClass("h1","Admin Dashboard","TextStyle");
                } else if ($userSession->GetUserType($userSession->FindID($user[0], $user[1])) == "Company") {
                    $UIGenerator->GenerateCustomElementWithClass("h1","Company Dashboard","TextStyle");
                }

                $UIGenerator->GenerateCustomElementWithClass("p","This is the dashboard","TextStyle");
              }
          $UIGenerator->EndClass();
      $UIGenerator->EndGridView();
    ?>
  </body>
</html>
