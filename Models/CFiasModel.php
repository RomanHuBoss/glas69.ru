<?php


namespace Glas\Models;


use Glas\Utils\DB;

class CFiasModel extends CAbstractModel
    implements ISelectable
{

    static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    static function getOne($id)
    {
        // TODO: Implement getOne() method.
    }

    static function getSeveral($condition = [])
    {
        // TODO: Implement getSeveral() method.
    }

    static function getRandomRecord() {
        $sql = "SELECT * FROM classifiers.fias_house WHERE coordinates IS NOT NULL ORDER BY RANDOM() LIMIT 1";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    static function getByFullAdress($address) {
        $sql = "SELECT * FROM classifiers.fias_house WHERE full_address = :address LIMIT 1";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    static function getByFulltextSearch($request, $limit = 5) {

        $sql = "WITH tmp1 AS (
                  SELECT full_address FROM classifiers.fias_house 
                  WHERE search_vector @@ plainto_tsquery(:request)
                  ORDER BY ts_rank(search_vector, plainto_tsquery(:request)) DESC
                ), tmp2 AS (
                  SELECT full_address FROM classifiers.fias_house 
                  WHERE (SELECT count(*) FROM tmp1) = 0 AND full_address LIKE '%' || :request || '%'
                )
                SELECT * FROM tmp1
                UNION SELECT * FROM tmp2";

        if ($limit > 0) {
            $sql .= " LIMIT ".$limit;
        }

        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':request', $request, \PDO::PARAM_STR);
        $stmt->execute();
        //var_dump($stmt->debugDumpParams());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}