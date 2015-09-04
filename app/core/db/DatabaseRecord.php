<?php

class DatabaseRecord {
    private static $deleteQuery = 'DELETE FROM `%1$s` WHERE id=?';
    private static $insertQuery = 'INSERT INTO `%1$s` (%2$s) VALUES (%3$s)';
    private static $listQuery   = 'SELECT * FROM `%s`';
    private static $listByFieldQuery = 'SELECT * FROM `%1$s` WHERE %2$s=?';
    private static $selectQuery = 'SELECT * FROM `%1$s` WHERE id=?';
    private static $updateQuery = 'UPDATE `%1$s` SET %2$s WHERE id=?';
    private static $lastIdQuery = 'SELECT LAST_INSERT_ID()';
    private static $existQuery = 'SELECT EXISTS(SELECT * FROM %1$s WHERE %2$s=?) as isExist';
    private static $charsetQuery = 'SET NAMES %1$s';
    
    private static $defaultEncording = 'utf8';
    private static $db = null;

    private $fields   = [];
    private $loaded   = false;
    private $modified = false;
    private $id       = null;
    private $class    = null;
    private $table    = null;
    
    public function __construct($id = null) {
        self::initDatabase();

        $this->id = $id;
        $this->class = get_class($this);
        $this->table = strtolower($this->class);
    }

    public function __get($name) {
        if ( $this->modified ) {
            throw new InvalidOperationException;
        }
        
        $this->load();

        if ( $name == $this->parent ) {
            return $this->getParent($name);
        }
        if ( in_array($name, $this->childrens) ) {
            return $this->getChildren($name);
        }
        
        return $this->getColumn($name);
    }

    public function __set($name, $value) {
        $value = str_replace("'", "''", $value);
        $this->setColumn($name, $value);
    }

    public function delete() {
        if ( $this->id == NULL ) {
            throw new InvalidOperationException;
        }
        
        $query = sprintf(self::$deleteQuery, $this->table);

        $this->execute($query, array($this->id), false);
    }

    public function getColumn($name) {
        if ( $name == 'id' ) {
            return $this->id;
        }
        if ( $name == $this->parent ) {

            if ( isset($this->fields[$name . '_id']) ) {
                return $this->fields[$name . '_id'];
            } else {
                return $this->fields[$this->table . '_' . $name . '_id'];
            }
        }

        return $this->fields[$name];
    }

    public function getParent($name) {
        return new User($this->getColumn($name));
    }

    public function getChildren($name) {
        $type = ucfirst($name);

        return new $type;
    }

    public function save() {
        if ( $this->modified ) {
            if ( $this->id == NULL ) {
                $this->insert();
            } else {
                $this->update();
            }
        }
        
        $this->modified = false;
    }

    public function setColumn($name, $value) {
        $this->fields[$name] = $value;
        $this->modified = true;
    }
    
    public static function checkExists($table, $field, $value) {
        return self::execute(sprintf(self::$existQuery, $table, $field), array($value));
    }

    public static function findOne($id = null) {
        if ( !$id ) {
            return;
        }

        $type = get_called_class();

        return new $type($id);
    }
    
    public static function all() {
        self::initDatabase();
        
        $type = get_called_class();
        $table = strtolower($type);
        $objList = [];
        $rowCount;
        
        $list = self::$db->query(sprintf(self::$listQuery, $table));
        $list = $list->fetchAll(PDO::FETCH_ASSOC);
        $rowCount = count($list);
            
        for ( $i = 0; $i < $rowCount; $i++ ) {
            $obj = new $type;
            $obj->id = $list[$i]['id'];
            $obj->fields = $list[$i];
            $obj->loaded = true;
            $obj->table = $table;
            
            $objList[] = $obj;
        }
        
        return $objList;
    }

    public static function allWhere($field, $value) {
        self::initDatabase();

        $type = get_called_class();
        $table = strtolower($type);
        $objList = [];
        $rowCount;

        $list = self::execute(sprintf(self::$listByFieldQuery, $table, $field), [$value], 'list');

        $rowCount = count($list);

        for ( $i = 0; $i < $rowCount; $i++ ) {
            $obj = new $type;
            $obj->fields = $list[$i];
            $obj->loaded = true;
            $obj->table = $table;

            $objList[] = $obj;
        }

        return $objList;
    }

    public static function setDatabase(PDO $db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            echo "Error connect to DB: " . $e->getMessage() . "\n";
        }
        
        self::setEncording();
    }

    public static function setEncording($encording = null) {
        if ( !$encording ) {
            $encording = self::$defaultEncording;
        }
        
        self::execute(sprintf(self::$charsetQuery, $encording), array(), false);
    }
    
    private function execute($query, $args, $returningData = 'single') {
        $query = self::$db->prepare($query);
        //var_dump($query);
        //die();
        try {
            $query->execute($args);
        } catch (PDOException $e) {
            echo $e->getMessage() . "\n";
        }
        
        if ( $returningData == 'single' ) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else if ( $returningData == 'list' ) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    private function insert() {
        $fieldsStr = '';
        $valuesStr = '';
        
        foreach ($this->fields as $field => $value) {
            $fieldsStr .= $field . ",";
            $valuesStr .= "'" . $value . "',";
        }
        $fieldsStr = rtrim($fieldsStr, ",");
        $valuesStr = rtrim($valuesStr, ",");
        //var_dump($this->fields);
        $query = sprintf(
            self::$insertQuery,
            $this->table,
            $fieldsStr,
            $valuesStr
        );
        
        $this->execute($query, array(), false);
        $this->id = $this->execute(self::$lastIdQuery, array())['LAST_INSERT_ID()'];
        $this->loaded = true;
    }

    private function load() {
        if ( $this->id == NULL || $this->loaded ) {
            return false;
        }

        $row = $this->execute(sprintf(self::$selectQuery, $this->table), array($this->id));

        foreach ($this->columns as $column) {
            $this->fields[$column] = $row[$column];
        }

        $this->modified = false;
        $this->loaded = true;
        
        return true;
    }

    private function update() {
        $modifiedFieldsStr = '';
        
        foreach ($this->fields as $field => $value) {
            $modifiedFieldsStr .= $field . "='" . $value . "',";
        }
        $modifiedFieldsStr = rtrim($modifiedFieldsStr, ",");
        
        $query = sprintf(self::$updateQuery, $this->table, $modifiedFieldsStr);
        $this->execute($query, array($this->id), false);
    }

    private static function initDatabase() {
        if ( self::$db === null ) {
            throw new DatabaseException();
        }
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
