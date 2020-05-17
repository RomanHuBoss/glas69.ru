<?php

exit;

include 'autoload.php';
include 'CombineMorph.php';

use Glas\Utils\DB;

for ($i = 0; $i < 20000; $i++) {
    //выбираем случайного пользователя, чей контакт-лист будем насыщать
    $stmt = DB::pdo()->prepare('SELECT id FROM data.user ORDER BY RANDOM() LIMIT 1');
    $stmt->execute();
    $row =$stmt->fetch(\PDO::FETCH_ASSOC);
    $user_id = $row['id'];

    //выбираем случайного получателя, кто станет контактом первого
    $stmt = DB::pdo()->prepare('SELECT id FROM data.user 
    WHERE id != :user_id AND id NOT IN (SELECT id_contact FROM data.user_contacts WHERE id_user = :user_id)     
    ORDER BY RANDOM() LIMIT 1');
    $stmt->bindValue('user_id', $user_id);
    $stmt->execute();
    $row =$stmt->fetch(\PDO::FETCH_ASSOC);
    $contact_id = $row['id'];

    $sql = "INSERT INTO data.user_contacts (id_user, id_contact)
    VALUES(:user_id, :contact_id)";

    $stmt = DB::pdo()->prepare($sql);
    $stmt->bindValue('user_id', $user_id);
    $stmt->bindValue('contact_id', $user_id);
    $stmt->execute();

}