<?php

class Connection {
    private static $instance = null; // Guardará la instancia única de esta clase
    private $conn; // El objeto PDO
    private $configFile = "conf.json";

    private function __construct() {
        $this->makeConnection();
    }

    // Método estático para obtener la instancia única
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function makeConnection()
    {
        try {
            if (!file_exists($this->configFile)) {
                throw new Exception("Archivo de configuración no encontrado.");
            }

            $configData = file_get_contents($this->configFile);
            $c = json_decode($configData, true);
            $dsn = "mysql:host=" . $c['host'] . ";dbname=" . $c['db'];
            $this->conn = new PDO($dsn, $c['userName'], $c['password']);
            
        }
        catch (PDOException $e) {
    
            echo "<b>Mensaje:</b> " . $e->getMessage() . "<br>";
            echo "<b>Código de error MySQL:</b> " . $e->getCode() . "<br>";
        }
        
        catch (Exception $e) {

            echo "Error de sistema: " . $e->getMessage();
        } 
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    // Evitar que se clone el objeto (seguridad del patrón)
    private function __clone() { }
}
