<?php
    class Helper {
        // Methods
        function GenerateUserName($name,$initials,$type)
        {
          if (!empty($name) && !empty($initials) && !empty($type))
          {
            $UserName = "";

            if($type == "User") {
              $UserName = $name.rand(1000, 9999)."@".$type.".".$initials;
            } else {
              $UserName = $name."@".$type.".".$initials;
            }

            $UserName =  strtolower($UserName);
            $UserName = str_replace(" ", "-", $UserName);

            return $UserName;
          }
        }

        function GetTestName($ID)
        {
          require 'ConnectDB.php';

          $statement = $DBH->prepare("SELECT Name FROM tests WHERE TestID=?");
          $statement->bindParam(1, $ID);
          $statement->execute();
          while ($row = $statement->fetch())
          {
            return $row['Name'];
          }
        }

        function GetNumberOfTests($ID)
        {
          require 'ConnectDB.php';
          $num = 0;
          $statement = $DBH->prepare("SELECT questions.Answer FROM tests LEFT JOIN questions ON tests.TestID=questions.TestID WHERE tests.TestID=?;");
          $statement->bindParam(1, $_COOKIE['TestID']);
          $statement->execute();
          while ($row = $statement->fetch())
          {
            $num++;
          }
          return $num;
        }
    }
?>
