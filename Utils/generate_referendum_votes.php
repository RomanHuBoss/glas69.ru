<?php

include 'autoload.php';
include 'CombineMorph.php';

exit;

use Glas\Utils\DB;

while (true) {

    $sql = "SELECT id 
        FROM data.referendum	
        WHERE id NOT IN (SELECT ra.id_referendum FROM data.user_referendum_answer as ura LEFT JOIN data.referendum_answer ra ON ura.id_answer = ra.id) AND 
            time_start IS NOT NULL  
        ORDER BY RANDOM() LIMIT 1";

    $stmt = DB::pdo()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (empty($row)) {
        break;
    }

    $referendum_id = $row['id'];

    $max_votes = rand(10, 100);

    for ($i = 0; $i < $max_votes; $i++) {
        //выбираем голосующего
        $sql = "SELECT u.id FROM data.user u
        LEFT JOIN classifiers.user_type as ut ON u.id_type = ut.id 
        WHERE ut.is_user = true AND u.id NOT IN (SELECT ura.id_user FROM data.user_referendum_answer as ura LEFT JOIN data.referendum_answer as ra ON ura.id_answer = ra.id  
        WHERE ra.id_referendum = :referendum_id)
        ORDER BY RANDOM() LIMIT 1";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('referendum_id', $referendum_id);
        $stmt->execute();
        $user_id = $stmt->fetch(\PDO::FETCH_ASSOC)['id'];

        //выбираем случайный ответ
        $sql = "SELECT id FROM data.referendum_answer WHERE id_referendum = :referendum_id ORDER BY RANDOM() LIMIT 1";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('referendum_id', $referendum_id);
        $stmt->execute();
        $answer_id = $stmt->fetch(\PDO::FETCH_ASSOC)['id'];

        $sql = "INSERT INTO data.user_referendum_answer (id_user, id_answer)
            VALUES(:user_id, :answer_id)";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('answer_id', $answer_id);
        $stmt->bindParam('user_id', $user_id);
        $stmt->execute();

    }

}