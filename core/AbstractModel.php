<?php

namespace Core;
use PDO;
use PDOException;

abstract class AbstractModel
{
    use Responser;

    protected $table;
    protected $id;
    private $fields = [];

    private $conn;

    private $selecting = false;
    private $condition = false;
    private $joining = false;
    private $ordering = false;
    private $grouping = false;

    private $query;
    private $order;
    private $orderMethod;
    private $group;

    private $selects = [];
    private $wheres = [];
    private $joins = [];

    public function __construct($table, $fields)
    {
        $this->setTable($table);
        $this->setFields($fields);

        $this->conn = DBConnection::getInstance()->getConnection();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }
    
    public function getFields()
    {
        return $this->fields;
    }
    
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function all()
    {
        $sql = "SELECT * FROM " . $this->getTable();

        try {
            $stmt = $this->conn->query($sql);
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rs;
        } catch (PDOException $e) {
            $this->errorResponse("Error: " . $e->getMessage(), 500);
        }
    }

    public function find($id)
    {
        $sql = "SELECT * FROM " . $this->getTable() . " WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs;
        } catch (PDOException $e) {
            $this->errorResponse("Error: " . $e->getMessage(), 500);
        }
    }

    public function get()
    {
        $this->buildQuery();
        $sql = $this->getQuery();

        try {
            $stmt = $this->conn->query($sql);
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rs;
        } catch (PDOException $e) {
            $this->errorResponse("Error: " . $e->getMessage(), 500);
        }
    }


    public function select($fields)
    {
        $this->selecting = true;

        foreach ($fields as $field) {
            $this->selects[] = $field;
        }

        return $this;
    }

    public function save($data)
    {
        sort($this->fields);
        $values = '';
        $fields = '';

        foreach ($this->fields as $field) {
            $fields .= $field . ', ';
            $values .= "'". $data[$field] . "', " ;
        }

        $fields = rtrim($fields, ', ');
        $values = rtrim($values, ', ');

        $sql = 'INSERT INTO '. $this->getTable() . ' ('. $fields . ') VALUES ('. $values . ')';
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->errorResponse("Error: " . $e->getMessage(), 500);
        }
    }

    public function update($id, $data)
    {
        $result = false;
        sort($this->fields);
        $fields = '';
        
        foreach ($data as $field => $value)
            $fields .= $field . " = '" . $value . "', ";

        $fields = rtrim($fields, ', ');
        $sql = "UPDATE ". $this->getTable(). " SET $fields WHERE id = ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            
            $result = true;
        } catch (PDOException $e) {
            $this->errorResponse("Error: " . $e->getMessage(), 500);
        }

        return $result;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTable() . " WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            $this->errorResponse("Error: " . $e->getMessage(), 500);
        }
    }

    public function where($field, $condition)
    {
        $this->condition = true;

        if (empty($this->wheres)) {
            $this->wheres[] = " WHERE " . $field . " = '" . $condition . "'";
        } else {
            $this->wheres[] = " AND " . $field . " = '" . $condition . "'";
        }

        return $this;
    }

    public function whereWithOperator($field, $operator, $condition)
    {
        $this->condition = true;

        if (empty($this->wheres)) {
            $this->wheres[] = " WHERE " . $field . " " . $operator . " '" . $condition . "'";
        } else {
            $this->wheres[] = " AND " . $field . " " . $operator . " '" . $condition . "'";
        }

        return $this;
    }

    public function orWhere($field, $condition)
    {
        $this->condition = true;
        $this->wheres[] = " OR " . $field . " = '" . $condition . "'";

        return $this;
    }

    public function orWhereWithOperator($field, $operator, $condition)
    {
        $this->condition = true;
        $this->wheres[] = " OR " . $field . " " . $operator . " '" . $condition . "'";

        return $this;
    }
    
    public function join($table, $on, $equality, $type = 'INNER')
    {
        $this->joining = true;
        $this->joins[] = " " . strtoupper($type) . " JOIN " . $table . " ON " . $on . " = " . $equality;

        return $this;
    }

    public function orderBy($field, $method = 'ASC')
    {
        $this->ordering = true;
        $this->order = $field;
        $this->orderMethod = $method;

        return $this;
    }

    public function groupBy($field)
    {
        $this->grouping = true;
        $this->group = $field;

        return $this;
    }

    private function buildQuery()
    {
        $this->query = "SELECT ";

        if ($this->selecting) {
            $this->query .= implode(', ', $this->selects);
        } else {
            $this->query .= "*";
        }

        $this->query .= " FROM " . $this->getTable();

        if ($this->joining) {
            $this->query .= implode('', $this->joins);
        }

        if ($this->condition) {
            $this->query .= implode('', $this->wheres);
        }

        if ($this->grouping) {
            $this->query .= " GROUP BY " . $this->group;
        }

        if ($this->ordering) {
            $this->query .= " ORDER BY " . $this->order . " " . $this->orderMethod;
        }
    }
}
