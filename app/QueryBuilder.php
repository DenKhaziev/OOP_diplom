<?php
namespace app;
use Aura\SqlQuery\QueryFactory;
use PDO;


class QueryBuilder
{
    private $pdo;
    private $queryFactory;
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=mysql;charset=utf8", 'root', 'root');
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getAll($table) {
        $select = $this->queryFactory->newSelect();
//        d($select); die;
        $select->cols(['*'])->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($table, $data, $id) {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where("id = :id")
            ->bindValue("id", $id);
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
//        d($update->getBindValues());
    }

    public function insert($table, $data) {
        $insert = $this->queryFactory->newInsert();
        $insert->into($table);
        $insert->cols($data);
        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
//        d($sth);
    }
    public function delete($table, $id) {
        $delete = $this->queryFactory->newDelete();
        $delete->from($table);
        $delete->where("id = :id");
        $delete->bindValue("id", $id);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }
}