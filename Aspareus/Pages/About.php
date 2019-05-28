<!DOCTYPE html>
<html>
  <head>
    <title>Aspareus - About</title>
    <link rel="stylesheet" type="text/css" href="../Menus/Css/Style.css">
    <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Base.css">
    <link rel="stylesheet" type="text/css" href="../UIGenerator/Css/Styles/Metro.css">
    <link rel="icon" href="../Icons/Favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../Icons/Favicon.ico" type="image/x-icon" />
  </head>
  <body>
    <?php
        require '../UIGenerator/Classes/UIGenerator.php';
        $UIGenerator = new UIGenerator();

        $UIGenerator->StartGridView();

        $UIGenerator->StartClass("GridViewTop");
           include '../Menus/MainMenu.php';
        $UIGenerator->EndClass();

        $UIGenerator->StartClass("GridViewCenterSmall LeftSpacingSmall RightSpacingSmall");
          $UIGenerator->GenerateCustomElementWithClass("p","A system for creating and holding tests for users.","TextStyle");
        $UIGenerator->EndClass();

        $UIGenerator->EndGridView();
    ?>
  </body>
</html>
