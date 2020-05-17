<?php

include 'autoload.php';
include 'CombineMorph.php';

use Glas\Utils\DB;

$messages = [
    [
        'subject' => '{
            {Как же это|До боли} знакомо|Солидарен|Жму руку автору|Поддерживаю|{Точно|В точности|Также} как и у нас|У нас те же {сложности|проблемы}|Проблема общая|Везде одно и то же|{Известная|Популярная} проблема|Ну-ну...|Серьезно что ли?
        }',
        'message' => '{
            {{{Трудности|Сложности|Проблемы} эти}|Проблему} надо {побыстрее|в срочном порядке|срочно|как можно скорее|быстрее} решать|
            {Стыдно|Грустно|Жаль, что {доводится|приходится}} {и|} в {21 веке|наше время|наши дни} с {подобным|такими проблемами} сталкиваться|
            {Будем|Остается только} надеяться, что отреагируют {как {следует|надо}|правильно} {и {вовремя|своевременно}|}|
            {Вот только|К несчастью,|Вряд ли|Наверняка вам|Скорее всего|Говорю с полной уверенностью - |Почти не сомневаюсь,} {никто вам не поможет|не помогут вам|не станут проблему решать}|
            Могу {позвонить нужным людям|подъехать|подскочить} - {помочь {в решении проблемы|решить проблему}|{поучаствовать|посодействовать} в решении проблемы} 
        } .'
    ]
];

while (true) {

    $sql = "SELECT id, time_moderated 
        FROM data.appeal	
        WHERE id NOT IN (SELECT id_appeal FROM data.appeal_forum) AND is_public = true AND 
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

    for ($i = 0; $i < 10; $i++) {
        $is_declined = false;
        $time_moderated = null;
        $moderator_id = null;

        //выбираем автора
        $sql = "SELECT u.id FROM data.user u
        LEFT JOIN classifiers.user_type as ut ON u.id_type = ut.id 
        WHERE ut.is_user = true
        ORDER BY RANDOM() LIMIT 1";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute();
        $author_id = $stmt->fetch(\PDO::FETCH_ASSOC)['id'];

        $randomTemplate = $messages[array_rand($messages)];
        $subject = (new CombineMorph($randomTemplate['subject']))->getRandomVariant();
        $subject = preg_replace('/\s+([.?!])/uis', '$1', $subject);
        $subject = preg_replace('/\s+/uis', ' ', $subject);

        $message = (new CombineMorph($randomTemplate['message']))->getRandomVariant();
        $message = preg_replace('/\s+([.?!])/uis', '$1', $message);
        $message = preg_replace('/\s+/uis', ' ', $message);

        $time_created = strtotime($appeal_time_moderated) + ($i + 1) * 24 * 1800;

        if (rand(0,100) > 20) {
            //выбираем модератора
            $sql = "SELECT u.id FROM data.user u
                LEFT JOIN classifiers.user_type as ut ON u.id_type = ut.id 
                WHERE ut.is_operator = true
                ORDER BY RANDOM() LIMIT 1";

            $stmt = DB::pdo()->prepare($sql);
            $stmt->execute();
            $moderator_id = $stmt->fetch(\PDO::FETCH_ASSOC)['id'];

            $is_declined = rand(0, 100) > 90 ? true : false;
            $time_moderated = $time_created + rand(1,3) * 24 * 1800;
        }

        $sql = "INSERT INTO data.appeal_forum (id_appeal, id_author, id_moderator, subject, message,  time_created, time_moderated, is_declined)
            VALUES(:appeal_id, :author_id, :moderator_id, :subject, :message,  :time_created,  :time_moderated, :is_declined)";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('appeal_id', $appeal_id);
        $stmt->bindParam('author_id', $author_id);
        $stmt->bindParam('moderator_id', $moderator_id);
        $stmt->bindParam('subject', $subject);
        $stmt->bindParam('message', $message);
        $stmt->bindParam('time_created', date('m-d-Y', $time_created));
        $stmt->bindParam('time_moderated', date('m-d-Y', $time_moderated));
        $stmt->bindParam('is_declined', $is_declined, \PDO::PARAM_BOOL);
        $stmt->execute();

    }
}