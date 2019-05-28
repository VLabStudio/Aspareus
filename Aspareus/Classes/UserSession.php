
<?php
  class UserSession
  {
    	// Methods
    	function SetSession($username, $password)
    	{
    		if (!isset($_SESSION))
    		{
    			session_start();
    		}

    		// Set session variables
    		$_SESSION["username"] = $username;
    		$_SESSION["password"] = $password;
    	}

    	function GetSession()
    	{
    		if (!isset($_SESSION))
    		{
    			session_start();
    		}

    		if (!empty($_SESSION["username"]) && !empty($_SESSION["password"]))
    		{
    			$session = array();

    			// Get session variables
    			$session[0] = $_SESSION["username"];
    			$session[1] = $_SESSION["password"];
    			require 'ConnectDB.php';

    			$statement = $DBH->prepare("SELECT UserID,UserName,Password,Name,CompanyInitials FROM users WHERE UserName=? AND Password=?;");
    			$statement->bindParam(1, $session[0]);
    			$statement->bindParam(2, $session[1]);
    			$statement->execute();
    			while ($row = $statement->fetch())
    			{
    				$session[2] = $row['Name'];
    				$session[3] = $row['CompanyInitials'];
            $session[4] = $row['UserID'];
    			}

          $statement = $DBH->prepare("SELECT companyusers.CompanyID FROM companyusers JOIN users ON companyusers.UserID=?;");
          $statement->bindParam(1, $session[4]);
          $statement->execute();
          while ($row = $statement->fetch())
          {
            $session[5] = $row['CompanyID'];
          }

    			return $session;
    		}
    	}

    	function GetSessionWithID($ID)
    	{
    		if (!empty($ID))
    		{
    			require 'ConnectDB.php';

    			$session = array();
    			$statement = $DBH->prepare("SELECT UserName,Password,Name,CompanyInitials FROM users WHERE UserID=?;");
    			$statement->bindParam(1, $ID);
    			$statement->execute();
    			while ($row = $statement->fetch())
    			{
    				$session[0] = $row['UserName'];
    				$session[1] = $row['Password'];
    				$session[2] = $row['Name'];
    				$session[3] = $row['CompanyInitials'];
    			}

    			return $session;
    		}
    	}

    	function IsSession()
    	{
    		if (!isset($_SESSION))
    		{
    			session_start();
    		}

    		if (!empty($_SESSION["username"]) && !empty($_SESSION["password"]))
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}

    	function FindID($username, $password)
    	{
    		if (!empty($username) && !empty($password))
    		{
    			require 'ConnectDB.php';

    			$statement = $DBH->prepare("SELECT * FROM users WHERE UserName=? and Password=?");
    			$statement->bindParam(1, $username);
    			$statement->bindParam(2, $password);
    			$statement->execute();
    			while ($row = $statement->fetch())
    			{
    				return $row['UserID'];
    			}

    			// Close the connection
    			$DBH = null;
    		}
    	}

    	function GetUserType($userID)
    	{
    		require 'ConnectDB.php';

    		$statement = $DBH->prepare("SELECT users.UserName,types.TypeName FROM users JOIN usertypes ON usertypes.UserID = users.UserID JOIN types ON types.TypeID = usertypes.TypeID WHERE users.UserID=?;");
    		$statement->bindParam(1, $userID);
    		$statement->execute();
    		while ($row = $statement->fetch())
    		{
    			return $row['TypeName'];
    		}
    	}

    	function UpdateUserName($name, $initials)
    	{
    		require 'ConnectDB.php';

    		require_once 'Helper.php';

    		$helper = new Helper();
    		$user = $this->GetSession();
    		$newUserName = $helper->GenerateUserName($name, $initials, $this->GetUserType($this->FindID($user[0], $user[1])));
    		$statement = $DBH->prepare("UPDATE users SET UserName=? WHERE UserID = " . $this->FindID($user[0], $user[1]) . ";");
    		$statement->bindParam(1, $newUserName);
    		$statement->execute();
    		$this->SetSession($newUserName, $user[1]);
    		$DBH = null;
    		$helper = null;
    		return $newUserName;
    	}

    	function UpdateUserNameWithID($name, $initials, $ID)
    	{
    		require 'ConnectDB.php';

    		require_once 'Helper.php';

    		$helper = new Helper();
    		$newUserName = $helper->GenerateUserName($name, $initials, $this->GetUserType($ID));
    		$statement = $DBH->prepare("UPDATE users SET UserName=? WHERE UserID = " . $ID . ";");
    		$statement->bindParam(1, $newUserName);
    		$statement->execute();
    		$DBH = null;
    		$helper = null;
    		return $newUserName;
    	}

      function GetCompanyID()
      {
        require 'ConnectDB.php';

        $user = $this->GetSession();

        $statement = $DBH->prepare("SELECT companyusers.CompanyID FROM companyusers JOIN users ON companyusers.UserID=?;");
        $statement->bindParam(1, $user[4]);
        $statement->execute();
        while ($row = $statement->fetch())
        {
          return $row['CompanyID'];
        }
      }
  }
?>
