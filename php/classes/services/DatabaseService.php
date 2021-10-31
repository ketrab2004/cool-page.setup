<?php

/**
 * A service used to safely execute mysql queries using a PDO
 * 
 * Example usage:
 * ```php
 * $db = new DatabaseService();
 * 
 * $db->query("INSERT INTO people (firstName, lastName, age) VALUES (:fname, :lname, :age)");
 * 
 * $db->bind(":fname", "John");
 * $db->bind(":lname", "Doe", PDO::PARAM_STR);
 * $db->bind(":age", 21);
 * 
 * $db->execute();
 * ```
 * 
 * @author ketrab2004 <bartek@fos.nl>
 */
class DatabaseService {
    protected string        $host;
    protected string        $dbName;
    protected string        $user;
    protected string        $pass;

    protected PDO           $dbh;

    protected PDOStatement  $stmt;

    protected PDOException  $error;
    protected array         $qError;


    public function __construct()
    {
        // non-local database info
        $this->host = "";
        $this->user = "";
        $this->pass = "";
        $this->dbName = "";

        if ( IsLocalService::check() ) // if local change to local database info
        {
            $this->host = "localhost";
            $this->user = "root";
            $this->pass = "";
            $this->dbName = "cool-page-setup";
        }

        // dsn for mysql
        $dsn = "mysql:host=". $this->host .";dbname=". $this->dbName;

        $options = array(
            PDO::ATTR_PERSISTENT=> true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );


        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch (PDOException $e)
        {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Sets a query to be used when @see $this->execute()
     * and to be filled with @see $this->bind()
     * 
     * Example usage:
     * ```php
     * $db->query("INSERT INTO people
     *      (firstName, lastName, age)
     *      VALUES (:fname, :lname, :age)");
     * ```
     *
     * @param string $query
     */
    public function query(string $query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    /**
     * Bind a value to a spot inside the given @see $this->query()
     * 
     * Example usage:
     * ```php
     * $db->bind(":fname", "John");
     * $db->bind(":lname", "Doe");
     * $db->bind(":age", "21", PDO::PARAM_INT);
     * ```
     *
     * @param string $param string to "replace" inside the query with the given $value ```":fname"```
     * @param mixed $value the value to put into the given $param slot ```"Doe"```
     * @param ?int $type the ```PDO::PARAM_*``` type, when null/not given it will choose one itself
     */
    public function bind(string $param, mixed $value, int $type = null)
    {
        //when type given, figure out what type it is
        if(is_null($type)){
            switch (true){
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

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Executes the build up query
     * 
     * If there is an error it will be saved in @see $this->qError
     * 
     * which can be read using @see $this->getQueryError()
     */
    public function execute()
    {
        return $this->stmt->execute();

        $this->qError = $this->dbh->errorInfo();
    }

    /**
     * returns all results from the executed query
     * 
     * Example:
     * ```php
     * $db->execute()
     * echo $db->resultset()[2]["firstName"];
     * ```
     * @return array the results of the query as an array of associative arrays.
     */
    public function resultset(): array
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array the first row of the resultset as an associative array.
     */
    public function single(): mixed
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return integer amount of rows the executed query returned
     */
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    /**
     * @return string represents the id of the last inserted row
     */
    public function lastInsertId(): string
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }
    public function endTransaction()
    {
        return $this->dbh->commit();
    }
    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    //region getter functions

    public function getPDOConnection(): PDO
    {
        return $this->dbh;
    }
    public function getPDOStatement(): PDOStatement
    {
        return $this->stmt;
    }

    public function getPDOError(): PDOException
    {
        return $this->error;
    }
    public function getQueryError(): array
    {
        return $this->qError;
    }

    //endregion

    /**
     * @deprecated do not use this function, instead use ->query(), ->bind() and ->execute()
     */
    public function getConnection(): mysqli
    {
        return mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
    }
}
