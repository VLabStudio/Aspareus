<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Test Result</title>
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
            $helper = new Helper();

            $UIGenerator->StartGridView();
            $UIGenerator->StartClass("GridViewTop");
             include '../Menus/MainMenu.php';
            $UIGenerator->EndClass();

            $UIGenerator->StartClass("GridViewLeft");
             include '../Menus/SideMenu.php';
            $UIGenerator->EndClass();

            $UIGenerator->StartClass("GridViewCenter");
              $UIGenerator->StartClass("UIBoxExtraBig GridViewLeftElement TopSpacingSmall TextCenter");
                $UIGenerator->GenerateCustomElement("h1","Test Result");
                if(!empty($_GET['Result']))
                  $UIGenerator->GenerateCustomElement("h2",$_GET['Result']);
                $UIGenerator->EndClass();
              $UIGenerator->EndClass();
            $UIGenerator->EndGridView();
          ?>
        </div>
      </div>
  </body>
</html>
