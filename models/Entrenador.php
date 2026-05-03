<?php
class Entrenador {
    private ?int $id;
    private string $usuario;
    private string $password;
    private int $esAdmin; 
    public function __construct(string $usuario, string $password, ?int $id = null, int $esAdmin = 0) {
        $this -> id = $id;
        $this -> usuario = $usuario;
        $this -> password = $password;
        $this -> esAdmin = $esAdmin; 
    }

    public function getId(): ?int { return $this -> id; }
    public function getUsuario(): string { return $this -> usuario; }
    public function getPassword(): string { return $this -> password; }
    public function getEsAdmin(): int { return $this -> esAdmin; } 
}
?>