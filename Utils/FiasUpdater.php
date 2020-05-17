<?php

namespace Glas\Utils;

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

include_once ("autoload.php");

use Glas\Utils\DB;

new FiasUpdater();

class FiasUpdater {
    const FIAS_MAIN_FILE = 'FiasData/fias_main.xml';
    const FIAS_HOUSES_FILE = 'FiasData/fias_houses.xml';

    function __construct() {
        //$this->handleMainFile();
        //$this->handleHousesFile();

        //обновляем геокодером координат элементы
        while ($this->geocodeAddresses());
    }

    private function geocodeAddresses() {
        usleep(300);
        $stmt = DB::pdo()->prepare('SELECT * FROM classifiers.fias_house WHERE coordinates IS NULL LIMIT 1');
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($row)) {
            return false;
        }

        $address = $row['full_address'];
        $url = 'https://geocode-maps.yandex.ru/1.x/?lang=ru_RU&geocode='.urlencode($address).'&apikey=0d2f280b-5bd0-4c2e-968b-d6e43f8fc813&results=1&format=json';
        $json = json_decode(file_get_contents($url), true);

        //широта и долгота
        list($lon, $lat) = explode(' ', $json['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);

        $stmt = DB::pdo()->prepare('UPDATE classifiers.fias_house SET coordinates = POINT(:lon, :lat)::POINT WHERE fias_code = :fias_code');
        $stmt->bindParam('lon', $lon);
        $stmt->bindParam('lat', $lat);
        $stmt->bindParam('fias_code', $row['fias_code']);
        $stmt->execute();

        return true;
    }

    private function handleMainFile() {
        if (!file_exists(self::FIAS_MAIN_FILE)) {
            throw new \Exception("Не найден файл с адресами ФИАС");
        }

        $reader = new \XMLReader();
        $reader->open(self::FIAS_MAIN_FILE);

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->localName == 'Object') {
                    $region = $reader->getAttribute('REGIONCODE');
                    //ограничиваемся Тверской областью
                    if ($region != '69') continue;

                    $data = [];
                    $data['id'] = $reader->getAttribute('AOGUID');
                    $data['pid'] = $reader->getAttribute('PARENTGUID');
                    $data['name_type'] = $reader->getAttribute('SHORTNAME');
                    $data['name_official'] = $reader->getAttribute('FORMALNAME');
                    $data['postal_code'] = $reader->getAttribute('POSTALCODE');
                    $data['is_active'] = $reader->getAttribute('ACTSTATUS');
                    $data['fias_code'] = $reader->getAttribute('AOID');
                    $this->insertFiasMainRecord($data);
                }
            }
        }
    }

    private function handleHousesFile() {
        if (!file_exists(self::FIAS_HOUSES_FILE)) {
            throw new \Exception("Не найден файл с домами ФИАС");
        }

        $reader = new \XMLReader();
        $reader->open(self::FIAS_HOUSES_FILE);

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->localName == 'House') {
                    $region = $reader->getAttribute('REGIONCODE');
                    //ограничиваемся Тверской областью
                    if ($region != '69') continue;

                    $data = [];
                    $data['id'] = $reader->getAttribute('HOUSEGUID');
                    $data['pid'] = $reader->getAttribute('AOGUID');
                    $data['house_num'] = $reader->getAttribute('HOUSENUM');
                    $data['build_num'] = $reader->getAttribute('BUILDNUM');
                    $data['struct_num'] = $reader->getAttribute('STRUCNUM');
                    $data['postal_code'] = $reader->getAttribute('POSTALCODE');
                    $data['fias_code'] = $reader->getAttribute('HOUSEID');

                    if ($data['id'] != $data['fias_code']) continue;

                    $this->insertFiasHouseRecord($data);
                }
            }
        }
    }

    private function insertFiasMainRecord(Array $data) {
        try {
            $stmt = DB::pdo()->prepare('SELECT count(*) FROM classifiers.fias_main WHERE fias_code = :fias_code ');
            $stmt->bindParam(':fias_code', $data['fias_code']);
            $stmt->execute();
            $row_count = $stmt->fetchColumn();

            if ($row_count == 0) {
                if ($data['is_active'] == 0) {
                    return;
                }
                $sql = "INSERT INTO classifiers.fias_main (id, pid, name_type, name_official, postal_code, is_active, fias_code) VALUES 
                (:id, :pid, :name_type, :name_official, :postal_code, :is_active, :fias_code)";
            }
            else {
                $sql ="UPDATE classifiers.fias_main SET id = :id, pid = :pid, 
                name_type = :name_type, name_official = :name_official, postal_code = :postal_code, is_active = :is_active WHERE fias_code = :fias_code";
            }

            $stmt = DB::pdo()->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':pid', $data['pid']);
            $stmt->bindParam(':name_type', $data['name_type']);
            $stmt->bindParam(':name_official', $data['name_official']);
            $stmt->bindParam(':postal_code', $data['postal_code']);
            $stmt->bindParam(':is_active', $data['is_active']);
            $stmt->bindParam(':fias_code', $data['fias_code']);
            $stmt->execute();
        }
        catch(\PDOException $e) {
            exit ($e->getMessage());
        }
    }


    private function insertFiasHouseRecord(Array $data) {
        try {
            $stmt = DB::pdo()->prepare('SELECT count(*) FROM classifiers.fias_house WHERE fias_code = :fias_code ');
            $stmt->bindParam(':fias_code', $data['fias_code']);
            $stmt->execute();
            $row_count = $stmt->fetchColumn();

            if ($row_count == 0) {
                $sql = "INSERT INTO classifiers.fias_house (id, pid, house_num, build_num, struct_num, postal_code, fias_code) VALUES 
                (:id, :pid, :house_num, :build_num, :struct_num, :postal_code, :fias_code)";
            }
            else {
                $sql ="UPDATE classifiers.fias_house SET id = :id, pid = :pid, 
                house_num = :house_num, build_num = :build_num, struct_num = :struct_num, postal_code = :postal_code WHERE fias_code = :fias_code";
            }

            $stmt = DB::pdo()->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':pid', $data['pid']);
            $stmt->bindParam(':house_num', $data['house_num']);
            $stmt->bindParam(':build_num', $data['build_num']);
            $stmt->bindParam(':struct_num', $data['struct_num']);
            $stmt->bindParam(':postal_code', $data['postal_code']);
            $stmt->bindParam(':fias_code', $data['fias_code']);
            $stmt->execute();
        }
        catch(\PDOException $e) {
            exit ($e->getMessage());
        }
    }
}


