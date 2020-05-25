<?php

class CrudApplication
{
    private $pdo;
    private $tableName;
    
    // public function __construct(PDO $pdo, $tableName)
    // {
    //     $this->pdo = $pdo;
    //     $this->tableName = $tableName;
	// }
    
    public function selectOneById()
    {
        $query = 'SELECT * FROM ' . $this->tableName . ' WHERE id=:id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
    }
	
	public function selectAll()
	{
		$query = 'SELECT * FROM ' . $this->tableName;
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
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