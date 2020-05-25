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

	// public function create()
 //    {
 //    	$this->entity
 //        $query = 'INSERT INTO ' . $this->tableName . ' SET username=:username';

 //        $stmt = $this
 //            ->pdo
 //            ->prepare($query);

 //        $stmt->bindParam(':username', $this->username);

 //        return $stmt->execute();
 //    }
}

class UserRepository extends CrudApplication
{
	protected $pdo;
	protected $tableName = 'users';

	protected $entity;

	public function __construct(PDO $pdo)
  	{
		$this->pdo = $pdo;
	}

	public function setEntity(User $user)
	{
		$this->entity = $entity;
	}
}

class Response 
{
	public static function get($stmt, $isSingleRow = false)
	{
		$num = $stmt->rowCount();
	
		if ($num > 0)
		{
			if ($isSingleRow === false)
			{
				$items = [];
		
				while ($row = $stmt->fetch())
				{
					array_push($items, $row);
				}
			}
			else
			{
				$items = $stmt->fetch();
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

	public static function post($data)
	{
		if (empty($data->username))
	    {
	    	http_response_code(400); // 400 bad request
	        echo json_encode(['message' => 'Unable to create record. Data is incomplete.']);
	        return;
	    }
 
        $user->setUsername($data->username);

        if ($user->create())
        {
            http_response_code(201);
            echo json_encode(['message' => 'User was created.']);
        }
        else
        {
            http_response_code(503); // 503 service unavailable
            echo json_encode(['message' => 'Unable to create a user.']);
        } 
	}
}

class Validation
{
	public static function validate($obj)
	{
		if (!is_object($obj)) 
		{
			exit();
		}

		$classMethods = get_class_methods($obj);
		$val = null;

		foreach ($classMethods as $methodName) 
		{
			// if method name starts with get
			if ($methodName[0] === 'g')
			{
				$val = $obj->{$methodName}();
			}
			// if method name starts with set
			else if ($methodName[0] === 's') 
			{
				if (isset($val))
				{
					$obj->{$methodName}( htmlspecialchars( strip_tags($val) ) );
				}
			}
		}
	}
}

require_once __DIR__.'/../config/core.php';

$userRepository = new UserRepository($db->getConnection());

// if ($_SERVER['REQUEST_METHOD'] === 'GET')
// {
// 	$stmt = $userRepository->selectOneBy(['id' => 1]);
// 	Response::get($stmt, $isSingleRow = true);
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST')
// {
// 	$data = json_decode(file_get_contents('php://input'));

	$user = new User;
	$user->setUsername('<br>Azamat</br>');

	Validation::validate($user);

// 	$userRepository->setEntity($user);

// 	$stmt = $userRepository->create();
// 	Response::post($stmt);
// }