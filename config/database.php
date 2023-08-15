<?php
class Database
{
	private $dsn;
	private $username;
	private $password;
	private $options;
	protected $conn;

	public function __construct($dsn, $username, $password, $options = [])
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;
		$this->options = $options;
	}

	public function open()
	{
		try {
			$this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);
			return $this->conn;
		} catch (PDOException $e) {
			echo "There is some problem in the connection: " . $e->getMessage();
		}
	}

	public function close()
	{
		$this->conn = null;
	}
}

$server = "mysql:host=localhost;port=3307;dbname=fruitshop";
$username = "root";
$password = "";
$options  = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

$pdo = new Database($server, $username, $password, $options);
