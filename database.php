<?php

class database { 

    protected $db;

    function __construct($db_server, $db_user, $db_pass, $db_name)
    {
        $this->db = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }

    /**
     * Get a single record from a table as an object.
     */
    function get_record(string $table, array $conditions = null, string $fields = '*', string $sort = null, string $limit = null) {

        $sql =
        "SELECT {$fields} FROM {$table} ";

        if (isset($conditions)) {
            foreach ($conditions as $key => $val) {
                if (reset($conditions) == $val) {
                    $sql .= " WHERE {$key} = '{$val}' ";
                } else {
                    $sql .= " AND {$key} = '{$val}' ";
                }
            }
        }

        if (isset($sort)) {
            $sql .= " ORDER BY {$sort}";
        }

        if (isset($limit)) {
            $sql .= " LIMIT {$sort}";
        }

        if ($result = $this->db->query($sql)) {
            return $result->fetch_object();
        }
        
        return false;
    }

    /**
     * Get records from a table as an array of objects.
     */
    function get_records(string $table, array $conditions = null, string $fields = '*', string $sort = null, int $limit = null) {

        $sql =
        "SELECT {$fields} FROM {$table} ";

        if (isset($conditions)) {
            foreach ($conditions as $key => $val) {
                if (reset($conditions) == $val) {
                    $sql .= " WHERE {$key} = '{$val}' ";
                } else {
                    $sql .= " AND {$key} = '{$val}' ";
                }
            }
        }

        if (isset($sort)) {
            $sql .= " ORDER BY {$sort} ";
        }

        if (isset($limit)) {
            $sql .= " LIMIT {$limit}";
        }

        if ($result = $this->db->query($sql)) {
            $records = [];

            while ($obj = $result->fetch_object()) {
                $records[] = $obj;
            }

            return $records;
        }

        return false;
    }

    function get_records_sql($sql, array $params = null) {
        if ($result = $this->db->query($sql)) {
            $records = [];

            while ($obj = $result->fetch_object()) {
                $records[] = $obj;
            }

            return $records;
        }

        return false;
    }

    function insert_record($table, array $params) {

        $sql = "INSERT INTO {$table} ";

        $fields = '(';
        $values = 'VALUES(';

        $i = 0;
        foreach ($params as $key => $val) {
            $v = $this->convert_variable($val);
            if ($i == 0) {
                $fields .= $key;
                $values .= $v;
            } else {
                $fields .= ", {$key}";
                $values .= ", {$v}";
            }
            $i++;
        }

        $fields .= ") ";
        $values .= ")";

        $sql .= $fields . $values;

        return $this->db->query($sql);
    }

    private function convert_variable($var) {
        switch (gettype($var)) {
            case 'integer':
                return $var;
            
            case 'string':
                return "'{$var}'";

            case 'double':
                return "'{$var}'";

            case 'NULL':
                return "''";

            case 'boolean':
                return $var;

            default:
                return $var;
        }
    }
}