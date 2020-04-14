<?php
abstract class Database
{
    protected $conn = null;
    protected $sql = "";
    protected $stmt = "";
    protected $table = null;
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->sql = "SET NAMES utf8";
            $this->stmt = $this->conn->prepare($this->sql);
            $this->stmt;
        } catch (PDOException $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ",PDO Connection: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        } catch (Exception $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ",PDO Connection: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        }
    }
    /**SELECT Query */
    final protected function select($args = array(), $is_debug = false)
    {
        try {
            /**
             * SELECT fields FROM table
             * WHERE caluse
             */
            $this->sql = "SELECT ";
            if (isset($args['fields']) && !empty($args['fields'])) {
                // fields set
                if (is_array($args['fields'])) {
                    $this->sql .= implode(", ", $args['fields']);
                } else {
                    $this->sql .= $args['fields'];
                }
            } else {
                $this->sql .= " * ";
            }
            $this->sql .= " FROM ";
            if (!isset($this->table) || $this->table == null) {
                throw new Exception("Table not set.");
            }
            $this->sql .= $this->table;
            /**** Join Operation */
            /**** Join Operation */

            /**** Where Operation */
            if (isset($args['where']) && !empty($args['where'])) {
                if (is_string($args['where'])) {

                    $this->sql .= " WHERE " . $args['where'];
                } else {
                    $temp = array();
                    foreach ($args['where'] as $column_name => $value) {
                        $str = $column_name . " = :" . $column_name;
                        $temp[] = $str;
                    }
                    $this->sql .= " WHERE " . implode(" AND ", $temp);
                }
            }
            /**** Where Operation */
            /*** Group By */
            /*** Group By */
            /*** Order By */
            if (isset($args['order_by']) && !empty($args['order_by'])) {
                $this->sql .= " ORDER BY " . $args['order_by'];
            } else {
                $this->sql .= " ORDER BY " .$this->table.".id DESC";
            }
            /*** Order By */
            /*** LIMIT */
            if (isset($args['limit']) && !empty($args['limit'])) {
                $this->sql .= " LIMIT " . $args['limit'];
            }
            /*** LIMIT */

            if ($is_debug) {
                debug($args);
                debug($this->sql, true);
            }
            $this->stmt = $this->conn->prepare($this->sql);
            if (isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {
                foreach ($args['where'] as $column_name => $value) {
                    if (is_int($value)) {
                        $param = PDO::PARAM_INT;
                    } else if (is_bool($value)) {
                        $param = PDO::PARAM_BOOL;
                    } else {
                        $param = PDO::PARAM_STR;
                    }
                    if (isset($param)) {
                        $this->stmt->bindValue(":" . $column_name, $value, $param);
                    }
                }
            }
            $this->stmt->execute();
            $data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
            return $data;
        } catch (PDOException $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ", PDO Select: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        } catch (Exception $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ",PDO Select: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        }
    }
    /**UPDATE Query */
    final protected function update($data = array(), $args = array(), $is_debug = false)
    {
        try {
            /**
             * UPATDE table
             * column_name =value,
             * column_name_1= 'value_1', 
             * ..............,
             * column_name_n =value_n,
             */
            $this->sql = "UPDATE ";
            if (!isset($this->table) || $this->table == null) {
                throw new Exception("Table not set.");
            }
            $this->sql .= $this->table . " SET ";
            if (!isset($data) || empty($data)) {
                throw new Exception('Data not set for Update.');
            } else {
                if (is_string($data)) {
                    $this->sql .= $data;
                } else {
                    $temp = array();
                    foreach ($data as $column_name => $value) {
                        $str = $column_name . " = :_" . $column_name;
                        $temp[] = $str;
                    }
                    $this->sql .= implode(", ", $temp);
                }
            }
            /**** Where Operation */
            if (isset($args['where']) && !empty($args['where'])) {
                if (is_string($args['where'])) {

                    $this->sql .= " WHERE " . $args['where'];
                } else {
                    $temp = array();
                    foreach ($args['where'] as $column_name => $value) {
                        $str = $column_name . " = :" . $column_name;
                        $temp[] = $str;
                    }
                    $this->sql .= " WHERE " . implode(" AND ", $temp);
                }
            }
            /**** Where Operation */
            if ($is_debug) {
                debug($args);
                debug($this->sql, true);
            }
            $this->stmt = $this->conn->prepare($this->sql);
            if (isset($data) && !empty($data) && is_array($data)) {
                foreach ($data as $column_name => $value) {
                    if (is_int($value)) {
                        $param = PDO::PARAM_INT;
                    } else if (is_bool($value)) {
                        $param = PDO::PARAM_BOOL;
                    } else {
                        $param = PDO::PARAM_STR;
                    }

                    if (isset($param)) {
                        $this->stmt->bindValue(":_" . $column_name, $value, $param);
                    }
                }
            }
            if (isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {
                foreach ($args['where'] as $column_name => $value) {
                    if (is_int($value)) {
                        $param = PDO::PARAM_INT;
                    } else if (is_bool($value)) {
                        $param = PDO::PARAM_BOOL;
                    } else {
                        $param = PDO::PARAM_STR;
                    }
                    if (isset($param)) {
                        $this->stmt->bindValue(":" . $column_name, $value, $param);
                    }
                }
            }
            return $this->stmt->execute();
        } catch (PDOException $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ", PDO Select: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        } catch (Exception $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ",PDO Select: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        }
    }
    /**INSERT Query */
    final protected function insert($data = array(), $is_debug = false)
    {
        try {
            /**
             * INSERT INTO table SET
             * column_name =value,
             * column_name_1= 'value_1', 
             * ..............,
             * column_name_n =value_n,
             */
            $this->sql = "INSERT INTO ";
            if (!isset($this->table) || $this->table == null) {
                throw new Exception("Table not set.");
            }
            $this->sql .= $this->table . " SET ";
            if (!isset($data) || empty($data)) {
                throw new Exception('Data not set for Update.');
            } else {
                if (is_string($data)) {
                    $this->sql .= $data;
                } else {
                    $temp = array();
                    foreach ($data as $column_name => $value) {
                        $str = $column_name . " = :_" . $column_name;
                        $temp[] = $str;
                    }
                    $this->sql .= implode(", ", $temp);
                }
            }
            if ($is_debug) {
                debug($data);
                debug($this->sql, true);
            }
            $this->stmt = $this->conn->prepare($this->sql);
            if (isset($data) && !empty($data) && is_array($data)) {
                foreach ($data as $column_name => $value) {
                    if (is_int($value)) {
                        $param = PDO::PARAM_INT;
                    } else if (is_bool($value)) {
                        $param = PDO::PARAM_BOOL;
                    } else {
                        $param = PDO::PARAM_STR;
                    }
                    if (isset($param)) {
                        $this->stmt->bindValue(":_" . $column_name, $value, $param);
                    }
                }
            }
            $this->stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ", PDO Insert: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        } catch (Exception $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ",PDO Insert: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        }
    }
    /**DELETE Query */
    final protected function delete($args = array(), $is_debug = false)
    {
        try {
            /**
             * DELETE FROM table
             * WHERE caluse
             */
            $this->sql = "DELETE FROM ";
            if (!isset($this->table) || $this->table == null) {
                throw new Exception("Table not set.");
            }
            $this->sql .= $this->table;
            /**** Where Operation */
            if (isset($args['where']) && !empty($args['where'])) {
                if (is_string($args['where'])) {
                    $this->sql .= " WHERE " . $args['where'];
                } else {
                    $temp = array();
                    foreach ($args['where'] as $column_name => $value) {
                        $str = $column_name . " = :" . $column_name;
                        $temp[] = $str;
                    }
                    $this->sql .= " WHERE " . implode(" AND ", $temp);
                }
            }
            /**** Where Operation */
            if ($is_debug) {
                debug($args);
                debug($this->sql, true);
            }
            $this->stmt = $this->conn->prepare($this->sql);
            if (isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {
                foreach ($args['where'] as $column_name => $value) {
                    if (is_int($value)) {
                        $param = PDO::PARAM_INT;
                    } else if (is_bool($value)) {
                        $param = PDO::PARAM_BOOL;
                    } else {
                        $param = PDO::PARAM_STR;
                    }
                    if (isset($param)) {
                        $this->stmt->bindValue(":" . $column_name, $value, $param);
                    }
                }
            }
            return $this->stmt->execute();
        } catch (PDOException $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ", PDO Delete: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        } catch (Exception $e) {
            //2020-02-25 7:20 AM, PDO Connection: connection could not br established.
            $msg = date('Y-m-d h:i A') . ", PDO Delete: " . $e->getMessage() . "\r\n";
            error_log($msg, 3, ERROR_LOG);
        }
    }
}
