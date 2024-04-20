<?php
require_once 'Config/App/Connection.php';
class Query extends Connection
{
    private $pdo, $connection, $sql, $values, $successfullResponse, $failedResponse;
    public function __construct()
    {
        $this->pdo = new Connection();
        $this->connection = $this->pdo->connect();
        $this->successfullResponse  = ['ok' => true, 'msg' => '', 'errorMsg' => '', 'data' => []];
        $this->failedResponse =  ['ok' => false, 'msg' => '', 'errorMsg' => '', 'data' => []];
    }

    public function select(string $sql)
    {
        try {
            $this->sql = $sql;
            $response = $this->connection->prepare($this->sql);
            $response->execute();
            $data = $response->fetch(PDO::FETCH_ASSOC);
            $this->successfullResponse['data'] = $data;

            return $this->successfullResponse;
        } catch (PDOException $e) {
            $this->failedResponse['errorMsg'] = $e->getMessage();
            return $this->failedResponse;
        }
    }

    public function selectAll(string $sql)
    {
        try {
            $this->sql = $sql;
            $response = $this->connection->prepare($this->sql);
            $response->execute();
            $data = $response->fetchAll(PDO::FETCH_ASSOC);
            $this->successfullResponse['data'] = $data;
            return $this->successfullResponse;
        } catch (Exception $e) {
            $this->failedResponse['errorMsg'] = $e->getMessage();
            return $this->failedResponse;
        }
    }

    public function save(string $sql, array $values)
    {
        $this->sql = $sql;
        $this->values = $values;
        $this->successfullResponse['data'] = '';
        try {
            $response = $this->connection->prepare($sql);
            $response->execute($this->values);
            $data = $this->successfullResponse;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $this->failedResponse['errorMsg'] = $e->errorInfo[2];
                $data =  $this->failedResponse;
            } else {
                $this->failedResponse['errorMsg'] = $e->getMessage();
                $data =  $this->failedResponse;
            }
        }

        return $data;
    }

    public function destroy(string $sql, array $values)
    {
        $this->sql = $sql;
        $this->values = $values;
        try {
            $response = $this->connection->prepare($sql);
            $response->execute($this->values);
            return $this->successfullResponse;
        } catch (PDOException $e) {
            $this->failedResponse['errorMsg'] = $e->getMessage();
            return $this->failedResponse;
        }
    }


    public function destroyAll(string $sql)
    {
        $this->sql = $sql;
        try {
            $this->connection->query($this->sql);
            return $this->successfullResponse;
        } catch (PDOException $e) {
            $this->failedResponse['errorMsg'] = $e->getMessage();
            return $this->failedResponse;
        }
    }
}
