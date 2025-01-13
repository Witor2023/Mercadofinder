<?php
// Arquivo de "Regras de negócio": 
// MODELO -> Operações para ter acesso ao BD e realizar CRUD !!
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
// inserir o arquivo 'config.php'
require_once 'config.php'; // ou include 'config.php'

/* Criamos uma classe chamada "Produto" */
class Produto 
{
    private static function getDbConnection1()
    {
        return new PDO(dbDrive1.':host='.dbHost1.';dbname='.dbName1, dbUser1, dbPass1);
    }

    private static function getDbConnection2()
    {
        return new PDO(dbDrive2.':host='.dbHost2.';dbname='.dbName2, dbUser2, dbPass2);
    }

    // 1) um método para fazer consulta através do parâmetro $id
    public static function select(int $id)
    {
        $tabela = "produto";
        $coluna = "produto_id";

        $connPdo1 = self::getDbConnection1();
        $connPdo2 = self::getDbConnection2();

        $sql = "SELECT * FROM $tabela WHERE $coluna = :id";
        
        $stmt1 = $connPdo1->prepare($sql);
        $stmt2 = $connPdo2->prepare($sql);

        $stmt1->bindValue(':id', $id);
        $stmt2->bindValue(':id', $id);

        $stmt1->execute();
        $stmt2->execute();

        if ($stmt1->rowCount() > 0) {
            return $stmt1->fetch(PDO::FETCH_ASSOC);
        } elseif ($stmt2->rowCount() > 0) {
            return $stmt2->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Sem registro do produto");
        }
    }

    // 2) um método para fazer consulta de todos os registros sem parâmetro $id
    public static function selectAll()
    {
        $tabela = "produto";

        $connPdo1 = self::getDbConnection1();
        $connPdo2 = self::getDbConnection2();

        $sql = "SELECT * FROM $tabela";

        $stmt1 = $connPdo1->prepare($sql);
        $stmt2 = $connPdo2->prepare($sql);

        $stmt1->execute();
        $stmt2->execute();

        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        return array_merge($result1, $result2);
    }

    // 3) um método para fazer inclusão no Banco de dados
    public static function insert($dados)
    {
        $tabela = "produto";

        $connPdo1 = self::getDbConnection1();
        $connPdo2 = self::getDbConnection2();

        $sql = "INSERT INTO $tabela(nome, categoria, preco, quantidade_estoque, mercado) VALUES(:nome, :categoria, :preco, :quantidade_estoque, :mercado)";

        $stmt1 = $connPdo1->prepare($sql);
        $stmt2 = $connPdo2->prepare($sql);

        $stmt1->bindValue(':nome', $dados['nome']);
        $stmt1->bindValue(':categoria', $dados['categoria']);
        $stmt1->bindValue(':preco', $dados['preco']);
        $stmt1->bindValue(':quantidade_estoque', $dados['quantidade_estoque']);
        $stmt1->bindValue(':mercado', $dados['mercado']);

        $stmt2->bindValue(':nome', $dados['nome']);
        $stmt2->bindValue(':categoria', $dados['categoria']);
        $stmt2->bindValue(':preco', $dados['preco']);
        $stmt2->bindValue(':quantidade_estoque', $dados['quantidade_estoque']);
        $stmt2->bindValue(':mercado', $dados['mercado']);

        $stmt1->execute();
        $stmt2->execute();

        if ($stmt1->rowCount() > 0 || $stmt2->rowCount() > 0) {
            return "Dados cadastrados com sucesso!";
        } else {
            throw new Exception("Erro ao inserir os dados!");
        }
    }

    // 4) um método para fazer exclusão de um determinado dado no Banco de dados
    public static function delete($id)
    {
        $tabela = "produto";
        $coluna = "produto_id";

        $connPdo1 = self::getDbConnection1();
        $connPdo2 = self::getDbConnection2();

        $sql = "DELETE FROM $tabela WHERE $coluna = :id";

        $stmt1 = $connPdo1->prepare($sql);
        $stmt2 = $connPdo2->prepare($sql);

        $stmt1->bindValue(':id', $id);
        $stmt2->bindValue(':id', $id);

        $stmt1->execute();
        $stmt2->execute();

        if ($stmt1->rowCount() > 0 || $stmt2->rowCount() > 0) {
            return "Dados excluídos com sucesso!";
        } else {
            throw new Exception("Erro ao excluir os dados!");
        }
    }
    

    // 5) um método para fazer a alteração de dados no Banco de dados
    public static function alterar($id, $dados)
    {
        $tabela = "produto";
        $coluna = "produto_id";

        $connPdo1 = self::getDbConnection1();
        $connPdo2 = self::getDbConnection2();

        $sql = "UPDATE $tabela SET nome=:nome, categoria=:categoria, preco=:preco, quantidade_estoque=:quantidade_estoque, mercado=:mercado WHERE $coluna = :id";

        $stmt1 = $connPdo1->prepare($sql);
        $stmt2 = $connPdo2->prepare($sql);

        $stmt1->bindValue(':id', $id);
        $stmt1->bindValue(':nome', $dados['nome']);
        $stmt1->bindValue(':categoria', $dados['categoria']);
        $stmt1->bindValue(':preco', $dados['preco']);
        $stmt1->bindValue(':quantidade_estoque', $dados['quantidade_estoque']);
        $stmt1->bindValue(':mercado', $dados['mercado']);

        $stmt2->bindValue(':id', $id);
        $stmt2->bindValue(':nome', $dados['nome']);
        $stmt2->bindValue(':categoria', $dados['categoria']);
        $stmt2->bindValue(':preco', $dados['preco']);
        $stmt2->bindValue(':quantidade_estoque', $dados['quantidade_estoque']);
        $stmt2->bindValue(':mercado', $dados['mercado']);

        $stmt1->execute();
        $stmt2->execute();

        if ($stmt1->rowCount() > 0 || $stmt2->rowCount() > 0) {
            return "Dados alterados com sucesso!";
        } else {
            throw new Exception("Erro ao alterar os dados!");
        }
    }
}
?>
