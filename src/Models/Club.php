<?php
namespace Models;

use Core\Model;

class Club extends Model {

    public function getAll() {
        return $this->db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();
    }

    public function getById($id) {
        return $this->db->query("SELECT * FROM clubs WHERE id = ?", [$id])->fetch();
    }

    public function update($id, $name) {
        $this->db->query("UPDATE clubs SET name = ? WHERE id = ?", [$name, $id]);
    }

    public function getByClub($clubId) {
        // Just for compatibility if used elsewhere, currently Team model handles teams
    }
}
