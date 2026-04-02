<?php

require_once BASE_PATH . 'app/Models/Regency.php';

class RegencyDAO
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }
    /**
     * Busca um maestro (regency) pelo login no banco.
     * Retorna array associativo com os dados ou null se não existir.
     *
     * @param string $login Login do maestro
     * @return array|null
     */
    public function findByLogin(string $login): ?array
    {
        // Pega a conexão ativa
        $db = $this->conn;

        // SQL preparado
        $sql = "SELECT regency_login, password FROM regency WHERE regency_login = ?";
        $stmt = $db->prepare($sql);

        // Falha ao preparar → retorna null
        if (!$stmt) {
            return null;
        }

        // Bind do parâmetro e execução
        $stmt->bind_param("s", $login);
        $stmt->execute();

        // Resultado
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        // Retorna array com dados ou null se vazio
        return $data ? Regency::fromArray($data)->toArray() : null;
    }
}
