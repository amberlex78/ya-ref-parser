<?php

class DB {

    private $dbh;
    private $stmt;

    public function __construct($user, $pass, $dbname, $host = 'localhost', $charset = 'utf8')
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $opt = [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $this->dbh = new PDO($dsn, $user, $pass, $opt);
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
        return $this;
    }

    public function bind($pos, $value, $type = null)
    {
        if( is_null($type) ) {
            switch( true ) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($pos, $value, $type);
        return $this;
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function all()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function one()
    {
        $this->execute();
        return $this->stmt->fetch();
    }
}