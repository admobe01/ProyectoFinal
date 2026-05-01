<?php
class Entrenador {
    private ?int $id;
    private string $usuario;
    private string $password;

    public function __construct(string $usuario, string $password, ?int $id = null) {
        $this -> id = $id;
        $this -> usuario = $usuario;
        $this -> password = $password;
    }

    public function getId(): ?int { return $this -> id; }
    public function getUsuario(): string { return $this -> usuario; }
    public function getPassword(): string { return $this -> password; }
}
?>