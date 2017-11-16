<?php

namespace SGBD;

class Query{

	private $sqltable;
	private $fields='*';
	private $where=null;
	private $args=[];
	private $sql='';

	public static function table(string $table){
		$query=new Query;
		$query->sqltable=$table;
		return $query;
	}

	public function where($col, $op, $val){
		if($this->where==null){
			$this->where="WHERE $col $op ?";
		}else{
			$this->where.=" AND $col $op ?";
		}
		$this->args[]=$val;
		return $this;
	}

	public function select(array $fields){
		$this->fields=implode(',',$fields);
		return $this;
	}

	public function get(){
		$pdo=connectionFactory::makeConnection();
		$this->sql='SELECT '.$this->fields.' FROM '.$this->sqltable.' '.$this->where;
		$stmt=$pdo->prepare($this->sql);
		$stmt->execute($this->args);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function delete(){
		$pdo=connectionFactory::makeConnection();
		$this->sql = "DELETE FROM ".$this->sqltable." ".$this->where;
		$stmt=$pdo->prepare($this->sql);
		$stmt->execute($this->args);
	}

	public function insert(array $insert){
		$pdo=connectionFactory::makeConnection();
		$into = '';
		$values = '';

		foreach ($insert as $key=>$val)
		{
			$this->args[]=$val;
			if($into == ''){
				$into = $key;
				$values = '?';
			}
			else{
				$into .= ','.$key;
				$values .= ','.'?';
			}
		}
		$this->sql = "INSERT INTO ".$this->sqltable
				." ( ".$into." ) VALUES ( "
				.$values." )";
		$stmt=$pdo->prepare($this->sql);
		$stmt->execute($this->args);
		return (int)$pdo->lastInsertId();
	}
}
