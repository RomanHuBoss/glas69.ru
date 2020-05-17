<?php


namespace Glas\Models;

use Glas\Utils\DB;

class CAppealModel extends CAbstractModel
implements ISelectable
{
    private $id;
    private $id_problem_type;
    private $id_author;
    private $id_moderator;
    private $id_authority;
    private $id_status;
    private $time_created;
    private $time_moderated;
    private $subject;
    private $message;
    private $id_address;
    private $coordinates;
    private $photos;
    private $is_public = false;
    private $official_response;
    private $time_official_response;
    private $id_decline_reason;

    public function __construct(Array $data = [])
    {
        foreach ($data as $k => $v) {
            if (in_array($k, ['is_public']) && is_null($v)) {
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
    public function getIdProblemType()
    {
        return $this->id_problem_type;
    }

    /**
     * @return mixed
     */
    public function getIdAuthor()
    {
        return $this->id_author;
    }

    /**
     * @return mixed
     */
    public function getIdModerator()
    {
        return $this->id_moderator;
    }

    /**
     * @return mixed
     */
    public function getIdAuthority()
    {
        return $this->id_authority;
    }

    /**
     * @return mixed
     */
    public function getIdStatus()
    {
        return $this->id_status;
    }

    /**
     * @return mixed
     */
    public function getTimeCreated()
    {
        return $this->time_created;
    }

    /**
     * @return mixed
     */
    public function getTimeModerated()
    {
        return $this->time_moderated;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
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
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @return bool
     */
    public function isIsPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * @return mixed
     */
    public function getOfficialResponse()
    {
        return $this->official_response;
    }

    /**
     * @return mixed
     */
    public function getTimeOfficialResponse()
    {
        return $this->time_official_response;
    }

    /**
     * @return mixed
     */
    public function getIdDeclineReason()
    {
        return $this->id_decline_reason;
    }

    static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    static function getOne($id)
    {
        // TODO: Implement getOne() method.
    }

    static function getSeveral($condition = [])
    {
        $sql = 'SELECT a.*, a.coordinates[0] as lon, a.coordinates[1] as lat, fh.full_address, pt.name_full as problem_name 
            FROM data.appeal as a 
                LEFT JOIN classifiers.fias_house as fh ON fh.fias_code = a.id_address
                LEFT JOIN classifiers.problem_type as pt ON pt.id = a.id_problem_type
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
                $stmt->bindParam(':'.$k, $v);
            }
        }
        $stmt->execute();

        $appeals = [];

        foreach ( $stmt->fetchAll(\PDO::FETCH_ASSOC) as $appealData) {
            if ($condition['asArray'] === true) {
                $appeals[] = $appealData;
            }
            else {
                $appeals[] = new CAppealModel($appealData);
            }
        }

        return $appeals;
    }

    public static function getAppealsStats() : Array {
        $sql = "SELECT * FROM data.get_appeals_stats()";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }



}