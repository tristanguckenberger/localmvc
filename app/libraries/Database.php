<?php

/*
 * PDO Database class
 * Connect to Database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */

class Database {
    private $host   = DB_HOST;
    private $user   = DB_USER;
    private $pass   = DB_PASS;
    private $dbname = DB_NAME;

    /*
     * database handler
     * use whenever we prepare a statement
     */
    private $dbh;

    /*
     * database prepared stmt
     * $pdo->prepare($sql);
     */
    private $stmt;

    /*
     * variable for any errors
     */
    private $error;

    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            /*
             * Creates a persistent connection, improves performance by checking to see if
             * Connection already exists
             */
            PDO::ATTR_PERSISTENT => true,
            // MORE elegant way to handle errors, than adding the two lines at the top
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instance with try catch block
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);

        }catch(PDOException $e){
            echo 'Connection unsuccessful!';
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /*
     * Method to add queries
     * Prepare statement with query
     */
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);

    }

    /*
     * Method to bind values
     */
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
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

    /*
     * Execute the prepared statement
     */
    public function execute(){
        return $this->stmt->execute();
    }

    /*
     * Get result set as array of objects
     */
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchall(PDO::FETCH_OBJ);
    }

    /*
     * Get single record as object
     */
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /*
     * Get row count
     */
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}
?>