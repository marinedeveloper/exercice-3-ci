<?php

namespace App;

class ModelPrepare
{
    public function __construct(private \PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Delete resource by pk
     *
     * @param int $id
     * @return \PDOStatement
     */
    public function delete(int $id): void
    {
        $query = 'DELETE FROM user WHERE id=:id';
        $stmt = $this->pdo->prepare($query); // compilée
        $stmt->execute([':id' => $id]);

        $stmt = null;
    }

    /**
     * Return all resources
     *
     * @return array resources
     */
    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM user");

        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'App\\User');
    }

    /**
     * Return all resources
     *
     * @return array resources
     */
    public function update(User $user)
    {
        $query = 'UPDATE user SET username=:username WHERE id=:id';
        $stmt = $this->pdo->prepare($query); // compilée
        $stmt->execute([':id' => $user->id, ':username' => $user->username]);

       // return $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\\User');
    }

    /**
     * @param array $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $this->pdo->prepare($query); // compilée
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject('App\\User');
    }

    /**
     * Return all resources
     *
     * @return array resources
     */
    public function hydrate(array $users): void
    {
        // prepare donc compilée
        $stmt = $this->pdo->prepare("INSERT INTO user (username, createdAt) VALUES (:username, :createdAt)");

        foreach ($users as $u) {
            $stmt->execute([
                ':username' => $u['username'],
                ':createdAt' => $u['createdAt'],
            ]);
        }

        $stmt = null;
    }

    public function save(User $user): void
    {
        $query = 'INSERT INTO user (username) VALUES (:username)';
        $stmt = $this->pdo->prepare($query); // compilée
        $stmt->execute([':username' => $user->username]);

        $stmt = null; // fermeture de la requête
    }
}
