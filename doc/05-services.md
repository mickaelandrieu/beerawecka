# Service container

The `Services` class helps to manage application dependencies.

This class is used to create and store the objects
that should be instantiated once
and which can be used in all the application components.

For an exemple you can use this class to store the database connection :

    protected $pdo;

    public function pdo()
    {
        if($this->pdo === null) {

            $dsn = 'mysql:dbname=testdb;host=127.0.0.1';
            $user = 'dbuser';
            $password = 'dbpass';

            $this->pdo = $dbh = new PDO($dsn, $user, $password);
        }

        return $this->pdo;
    }

This class is a singleton, the `getInstance()` method gives access
to the unique instance of this class. 
    
    \App\Core\Services::getInstance()->pdo();

If you controller extends `App\Core\Controller`,
you can use the following shortcut:

    $this->get->pdo();