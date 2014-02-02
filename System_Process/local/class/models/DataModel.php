<?php

namespace \local\models;


class DataModel {

    protected $table_name;
    protected $id_where;
    public $id;
    protected $id_field;
    protected $fields_default = array();
    public $fields = array();
    private $field_types = array();
    private static $no_id = -1;
    protected static $instance = array(-1 => null);
	

    public static function obj($id = null, $admin = FALSE) {
        $class = get_called_class();
        if ($id === null) {
            $id = self::$no_id;
        }
        if (!isset(self::$instance[$id]) || !(self::$instance[$id] instanceof $class)) {
            self::$instance[$id] = new $class($id);
        }
           
        return self::$instance[$id];
    }
	

    public function __construct($id) {
    	/*
        $db = db::obj();
        if (strpos($this->table_name, '.') !== FALSE) {
            $tmp = explode('.', $this->table_name);
            $database_name = $tmp[0];
            $table_name = $tmp[1];
        } else {
            $database_name = $db->quote(config::$db_info['dbname']);
            $table_name = $this->table_name;
        }
        $table_name = $db->quote($table_name);
        $database_name = $db->quote($database_name);
        $sql = <<<EOT
SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = $database_name and TABLE_NAME = $table_name   
EOT;

        $field_info = $db->fetch_assoc($sql, 'COLUMN_NAME');

        foreach ($field_info as $info) {
            $this->fields_default[$info['COLUMN_NAME']] = null;
            $this->field_types[$info['COLUMN_NAME']] = $info['DATA_TYPE'];
        }

        if (count($this->fields_default) && $id > -1) {
            $this->id = $id;
            $this->id_where = '`' . $this->id_field . '` = ' . $db->quote($this->id);

            $this->fields_default = $db->get_one('SELECT ' . implode(', ', array_keys($this->fields_default)) . ' FROM ' . $this->table_name . ' WHERE ' . $this->id_where);
        }

        $this->fields = $this->fields_default;
        logger::obj()->write("\n");
        logger::obj()->write("Field Default");
        logger::obj()->write($this->fields_default);
        logger::obj()->write("Fields");
        logger::obj()->write($this->fields);
		 * 
		 */
    }
	
	
    protected function get_delta() {
        $delta = array();
        if ($this->fields_default != $this->fields) {
            foreach ($this->fields_default as $i => $field) {
                if ($field != $this->fields[$i]) {
                    $delta[$i] = $this->fields[$i];
                }
            }
        }
        if (array_keys($this->fields_default) != array_keys($this->fields)) {
            logger::obj()->write('Incorrect field assignment', 0);
            $delta = array();
        }
        
        return $delta;
    }
	

    private function get_changed_sql_update($changed) {
        $sql_set = 'SET ';
        $values = array();

        foreach ($changed as $i => $field) {
            $values[] = $this->has_sql_format($i, $field);
            $sql_set .= $i . ' = ?, ';
        }
        $sql_set = substr($sql_set, 0, -2);
        return array($sql_set, $values);
    }
	

    private function get_changed_sql_insert($changed) {
        $sql_set = '(' . implode(', ', array_keys($changed)) . ') VALUES (';
        $values = array();
        foreach ($changed as $i => $field) {
            $values[] = $this->has_sql_format($i, $field);
            $sql_set .= '?, ';
        }
        $sql_set = substr($sql_set, 0, -2) . ')';

        return array($sql_set, $values);
    }

    private function has_sql_format($name, $data) {
        $type = $this->field_types[$name];
        switch ($type) {
            case 'date':
                sanitize::clean($data);
                $data = date('Y-m-d', strtotime($data));
                break;
        }

        return $data;
    }

    public function commit() {
        $commit = FALSE;
        $num_rows = 0;
        $db = db::obj();
        logger::obj()->write('commit');

        $changed = $this->get_delta();

        logger::obj()->write($changed);

        try {
            $db->beginTransaction();
            if ($this->id == -1) {
                $this->id = null;
            }
            
            if (!empty($changed)) {
                if ($this->id) { // update
                    list($sql, $values) = $this->get_changed_sql_update($changed);
					$commit = $num_rows = $db->update($this->table_name, array($this->id_field => $his->id), $values);
                } else { // insert
                    list($sql, $values) = $this->get_changed_sql_insert($changed);
                    $commit = $this->fields[$this->id_field] = $this->id = $db->insert($this->table_name, $values);
                    self::$instance[$this->id] = self::$instance[self::$no_id];
					self::$instance[self::$no_id] = null;
                }
            } else {
                $commit = null;
            }

            if ($commit === TRUE) {
                $db->commit();
                logger::obj()->write('Row updated/inserted into table: ' . $this->table_name . '. Row ID: ' . $this->id);
                $commit = ($num_rows == 1 ? TRUE : null);
            } else if ($commit !== null) {
                $db->rollBack();
                $commit = FALSE;
            }
        } catch (Exception $e) {
            $db->rollBack();
            $commit = FALSE;
            logger::obj()->write('FAILED: ' . $this->table_name . '. Row ID: ' . $this->id);
        }

        logger::obj()->write('commit');

        
        return $commit;
    }

}