<?php


namespace Glas\Models;


use Glas\Utils\DB;

class CUserTypeModel extends CAbstractModel
    implements ISelectable
{

    public function __construct()
    {
    }


    public static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public static function getOne($id)
    {
        // TODO: Implement getOne() method.
    }

    public static function getSeveral($condition = [])
    {
        $sql = 'SELECT * FROM classifiers.user_type ';

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

    public static function getAdminType() {
        $row = self::getSeveral(['tail' => 'WHERE is_admin = true'])[0];
        return $row['id'];
    }

    public static function getOperatorType() {
        $row = self::getSeveral(['tail' => 'WHERE is_operator = true'])[0];
        return $row['id'];
    }

    public static function getUserType() {
        $row = self::getSeveral(['tail' => 'WHERE is_user = true'])[0];
        return $row['id'];
    }
}