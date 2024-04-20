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
    function get_record(string $table, array $conditions = null, string $fields = '*', string $sort = null) {

        $sql =
        "SELECT {$fields} FROM {$table} ";

        if (isset($conditions)) {
            foreach ($conditions as $key => $val) {
                if (reset($conditions) == $val) {
                    $sql .= " WHERE {$key} = {$val} ";
                } else {
                    $sql .= " AND {$key} = {$val} ";
                }
            }
        }

        if (isset($sort)) {
            $sql .= " ORDER BY {$sort}";
        }

        $result = $this->db->query($sql);
        
        return $result->fetch_object();
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
                    $sql .= " WHERE {$key} = {$val} ";
                } else {
                    $sql .= " AND {$key} = {$val} ";
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
}