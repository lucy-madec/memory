<?php
class Player {
    private $conn;
    private $table_name = "players";

    public $id;
    public $username;
    public $email;
    public $password;
    public $best_score;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getBestScores() {
        $query = "SELECT * FROM leaderboard WHERE player_id = ? ORDER BY score ASC LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
