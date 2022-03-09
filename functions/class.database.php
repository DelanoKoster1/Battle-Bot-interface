<?php

class Database extends PDO {
    private string $host;
    private string $database;
    private string $password;
    private string $user;

    public function __construct(string $host = 'localhost', string $user = 'root', string $database = '', string $password = '') {
        $this->host = $host;
        $this->database = $database;
        $this->password = $password;
        $this->user = $user;
        $this->connect();
    }

    public function getHost() : string {
        return $this->host;
    }
    public function getDatabase() : string {
        return $this->database;
    }
    public function getPassword() : string {
        return $this->password;
    }
    public function getUser() : string {
        return $this->user;
    }

    public function setHost(string $host) : void {
        $this->host = $host;
        $this->connect();
    }
    public function setDatabase(string $database) : void {
        $this->database = $database;
        $this->connect();
    }
    public function setPassword(string $password) : void {
        $this->password = $password;
        $this->connect();
    }
    public function setUser(string $user) : void {
        $this->user = $user;
        $this->connect();
    }

    public function connect(?string $database = NULL) : bool {
        try {
            $db = ($database !== NULL) ? $database : $this->database;
            $dsn = "mysql:host=".$this->host.";dbname=".$db.";charset=UTF8";
            parent::__construct($dsn, $this->user, $this->password);
            return true;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    public function createDatabase(array $sqlFileArray) : bool {
        foreach($sqlFileArray as $sql) {
            if(!$this->stmtExec($sql)) {
                return false;
            }
        }
        return true;
    }

    // public function getPassword(int $id) : array | false {
    //     $sql = "SELECT Password FROM Account WHERE Id = ?"

    //     return $this->stmtExec($sql, $id);
    // }

    private function stmtExec(string $sql, mixed ...$bind) : array | false {
        try {
            $stmt = $this->prepare($sql);
            $bind = ($bind == array(NULL)) ? NULL : $bind;
            $stmt->execute($bind);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $results;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }
}