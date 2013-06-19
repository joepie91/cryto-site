<?php
/*
 * Cryto is more free software. It is licensed under the WTFPL, which
 * allows you to do pretty much anything with it, without having to
 * ask permission. Commercial use is allowed, and no attribution is
 * required. We do politely request that you share your modifications
 * to benefit other developers, but you are under no enforced
 * obligation to do so :)
 * 
 * Please read the accompanying LICENSE document for the full WTFPL
 * licensing text.
 */
 
if(!isset($_APP)) { die("Unauthorized."); }

class User extends CPHPDatabaseRecordClass
{
	public $table_name = "users";
	public $fill_query = "SELECT * FROM users WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM users WHERE `Id` = :Id";
	
	public $prototype = array(
		'string' => array(
			'Username'		=> "Username",
			'Hash'			=> "Hash",
			'Salt'			=> "Salt",
			'EmailAddress'		=> "EmailAddress"
		),
		'boolean' => array(
			'IsAdmin'		=> "Admin",
			'IsBanned'		=> "Banned"
		),
		'timestamp' => array(
			"RegistrationDate"	=> "RegistrationDate"
		)
	);
	
	public function GenerateSalt()
	{
		$this->uSalt = random_string(10);
	}
	
	public function GenerateHash()
	{
		if(!empty($this->uSalt))
		{
			if(!empty($this->uPassword))
			{
				$this->uHash = $this->CreateHash($this->uPassword);
			}
			else
			{
				throw new Exception("User object is missing a password.");
			}
		}
		else
		{
			throw new Exception("User object is missing a salt.");
		}
	}
	
	public function CreateHash($input)
	{
		global $cphp_config;
		$hash = crypt($input, "$5\$rounds=50000\${$this->uSalt}{$cphp_config->salt}$");
		$parts = explode("$", $hash);
		return $parts[4];
	}
	
	public function VerifyPassword($password)
	{
		if($this->CreateHash($password) == $this->sHash)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function Authenticate()
	{
		$_SESSION['user_id'] = $this->sId;
		$_SESSION['logout_key'] = random_string(32);
		$_SESSION['is_admin'] = $this->sIsAdmin;
		
		$this->SetGlobalVariables();
	}
	
	public function Deauthenticate()
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['is_admin']);
	}
	
	public function SetGlobalVariables()
	{
		NewTemplater::SetGlobalVariable("my-username", $this->sUsername);
		NewTemplater::SetGlobalVariable("logout-key", $_SESSION['logout_key']);
	}
	
	public static function CheckIfUsernameExists($username)
	{
		try
		{
			$result = User::FindByUsername($username);
			return true;
		}
		catch (NotFoundException $e)
		{
			return false;
		}
	}
	
	public static function FindByUsername($username)
	{
		return self::CreateFromQuery("SELECT * FROM users WHERE `Username` = :Username", array(':Username' => $username), 0, true);
	}
	
	public static function CheckIfEmailAddressExists($username)
	{
		try
		{
			$result = User::FindByEmailAddress($username);
			return true;
		}
		catch (NotFoundException $e)
		{
			return false;
		}
	}
	
	public static function FindByEmailAddress($email)
	{
		return self::CreateFromQuery("SELECT * FROM users WHERE `EmailAddress` = :EmailAddress", array(':EmailAddress' => $email), 0, true);
	}
}
