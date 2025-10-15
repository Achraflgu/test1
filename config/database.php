<?php
// PostgreSQL Database Configuration for Vercel
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $conn;

    public function __construct() {
        // Get environment variables from Railway/Neon
        // Support both individual variables and DATABASE_URL
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
        $this->conn = null;

        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true, // Enable emulation to avoid cached plans
            ];
            
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            throw new Exception("Database connection failed: " . $exception->getMessage());
        }

        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

// Global database connection function
function getDBConnection() {
    static $db = null;
    if ($db === null) {
        $database = new Database();
        $db = $database->getConnection();
    }
    return $db;
}

// Function to reset database connection
function resetDBConnection() {
    global $db;
    $db = null;
    return getDBConnection();
}

// Helper function for prepared statements
function executeQuery($sql, $params = []) {
    $conn = getDBConnection();
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch(PDOException $e) {
        // Handle cached plan error by recreating connection
        if (strpos($e->getMessage(), 'cached plan must not change result type') !== false) {
            error_log("Cached plan error detected, resetting connection: " . $e->getMessage());
            $conn = resetDBConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } else {
            error_log("Query error: " . $e->getMessage());
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }
}

// Helper function for fetching single row
function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetch();
}

// Helper function for fetching multiple rows
function fetchAll($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll();
}

// Helper function for insert/update/delete operations
function executeUpdate($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->rowCount();
}

// Helper function to get last inserted ID
function getLastInsertId() {
    $conn = getDBConnection();
    return $conn->lastInsertId();
}
?>
