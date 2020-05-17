<?php

exit;

include 'autoload.php';
include 'CombineMorph.php';

use Glas\Utils\DB;

$genders = ['male', 'female'];
$avatarFolderPrefix = $_SERVER['DOCUMENT_ROOT'].'/assets/images/users/';
$avatarFolderUrlPrefix = '/assets/images/users/';
$avatars = [];
foreach ($genders as $gender) {
    $avatarFolderPath = $avatarFolderPrefix.$gender;
    $fd = opendir($avatarFolderPath);
    while (($f = readdir($fd)) != false) {
        if ($f != '.' && $f != '..') {
            $avatars[$gender][] = $f;
        }
    }
    closedir($fd);
}

while (true) {
    $sql = 'SELECT * FROM data.user WHERE avatar IS NULL LIMIT 1';
    $stmt = DB::pdo()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (empty($row)) exit;

    $gender = ($row['id_gender'] == 1) ? 'male' : 'female';
    $index = array_rand($avatars[$gender]);
    $avatar = $avatars[$gender][$index];

    $sql = 'UPDATE data.user SET avatar = :avatar WHERE id = :id';
    $stmt = DB::pdo()->prepare($sql);
    $avatarUrl = $avatarFolderUrlPrefix . $gender . '/'. $avatar;
    $stmt->bindParam(':avatar', $avatarUrl);
    $stmt->bindParam(':id', $row['id']);
    $stmt->execute();
}



exit;


$femaleFirstNames = 'Татьяна,Вера,Любовь,Мария,Антонина,Александра,Ирина,Елена,Алена,Мирослава,Ангелина,Галина,Светлана,Марина,Регина,Алевтина,Юлия,Надежда,Виктория,Анастасия,Людмила,Анна,Валентина,Снежана,Александра,Евгения,Лиана,Диана,Жанна,Виолетта';
$femaleSurnames = 'Владимировна,Романовна,Викторовна,Алексеевна,Антоновна,Артемовна,Давидовна,Робертовна,Алекснадровна,Андреевна,Олеговна,Михайловна,Петровна,Григорьевна,Борисовна,Юрьевна,Максимовна,Денисовна,Константиновна,Евгеньевна,Сергеевна,Львовна';
$femaleLastNames = 'Сироткина,Ульянова,Сапрыкина,Ромашова,Глызина,Бодрина,Антонова,Кабанкова,Андреева,Васильева,Воробьева,Синицына,Егорова,Ковалева,Смирнова,Виноградова,Иванова,Медведева,Зайцева,Комарова,Лебедева,Журавлева,Волкова,Игнатьева,Владимирова,Молякова,Шлякова,Томилина,Никандрова,Рублева,Романова,Акаткина,Аркатова,Братеева,Веселова,Галсанова,Завьялова,Цветкова,Михайлова,Григорьева,Юрьева,Балашова,Сергеева,Максимова';

$maleFirstNames = 'Анатолий,Игорь,Антон,Александр,Юрий,Георгий,Николай,Владимир,Федор,Петр,Станислав,Егор,Максим,Алексей,Роман,Михаил,Борис,Денис,Сергей,Дмитрий,Виктор,Валентин,Александр,Евгений,Ярослав,Антип,Георгий,Иван,Лев';
$maleSurnames = 'Владимирович,Романович,Викторович,Алексеевич,Антонович,Артемович,Давидович,Робертович,Алекснадрович,Андреевич,Олегович,Михайлович,Петрович,Григорьевич,Борисович,Юрьевич,Максимович,Денисович,Константинович,Евгеньевич,Сергеевич';
$maleLastNames = 'Сироткин,Ульянов,Сапрыкин,Галкин,Ромашов,Глызин,Бодрин,Антонов,Кабанков,Андреев,Васильев,Воробьев,Синицын,Егоров,Ковалев,Смирнов,Виноградов,Иванов,Медведев,Зайцев,Комаров,Лебедев,Журавлев,Волков,Игнатьев,Владимиров,Моляков,Шляков,Томилин,Никандров,Рублев,Романов,Акаткин,Аркатов,Братеев,Веселов,Галсанов,Завьялов,Цветков,Михайлов,Григорьев,Юрьев,Балашов,Сергеев,Максимов';

$logins = 'demo,tester,room,nice,folk,wind,river,forest,cloud,user,visitor,master,servant,tester,prog,customer,seller,insider,viewer,buyer,manager,boss';

