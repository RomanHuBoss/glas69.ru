<?php


namespace Glas\Models;


use Glas\Utils\DB;

class CDeviceInfoModel extends CAbstractModel implements ICreatable
{

    static function create(array $data)
    {
        $sql = 'INSERT INTO data.device_info (id_user, ip, browser) VALUES (:id_user, :ip, :browser)';
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':ip', $data['ip']);
        $stmt->bindParam(':browser', $data['browser']);

        if (!$stmt->execute()) {
            throw new \Exception('Не удалось сохранить данные в базе данных');
        }
    }
}