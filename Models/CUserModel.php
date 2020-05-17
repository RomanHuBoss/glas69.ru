<?php

namespace Glas\Models;

use Glas\Utils\DB;

class CUserModel extends CAbstractModel
    implements ISelectable, ICreatable, IUpdateable, IRemovable
{
    private $id;
    private $id_type;
    private $id_gender;
    private $id_address;
    private $id_block_reason;
    private $time_registered;
    private $login;
    private $md5password;
    private $email;
    private $site;
    private $fio;
    private $phone;
    private $about;
    private $avatar;
    private $birth_date;

    private $photos;
    private $blocked_till;

    private $is_admin   = false;
    private $is_operator = false;
    private $is_user     = false;


    private $full_address = null;

    /**
     * @return null
     */
    public function getFullAddress()
    {
        return $this->full_address;
    }

    public function __construct(Array $data = [])
    {
        foreach ($data as $k => $v) {
            if (in_array($k, ['is_admin', 'is_operator', 'is_user']) && is_null($v)) {
                $v = false;
            }

            $this->{$k} = $v;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdType()
    {
        return $this->id_type;
    }

    /**
     * @return mixed
     */
    public function getIdGender()
    {
        return $this->id_gender;
    }

    /**
     * @return mixed
     */
    public function getIdAddress()
    {
        return $this->id_address;
    }

    /**
     * @return mixed
     */
    public function getIdBlockReason()
    {
        return $this->id_block_reason;
    }

    /**
     * @return mixed
     */
    public function getTimeRegistered()
    {
        return $this->time_registered;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getMd5password()
    {
        return $this->md5password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @return mixed
     */
    public function getFio()
    {
        if ($this->getIsGuest()) {
            return 'Гость';
        }
        return $this->fio;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        if ($this->getIsGuest()) {
            return '../assets/images/users/guest_avatar.png';
        }
        return $this->avatar;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @return mixed
     */
    public function getBlockedTill()
    {
        return $this->blocked_till;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin() : bool
    {
        return $this->is_admin || false;
    }

    /**
     * @return mixed
     */
    public function getIsOperator() : bool
    {
        return $this->is_operator || false;
    }

    /**
     * @return mixed
     */
    public function getIsUser() : bool
    {
        return $this->is_user || false;
    }

    /**
     * @return mixed
     */
    public function getIsGuest() : bool
    {
        return !$this->is_admin && !$this->is_operator && !$this->is_user;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function getInternalMailStats() {
        $sql = 'SELECT * FROM data.get_internal_messages_stats(:user_id)';
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(':user_id', $this->getId());
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserTypeStr() : string {
        if ($this->getIsAdmin()) {
            return 'admin';
        }
        else if ($this->getIsOperator()) {
            return 'operator';
        }
        else if ($this->getIsUser()) {
            return 'user';
        }
        else {
            return 'guest';
        }
    }

    public function getUserTypeStrRus() : string {
        if ($this->getIsAdmin()) {
            return 'Администратор';
        }
        else if ($this->getIsOperator()) {
            return 'Модератор';
        }
        else if ($this->getIsUser()) {
            return 'Пользователь';
        }
        else {
            return 'Гость';
        }
    }

    public function getFioShorten() {
        if ($this->getIsGuest()) {
            return 'Гость';
        }

        $fioParts = explode(' ', $this->fio);
        $fioParts[1] = (isset($fioParts[1])) ? mb_substr($fioParts[1], 0, 1).'.' : '';
        $fioParts[2] = (isset($fioParts[2])) ? mb_substr($fioParts[2], 0, 1).'.' : '';
        return $fioParts[0].' '.$fioParts[1].$fioParts[2];
    }

    public function getIp() {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getBrowserShorten() {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        if (strpos(strtolower($browser), 'firefox') != -1) {
            return 'Mozilla Firefox';
        }
        else if (strpos(strtolower($browser), 'opera') != -1) {
            return 'Opera';
        }
        else if (strpos(strtolower($browser), 'yandex') != -1) {
            return 'Yandex Browser';
        }
        else if (strpos(strtolower($browser), 'chrome') != -1) {
            return 'Google Chrome';
        }
        else if (strpos(strtolower($browser), 'safari') != -1) {
            return 'Safari';
        }
        else {
            return 'Other (Unknown)';
        }
    }

    public static function authorize($login, $password): CUserModel {
        $sql = 'SELECT * FROM data.user WHERE login = :login AND md5password = :md5password';
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':md5password', md5($password));
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($row)) {
            throw new \Exception('Логин или пароль указаны неверно');
        }

        return new CUserModel($row);
    }

    public static function checkLoginUnique($login) {
        $sql = 'SELECT * FROM data.user WHERE login = :login';
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return empty($row);
    }

    public static function checkEmailUnique($email) {
        $sql = 'SELECT * FROM data.user WHERE email = :email';
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return empty($row);
    }

    public static function create(Array $data) {
        if (!self::checkLoginUnique($data['login'])) {
            throw new \Exception('Пользователь с таким логином уже зарегистрирован');
        }

        if (!self::checkEmailUnique($data['email'])) {
            throw new \Exception('Пользователь с таким email уже зарегистрирован');
        }

        $sql = 'INSERT INTO data.user (id_type, id_gender, id_address, login, md5password, email, fio, phone, birth_date)    
    VALUES (:id_type, :id_gender, :id_address, :login, :md5password, :email, :fio, :phone, :birth_date)';

        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam(':id_type', $data['id_user_type']);
        $stmt->bindParam(':id_gender', $data['id_gender']);
        $stmt->bindParam(':id_address', $data['id_address']);
        $stmt->bindParam(':login', $data['login']);
        $stmt->bindParam(':md5password', md5($data['password']));
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':fio', $data['fio']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':birth_date', $data['birth_date']);


        if (!$stmt->execute()) {
            throw new \Exception('Не удалось сохранить данные в базе данных');
        }

        return true;
    }

    public function update($id, Array $data) {
    }

    public function delete($id) {
    }

    public static function getAll($orderBy = null) {
    }

    public static function getOne($id) : CUserModel {
        $stmt = DB::pdo()->prepare('
            SELECT u.*, fh.full_address, ut.is_admin, ut.is_operator, ut.is_user 
            FROM data.user as u 
                LEFT JOIN classifiers.user_type as ut ON u.id_type = ut.id  
                    LEFT JOIN classifiers.fias_house as fh ON u.id_address = fh.fias_code
            WHERE u.id = :id '
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return new CUserModel($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public static function getSeveral($condition = []) {

        $sql = 'SELECT u.*, fh.coordinates[0] as lon, fh.coordinates[1] as lat, fh.full_address, ut.name_full as user_type_name, ut.is_admin, ut.is_operator, ut.is_user 
            FROM data.user as u 
                LEFT JOIN classifiers.fias_house as fh ON fh.fias_code = u.id_address
                LEFT JOIN classifiers.user_type as ut ON u.id_type = ut.id
        ';

        if (isset($condition['tail'])) {
            $sql .= $condition['tail'];
        }

        if (isset($condition['order'])) {
            $sql .= $condition['order'];
        }

        if (isset($condition['limit'])) {
            $sql .= $condition['limit'];
        }

        $stmt = DB::pdo()->prepare($sql);

        if (isset($condition['vars'])) {
            foreach ($condition['vars'] as $k => $v) {
                $stmt->bindParam($k, $v);
            }
        }
        $stmt->execute();
        //$stmt->debugDumpParams();

        $users = [];

        foreach ( $stmt->fetchAll(\PDO::FETCH_ASSOC) as $userData) {
            if ($condition['asArray'] === true) {
                $users[] = $userData;
            }
            else {
                $users[] = new CUserModel($userData);
            }
        }

        return $users;
    }

    public static function checkGuestSession() {
        return !isset($_SESSION['user_id']);
    }

    public static function checkAuthorizedSession() {
        return !self::checkGuestSession();
    }

    public static function checkUserSession() {
        if (self::checkGuestSession()) {
            return false;
        }

        return self::getOne($_SESSION['user_id'])->getIsUser();
    }

    public static function checkAdminSession() {
        if (self::checkGuestSession()) {
            return false;
        }

        return self::getOne($_SESSION['user_id'])->getIsAdmin();
    }

    public static function checkOperatorSession() {
        if (self::checkGuestSession()) {
            return false;
        }

        return self::getOne($_SESSION['user_id'])->getIsOperator();
    }

    public static function getFromSession() : CUserModel {
        if (self::checkGuestSession()) {
            return new CUserModel();
        }
        return self::getOne($_SESSION['user_id']);
    }

    public static function getAwardedUsers() : Array {
        $result = [];
        $stmt = DB::pdo()->prepare('SELECT * FROM data.get_awarded_users()');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}