$aboutTemplate = '
    {Много лет|Несколько месяцев|Почти год|Около полугода} {живу|проживаю|как работаю} в {Твери|Торжке|Медном|Эммаусе|Весьегонске|Красном Холме|Завидово|Редкино|Вышнем Волочке|Осташкове|Западной Двине|Андреаполе|Максатихе|Белом}.    
    {Увлекаюсь|Занимаюсь} {спортом|шахматами|автомобилями|комьютерами|танцами}. Мечтаю о {загородном доме|мире во всем мире|большом заработке|хорошей работе|сделать мир лучше}.
    {Надеюсь|Полагаю|Тешу себя надеждой|Считаю}, что {не напрасно|не зря|не впустую|не просто так} {трачу|теряю|провожу} {тут|здесь|на этом сайте|на портале} {свое|} время, и 
    {{референдум|голосование} по проблеме {детей-сирот|безработицы|вывоза мусора} состоится!|мое обращение {к Губернатору|к властям|в Правительство|к администрации} будет {услышано|одобрено|рассмотрено}.}';

$genders = ['male', 'female'];
$avatarFolderPrefix = $_SERVER['DOCUMENT_ROOT'].'/assets/images/users/';
$avatarFolderUrlPrefix = '/assets/images/users/';

foreach ($genders as $gender) {
    $avatarFolderPath = $avatarFolderPrefix.$gender;
    $fd = opendir($avatarFolderPath);
    while (($f = readdir($fd)) != false) {
        if ($f != '.' && $f != '..') {
            $avatars[$gender][] = $f;
        }
    }
    closedir($fd);
}


for ($i = 0; $i < 1000; $i++) {
    if (rand(0, 100) > 50) {
        $id_gender = \Glas\Models\CGenderModel::geFemaleGender();
        $firstNames = explode(',', $femaleFirstNames);
        $suRnames = explode(',', $femaleSurnames);
        $lastNames = explode(',', $femaleLastNames);
        $avatarGenderFolder = 'male';
    }
    else {
        $id_gender = \Glas\Models\CGenderModel::getMaleGender();
        $firstNames = explode(',', $maleFirstNames);
        $suRnames = explode(',', $maleSurnames);
        $lastNames = explode(',', $maleLastNames);
        $avatarGenderFolder = 'female';
    }


    $user_type_coin = rand(0, 100);
    if ($user_type_coin >= 98) {
        $id_user_type = \Glas\Models\CUserTypeModel::getOperatorType();
    }
    else if ($user_type_coin >= 96 && $user_type_coin < 98) {
        $id_user_type = \Glas\Models\CUserTypeModel::getAdminType();
    }
    else {
        $id_user_type = \Glas\Models\CUserTypeModel::getUserType();
    }

    $fio = randomArrayElement($lastNames)  . ' ' . randomArrayElement($firstNames) . ' ' . randomArrayElement($suRnames);
    $id_address = \Glas\Models\CFiasModel::getRandomRecord()['id'];

    $login = randomArrayElement(explode(',', $logins)).rand(0, 100000);
    $md5password = md5($login);
    $email = $login.'@mail.ru';
    $site = 'http://ergocentr.ru';
    $phone = '+7 ('.rand(400, 999).') '.rand(100, 999).'-'.rand(10, 99).'-'.rand(10,99);

    $avatar = $avatarFolderUrlPrefix.$avatarGenderFolder.'/'.array_rand($avatars[$avatarGenderFolder]);

    $about = (new CombineMorph($aboutTemplate))->getRandomVariant();

    $sql = 'INSERT INTO data.user (id_type, id_gender, id_address, login, md5password, email, site, fio, phone, about, avatar, birth_date)    
    VALUES (:id_type, :id_gender, :id_address, :login, :md5password, :email, :site, :fio, :phone, :about, :avatar, :birth_date)';

    $birthDate = date('m-d-Y', time() - rand(3600 * 24 * 30 * 12 * 18,  3600 * 24 * 30 * 12 * 65));

    $stmt = DB::pdo()->prepare($sql);
    $stmt->bindParam(':id_type', $id_user_type);
    $stmt->bindParam(':id_gender', $id_gender);
    $stmt->bindParam(':id_address', $id_address);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':md5password', $md5password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':site', $site);
    $stmt->bindParam(':fio', $fio);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':about', trim($about));
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':birth_date', $birthDate);
    $stmt->execute();
}

function randomArrayElement($array) {
    return $array[array_rand($array)];
}