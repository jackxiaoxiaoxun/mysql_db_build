<?php





class pdo_db
{
	public $pdo;

	public function pdo_connect()
	{
		if ($this->host	== '')
			$host	= 'default';
		else
			$host	= $this->host[0];
		
		if (empty($this->pdo[$host]))
		{
			$this->pdo[$host]	= new \PDO($dsn,$user, $pass);
			$this->pdo[$host]->table_prefix	= $prefix;
		}
		return $this->pdo[$host];
	}
	
	public function query($sql, $data = [])
	{
		try {
			$pdo	= $this->pdo_connect();
			$return = '';
			$sql	= str_replace('<<_', $pdo->table_prefix, $sql);
			$prepare	= $pdo->prepare($sql);
			foreach ($data as $key => $value)
			{
				$pdo->bindValue($key, $value);
			}
			$result		= $prepare->execute();
			switch (strtolower($sql[0]))
			{
				case 's':
					$return		= $prepare->fetchAll();
					break;
				case 'i':
					$return		= $pdo->lastInsertId();
					break;
				case 'd':
				case 'u':
					$return		= $prepare->rowCount();
					break;
				default:
					$return		= $prepare->fetchAll();
			}

			$this->setNull();
			return $return;
		} catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}




