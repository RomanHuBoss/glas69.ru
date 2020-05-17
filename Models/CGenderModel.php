<?php


namespace Glas\Models;


use Glas\Utils\DB;

class CGenderModel extends CAbstractModel
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

    public static function getSeveral($condition = [])
    {
        $sql = 'SELECT * FROM classifiers.gender ';

        if (isset($condition['tail'])) {
            $sql .= $condition['tail'];
        }

        $stmt = DB::pdo()->prepare($sql);

        if (isset($condition['vars'])) {
            foreach ($condition['vars'] as $k => $v) {
                $stmt->bindParam(':'.$k, $v);
            }
        }
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getMaleGender() {
        $row = self::getSeveral(['tail' => 'WHERE is_male = true'])[0];
        return $row['id'];
    }

    public static function geFemaleGender() {
        $row = self::getSeveral(['tail' => 'WHERE is_female = true'])[0];
        return $row['id'];
    }

}