<?php


namespace Glas\Models;

use Glas\Utils\DB;

class CReferendumModel extends CAbstractModel
{

    static function getSeveral($condition = [])
    {
        $sql = 'SELECT r.*, r.coordinates[0] as lon, r.coordinates[1] as lat, fh.full_address, pt.name_full as problem_name 
                FROM data.referendum as r
                    LEFT JOIN classifiers.fias_house as fh ON fh.fias_code = r.id_address                      
                    LEFT JOIN classifiers.problem_type as pt ON pt.id = r.id_problem_type
        ';

        if (isset($condition['tail'])) {
            $sql .= $condition['tail'];
        }

        if (isset($condition['order'])) {
            $sql .= $condition['order'];
        }

        if (isset($condition['limit'])) {
            $sql .= $condition['limit'];
        }

        $stmt = DB::pdo()->prepare($sql);

        if (isset($condition['vars'])) {
            foreach ($condition['vars'] as $k => $v) {
                $stmt->bindParam(':'.$k, $v);
            }
        }
        $stmt->execute();

        $appeals = [];

        foreach ( $stmt->fetchAll(\PDO::FETCH_ASSOC) as $appealData) {
            if ($condition['asArray'] === true) {
                $appeals[] = $appealData;
            }
            else {
                $appeals[] = new CReferendumModel($appealData);
            }
        }

        return $appeals;
    }

    public static function getReferendumsStats() : Array {
        $sql = "SELECT * FROM data.get_referendums_stats()";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}