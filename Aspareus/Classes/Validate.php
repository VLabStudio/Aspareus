<?php
    class Validate {
        // Methods
        function Check($username,$password)
        {
          if (!empty($username) && !empty($password))
          {
            require 'ConnectDB.php';
            require_once 'UserSession.php';

            $validate =  false;

            $statement = $DBH->prepare("SELECT * FROM users WHERE UserName=? and Password=?");
            $statement->bindParam(1, $username);
            $statement->bindParam(2, $password);
            $statement->execute();

            while ($row = $statement->fetch()) {
                $validate = true;

                $userSession = new UserSession();
                $userSession->SetSession($username,$password);
             }

             // Close the connection
             $DBH = null;

             return $validate;
         }
        }
    }
?>
