<?php

use App\Model;
use App\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    protected Model $model;


    public function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS user
          (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR( 225 ),
            createdAt DATETIME
          )
            "
        );

        $this->model = new Model($this->pdo);

        $users = [
            ['username' => 'Alan', 'createdAt' => date("Y-m-d H:i:s", strtotime('2024-01-15 00:00:00'))],
            ['username' => 'Sophie', 'createdAt' => date("Y-m-d H:i:s", strtotime('2024-01-15 00:00:00'))],
            ['username' => 'Bernard', 'createdAt' => date("Y-m-d H:i:s", strtotime('2024-01-15 00:00:00'))],
        ];

        $this->model->hydrate($users);
    }

    function testHydrate()
    {
      $this->assertCount( 3, $this->model->all());
    }

    function testSave()
    {

        $user = new User();

        $user->username = 'Jean';

        $this->model->save($user);

        $this->assertCount(4, $this->model->all());

    }

    function testUpdate()
    {
        $user = new User();

        $user->username = 'Paul';

        $user->id = 1;

        $this->model->update($user);

        $userUpdate = $this->model->find(1);

        $this->assertEquals('Paul', $userUpdate->username);
    }

    function testDelete()
    {
        $this->model->delete(1);

        $this->assertFalse($this->model->find(1));
    }


}
