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

	public function create()
    {
        $query = 'INSERT INTO ' . $this->tableName . ' SET ' . join(',', $this->entity['preps']);

        $stmt = $this
            ->pdo
            ->prepare($query);

        return $stmt->execute($this->entity['val']);
    }
}

class Entity extends CrudApplication
{
	protected $pdo;
	protected $entity;
	protected $tableName;

	public function __construct(PDO $pdo, string $tableName)
  	{
		$this->pdo = $pdo;
		$this->tableName = $tableName;
	}

	public function parse($obj)
	{
		if (!is_object($obj)) 
		{
			return false;
		}

		$classMethods = get_class_methods($obj);
		$assoc_arr = [];
		$preps = [];
		$val = null;

		foreach ($classMethods as $methodName) 
		{
			// if method name starts with get
			if ($methodName[0] === 'g')
			{
				$val = $obj->{$methodName}();

				if (isset($val)) 
				{
					$key = strtolower( substr($methodName, 3) );
					$assoc_arr[':'.$key] = $val;
					$preps[] = $key . '=:' . $key;
				}
			}
		}

		$this->entity['preps'] = $preps;
		$this->entity['val'] = $assoc_arr;
		// print_r($this->entity);
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

	public static function post($stmn)
	{
        if ($stmn == 1)
        {
            http_response_code(201);
            echo json_encode(['message' => 'Record was created.']);
        }
        else
        {
            http_response_code(503); // 503 service unavailable
            echo json_encode(['message' => 'Unable to create a record.']);
        } 
	}
}

class Validator
{
	public static function validate($obj)
	{
		if (!is_object($obj)) 
		{
			return true;
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

		return false;
	}
}

require_once __DIR__.'/../config/core.php';

$entity = new Entity($db->getConnection(), 'users');

// if ($_SERVER['REQUEST_METHOD'] === 'GET')
// {
// 	$stmt = $entity->selectOneBy(['id' => 1]);
// 	Response::get($stmt, $isSingleRow = true);
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST')
// {
// 	$data = json_decode(file_get_contents('php://input'));

	$user = new User;
	$user->setUsername('<br>dad</br>');

	$error = Validator::validate($user);

	if (!$error) 
	{
		$entity->parse($user);
		$stmt = $entity->create();
		Response::post($stmt);
	}

// }