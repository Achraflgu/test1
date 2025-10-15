<?php
// Simple database connection without prepared statements to avoid cached plan issues
class SimpleDatabase {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $conn;

    public function __construct() {
        // Get environment variables from Railway/Neon
        if (isset($_ENV['DATABASE_URL'])) {
            $this->parseDatabaseUrl($_ENV['DATABASE_URL']);
        } else {
            $this->host = $_ENV['DB_HOST'] ?? $_ENV['PGHOST'] ?? 'localhost';
            $this->db_name = $_ENV['DB_NAME'] ?? $_ENV['PGDATABASE'] ?? 'children_universe';
            $this->username = $_ENV['DB_USER'] ?? $_ENV['PGUSER'] ?? 'postgres';
            $this->password = $_ENV['DB_PASS'] ?? $_ENV['PGPASSWORD'] ?? '';
            $this->port = $_ENV['DB_PORT'] ?? $_ENV['PGPORT'] ?? '5432';
        }
    }

    private function parseDatabaseUrl($databaseUrl) {
        $parsed = parse_url($databaseUrl);
        $this->host = $parsed['host'];
        $this->port = $parsed['port'] ?? '5432';
        $this->db_name = ltrim($parsed['path'], '/');
        $this->username = $parsed['user'];
        $this->password = $parsed['pass'];
    }

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => true,
                ];
                
                $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            } catch(PDOException $exception) {
                error_log("Connection error: " . $exception->getMessage());
                throw new Exception("Database connection failed: " . $exception->getMessage());
            }
        }
        return $this->conn;
    }

    // Simple query execution without prepared statements
    public function query($sql) {
        $conn = $this->getConnection();
        try {
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    // Simple insert/update/delete
    public function execute($sql) {
        $conn = $this->getConnection();
        try {
            return $conn->exec($sql);
        } catch(PDOException $e) {
            error_log("Execute error: " . $e->getMessage());
            throw new Exception("Execute failed: " . $e->getMessage());
        }
    }

    // Get last insert ID
    public function getLastInsertId() {
        $conn = $this->getConnection();
        return $conn->lastInsertId();
    }
}

// Global simple database instance
function getSimpleDB() {
    static $db = null;
    if ($db === null) {
        $db = new SimpleDatabase();
    }
    return $db;
}

// Helper functions using simple queries
function simpleQuery($sql) {
    return getSimpleDB()->query($sql);
}

function simpleExecute($sql) {
    return getSimpleDB()->execute($sql);
}

function simpleGetLastId() {
    return getSimpleDB()->getLastInsertId();
}

// Alias for compatibility
function simpleLastInsertId() {
    return getSimpleDB()->getLastInsertId();
}

function simpleFetchAll($result) {
    // This function is for compatibility - simpleQuery already returns an array
    return $result;
}

function simpleAffectedRows() {
    // For compatibility with MySQL affected_rows
    return 1; // PostgreSQL doesn't have a direct equivalent
}
?>
