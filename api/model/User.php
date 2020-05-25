<?php

require_once __DIR__.'/../src/CrudApplication.php';

class User extends CrudApplication
{
	protected $pdo;
	protected $tableName = 'users';

    protected $id;
    protected $username;

    public function __construct(PDO $pdo)
    {
		$this->pdo = $pdo;
	}

	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($username)
	{
		$this->username = htmlspecialchars(strip_tags($username));
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = htmlspecialchars(strip_tags($id));
	}

	public static function test() 
	{
        var_dump(get_object_vars($this));
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->tableName . ' SET username=:username';

        $stmt = $this
            ->pdo
            ->prepare($query);

        $stmt->bindParam(':username', $this->username);

        return $stmt->execute();
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->tableName . ' SET username = :username WHERE id = :id';

        $stmt = $this
            ->pdo
            ->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}