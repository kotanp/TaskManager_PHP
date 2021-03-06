<?php

namespace App\Core;
use PDO;

abstract class Model{
    public static $connection;
    protected static $table;
    //protected $primaryKey = 'id';
    // protected $keyType = 'int';
    //protected $foreignKey;

    public static function all(){
        $query = 'SELECT * FROM ' . static::$table;
        $statement = self::$connection->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    public static function find($taskId){
        $query = 'SELECT * FROM ' . static::$table . ' WHERE id='.$taskId;
        $statement = self::$connection->prepare($query);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    public static function update(Model $model, $taskId){
        $setString = '';
        foreach ($model as $column => $value) {
            $setString = $setString . $column . '="' . $value . '",';
        }
        $setString = substr_replace($setString,'',-1);
        $query = 'UPDATE ' . static::$table . ' SET ' . $setString . ' WHERE id='.$taskId;
        $statement = self::$connection->prepare($query);
        $statement->execute();
    }

    public static function save(Model $model){
        $columnString = '';
        $valueString = '';
        foreach ($model as $column => $value) {
            $columnString = $columnString . $column . ',';
            $valueString = $valueString . "'$value'" . ',';
        }
        $columnString = substr_replace($columnString,'',-1);
        $valueString = substr_replace($valueString,'',-1);
        $query = 'INSERT INTO ' . static::$table . '  (' . $columnString . ') VALUES (' . $valueString .')';
        $statement = self::$connection->prepare($query);
        if ($statement->execute()) {
            return true;
        }
        return false;
    }

    public static function delete($taskId){
        $query = 'DELETE FROM ' . static::$table . ' WHERE id='.$taskId;
        $statement = self::$connection->prepare($query);
        $statement->execute();
        if ($statement->execute()) {
            return true;
        }
        return false;
    }

    public static function getColumnCount(){
        $query = 'SELECT * FROM ' . static::$table;
        $statement = self::$connection->query($query);
        $columnCount = $statement->columnCount();
        return $columnCount;
    }

    public static function getColumnNames(){
        $query = 'SELECT * FROM ' . static::$table;
        $statement = self::$connection->query($query);
        $column = $statement->columnCount();
        for ($i=0; $i < $column; $i++) { 
            $meta = $statement->getColumnMeta($i);
            $columnNames[] = $meta['name'];
        }
        
        return $columnNames;
    }

    public static function expand($tableJoined, $localKey, $foreignKey, $relationName){
        //$query = 'SELECT * FROM ' . static::$table . ' INNER JOIN ' . $tableJoined . ' ON ' . static::$table . '.' . $localKey . '=' . $tableJoined . '.' . $foreignKey;
        $query = 'SELECT * FROM ' . static::$table;
        $queryJoined = 'SELECT * FROM ' . $tableJoined;
        $statement = self::$connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $statementJoined = self::$connection->query($queryJoined)->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0; $i <count($statement) ; $i++) { 
            $row = $statement[$i];
            $statement[$i][$relationName] = array_values(array_filter($statementJoined, function($statementJoinedRow) use($row,$localKey,$foreignKey){
                if ($row[$localKey] === $statementJoinedRow[$foreignKey]) {
                    return $statementJoinedRow;
                }
            }));
        }
        return json_encode($statement);
    }

}