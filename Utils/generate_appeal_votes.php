<?php

include 'autoload.php';
include 'CombineMorph.php';

use Glas\Utils\DB;

exit;

while (true) {

    $sql = "SELECT id, time_moderated 
        FROM data.appeal	
        WHERE id NOT IN (SELECT id_appeal FROM data.appeal_vote) AND is_public = true AND 
            id_moderator IS NOT NULL AND id_decline_reason IS NULL   
        ORDER BY RANDOM() LIMIT 1";

    $stmt = DB::pdo()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (empty($row)) {
        break;
    }

    $appeal_id = $row['id'];
    $appeal_time_moderated = $row['time_moderated'];

    $max_votes = rand(10, 100);

    for ($i = 0; $i < $max_votes; $i++) {
        //выбираем голосующего
        $sql = "SELECT u.id FROM data.user u
        LEFT JOIN classifiers.user_type as ut ON u.id_type = ut.id 
        WHERE ut.is_user = true AND u.id NOT IN (SELECT id_user FROM data.appeal_vote WHERE id_appeal = :appeal_id)
        ORDER BY RANDOM() LIMIT 1";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('appeal_id', $appeal_id);
        $stmt->execute();
        $user_id = $stmt->fetch(\PDO::FETCH_ASSOC)['id'];

        $sql = "INSERT INTO data.appeal_vote (id_appeal, id_user, value)
            VALUES(:appeal_id, :user_id, :value)";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('appeal_id', $appeal_id);
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam('value', rand(1, 5));
        $stmt->execute();

    }

}