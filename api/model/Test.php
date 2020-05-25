<?php

class User
{
    private $id;
	private $username;

	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
}

class CrudApplication
{
	public function selectAll()
	{
		$query = 'SELECT * FROM ' . $this->tableName;
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}

	public function selectOneBy($params)
	{
		foreach ($params as $key => $val) {}

		$query = 'SELECT * FROM ' . $this->tableName . ' WHERE ' . $key . ' =:' . $key;
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(':' . $key, $val);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}
}

class UserRepository extends CrudApplication
{
	protected $pdo;
	protected $tableName = 'users';

	private $user;

	public function __construct(PDO $pdo, User $user)
    {
		$this->pdo = $pdo;
		$this->user = $user;
	}
}

class Response 
{
	public static function get($stmt)
	{
		$num = $stmt->rowCount();
	
		if ($num > 0)
		{
			$items = [];
	
			while ($row = $stmt->fetch())
			{
				array_push($items, $row);
			}
			
			http_response_code(200); // OK
			echo json_encode($items);
		}
		else
		{
			http_response_code(404); // Not found
			echo json_encode(['message' => 'No records found.']);
		}
	}
}

require_once __DIR__.'/../config/core.php';

$userRepository = new UserRepository($db->getConnection(), new User);

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$stmt = $userRepository->selectAll();
	Response::get($stmt);
}