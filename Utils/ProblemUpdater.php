<?php


namespace Glas\Utils;

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

include_once ("autoload.php");

use Glas\Utils\DB;

new ProblemUpdater();

class ProblemUpdater {
    const CLASSIFIER_FILE = 'ProblemData/problem.txt';

    function __construct() {
        if (!file_exists(self::CLASSIFIER_FILE)) {
            throw new \Exception("Не найден файл с записями классификатора проблем");
        }

        $this->handleProblemsFile();
    }

    private function handleProblemsFile() {
        try {
            $fd = fopen(self::CLASSIFIER_FILE, 'r');

            while (($line = fgets($fd)) !== false) {
                $data = [];
                $parts = explode('|', $line);

                $data['official_code'] = $this->normalizeOfficialCode($parts[0]);
                $data['parent_official_code'] = $this->getParentOfficialCode($data['official_code']);
                $data['name_short'] = null;
                $data['name_full'] = $parts[1];
                $data['pid'] = null;
                $this->insertProblemRecord($data);
            }

            fclose($fd);
        }
        catch (\Exception $e) {
            exit ($e->getMessage());
        }
    }

    private function getParentOfficialCode($official_code) {
        $codeParts = explode('.', $official_code);

        for ($i = count($codeParts) - 1; $i != 0; $i--) {
            if (preg_match('/[1-9]/is', $codeParts[$i])) {
                $codeParts[$i] = '00000';
                break;
            }
        }

        $parentOfficialCode = implode('.', $codeParts);

        if ($parentOfficialCode == $official_code) {
            $parentOfficialCode = null;
        }

        return $parentOfficialCode;
    }

    private function normalizeOfficialCode($official_code) {
        $codeParts = explode('.', $official_code);

        for ($i = 0; $i < count($codeParts); $i++) {
            $codeParts[$i] = str_pad($codeParts[$i], 5, '0', STR_PAD_LEFT);
        }

        while (count($codeParts) < 5) {
            $codeParts []= '00000';
        }

        return implode('.', $codeParts);
    }

    private function insertProblemRecord(Array $data) {
        try {
            $stmt = DB::pdo()->prepare('SELECT id FROM classifiers.problem_type WHERE official_code = :parent_official_code LIMIT 1');
            $stmt->bindParam(':parent_official_code', $data['parent_official_code']);
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($rows) > 0) {
                $data['pid'] = $rows[0]['id'];
            }

            $stmt = DB::pdo()->prepare('SELECT count(*) FROM classifiers.problem_type WHERE official_code = :official_code');
            $stmt->bindParam(':official_code', $data['official_code']);
            $stmt->execute();
            $row_count = $stmt->fetchColumn();

            if ($row_count == 0) {
                $sql = "INSERT INTO classifiers.problem_type (pid, name_short, name_full, official_code) VALUES 
                    (:pid, :name_short, :name_full, :official_code)";
            }
            else {
                $sql ="UPDATE classifiers.problem_type SET pid = :pid, 
                    name_short = :name_short, name_full = :name_full, official_code = :official_code WHERE official_code = :official_code";
            }

            $stmt = DB::pdo()->prepare($sql);
            $stmt->bindParam(':pid', $data['pid']);
            $stmt->bindParam(':name_short', $data['name_short']);
            $stmt->bindParam(':name_full', $data['name_full']);
            $stmt->bindParam(':official_code', $data['official_code']);
            $stmt->execute();
        }
        catch(\PDOException $e) {
            exit ($e->getMessage());
        }
    }

}

