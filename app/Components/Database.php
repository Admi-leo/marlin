<?php

namespace App\Components;

use PDO;
use Aura\SqlQuery\QueryFactory;

/**
 * Database
 */

class Database
{
  public $pdo;
  public $queryFactory;

  public function __construct(PDO $pdo, QueryFactory $queryFactory)
  {
    $this->pdo = $pdo;
    $this->queryFactory = $queryFactory;
  }
  public function create($table, $data)
  {
    $insert = $this->queryFactory->newInsert();
    $insert
      ->into($table)
      ->cols($data);
    $sth = $this->pdo->prepare($insert->getStatement());
    $sth->execute($insert->getBindValues());

    $name = $insert->getLastInsertIdName('id');
    return $this->pdo->lastInsertId($name);
  }
  public function readAll($table, $limit = null)
  {
    $select = $this->queryFactory->newSelect();
    $select
    ->cols(['*'])
    ->from($table)
    ->limit($limit);

    $sth = $this->pdo->prepare($select->getStatement());

    $sth->execute($select->getBindValues());

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }
  public function readOne($table, $key, $row = 'id')
  {
    $select = $this->queryFactory->newSelect();
    $select
      ->cols(['*'])
      ->from($table)
      ->where("$row=:id")
      ->bindValue('id', $key);
    $sth = $this->pdo->prepare($select->getStatement());
    $sth->execute($select->getBindValues());
    return $sth->fetch(PDO::FETCH_ASSOC);
  }
  public function whereAll($table, $id, $row = 'id', $limit = 4)
  {
    $select = $this->queryFactory->newSelect();
    $select
      ->cols(['*'])
      ->from($table)
      ->limit($limit)
      ->where("$row = :id")
      ->bindValue(":id", $id);
    $sth = $this->pdo->prepare($select->getStatement());
    $sth->execute($select->getBindValues());

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }
  public function update($table, $data, $key)
  {
    $update = $this->queryFactory->newUpdate();
    $update
      ->table($table)
      ->cols($data)
      ->where('id=:id')
      ->bindValue('id', $key);
    $sth = $this->pdo->prepare($update->getStatement());
    return $sth->execute($update->getBindValues());
  }
  public function delete($table, $row, $key)
  {
    $delete = $this->queryFactory->newDelete();
    $delete
      ->from($table)
      ->where("$row=:id")
      ->bindValue('id', $key);
    $sth = $this->pdo->prepare($delete->getStatement());
    return $sth->execute($delete->getBindValues());
  }

  public function getCount($table, $row, $val)
  {
    $select = $this->queryFactory->newSelect();
    $select
      ->cols(['*'])
      ->from($table)
      ->where("$row = :$row")
      ->bindValue($row, $val);

    $sth = $this->pdo->prepare($select->getStatement());

    $sth->execute($select->getBindValues());

    return count($sth->fetchAll(PDO::FETCH_ASSOC));
  }

  public function getPaginatedFrom($table, $row, $id, $page = 1, $rows = 1)
  {
    $select = $this->queryFactory->newSelect();
    $select
      ->cols(['*'])
      ->from($table)
      ->where("$row = :row")
      ->bindValue(":row", $id)
      ->page($page)
      ->setPaging($rows);
    $sth = $this->pdo->prepare($select->getStatement());

    $sth->execute($select->getBindValues());

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getAllPaginatedFrom($table, $page = 1, $rows = 1)
  {
    $select = $this->queryFactory->newSelect();
    $select
      ->cols(['*'])
      ->from($table)
      ->page($page)
      ->setPaging($rows);
    $sth = $this->pdo->prepare($select->getStatement());

    $sth->execute($select->getBindValues());

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }


}



?>
