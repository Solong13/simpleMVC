<?php

namespace System;

use System\Database\Connection;
use System\Database\QuerySelect;
use System\Database\SelectBuilder;
use System\Exceptions\ExcValidation;

abstract class Model{
	protected static $instance;
	protected Connection $db;
	protected string $table;
	protected string $pk;
	protected array $validationRules;
	protected Validator $validator;

	public static function getInstance() : static{
		if(static::$instance === null){
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function __construct(){
		$this->db = Connection::getInstance();
		$this->validator = new Validator($this->validationRules);
	}

	public function all() : array{
		return $this->selector()->get();
	}

	public function get(int $id) : ?array{
		$res = $this->selector()->where("{$this->pk} = :pk", ['pk' => $id])->get();
		return $res[0] ?? null;
	}

	public function selector() : QuerySelect{
		$builder = new SelectBuilder($this->table);
		return new QuerySelect($this->db, $builder);
	}

	public function add(array $fields) : int{
		$isValid = $this->validator->run($fields);

		if(!$isValid){
			throw new ExcValidation();
		}

		$names = [];
		$masks = [];

		foreach($fields as $field => $val){
			$names[] = $field;
			$masks[] = ":$field";
		}

		$namesStr = implode(', ', $names);
		$masksStr = implode(', ', $masks);

		$query = "INSERT INTO {$this->table} ($namesStr) VALUES ($masksStr)";
		$this->db->query($query, $fields);
		return $this->db->lastInsertId();
	}

	public function remove(int $id) : bool
	{
		// rowCount у prepareStatment
		$query = "DELETE FROM {$this->table} WHERE {$this->pk} = :pk";
		$this->db->query($query, ['pk' => $id]);
		return $this->db->rowCount() > 0;

	}

	public function edit(int $id, array $fields) : int{
		$isValid = $this->validator->run($fields);

		if(!$isValid){
			throw new ExcValidation();
		}

		$pairs = [];

		foreach($fields as $field => $val){
			$pairs[] = " $field=:$field";
		}

		$pairsStr = implode(', ', $pairs);

		$query = "UPDATE {$this->table} SET $pairsStr WHERE {$this->pk} = :{$this->pk}";
		$this->db->query($query, $fields + [$this->pk => $id]);// + Можна викор замість array_marge()
		return true;// Чому true? це особливість роботи rowCount що бд не викинула виключення
	}   

}