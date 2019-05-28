<!DOCTYPE html>
<html>
<head>
  <title>Aspareus - Sign In</title>
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

      include '../Menus/MainMenu.php';

      $UIGenerator->StartClass("UIBoxSmall ElementCenter TopSpacingSmall");
        $UIGenerator->StartFormAutomatic("POST");

            $UIGenerator->GenerateCustomElementWithClass("h1","Sign In","TextCenter TopSpacingMedium BottomSpacingMedium");

            $UIGenerator->GenerateInputWithClassRequired("text","inputUserName","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter User Name");

            $UIGenerator->GenerateInputWithClassRequired("password","inputPassword","","ElementCenter TopSpacingSmall BottomSpacingSmall UserInput ExtraBig","Enter Password");

            $UIGenerator->GenerateInputWithClass("submit","submit","Sign In","SubmitButton Medium ElementCenter TopSpacingSmall BottomSpacingSmall","");

        $UIGenerator->EndForm();

      header('Cache-Control: no cache');
      session_cache_limiter('private_no_expire');

      if (!empty($_POST["inputUserName"]) && !empty($_POST["inputPassword"]))
       {
          require_once '../Classes/Validate.php';
          $validate = new Validate();

          if($validate->Check($_POST["inputUserName"],$_POST["inputPassword"]))
          {
            echo "<div class='Message-Valid'> Login Valid </div>";
            header('Location: Home.php');
          }
          else
          {
            echo "<div class='Message-Invalid'> Login Invalid </div>";
          }
      }
       ?>
     </div>
  </body>
</html>
