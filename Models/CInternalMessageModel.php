<?php

namespace Glas\Models;

use Glas\Utils\DB;
use http\Exception;

class CInternalMessageModel extends CAbstractModel implements ISelectable, ICreatable
{
    private $id;
    private $id_sender;
    private $id_receiver;
    private $subject;
    private $message;
    private $photos;
    private $time_created;
    private $time_received;
    private $removed_from_inbox;
    private $removed_from_outbox;

    private $sender_fio;
    private $receiver_fio;
    private $sender_avatar;
    private $receiver_avatar;

    private $receiver_in_contacts = false;
    private $sender_in_contacts = false;
    private $receiver_is_admin = false;
    private $sender_is_admin = false;

    /**
     * @return mixed
     */
    public function getSenderFio()
    {
        return $this->sender_fio;
    }

    /**
     * @return mixed
     */
    public function getReceiverFio()
    {
        return $this->receiver_fio;
    }

    /**
     * @return mixed
     */
    public function getSenderAvatar()
    {
        return $this->sender_avatar;
    }

    /**
     * @return mixed
     */
    public function getReceiverAvatar()
    {
        return $this->receiver_avatar;
    }

    /**
     * @return bool
     */
    public function isReceiverInContacts(): bool
    {
        return $this->receiver_in_contacts;
    }

    /**
     * @return bool
     */
    public function isSenderInContacts(): bool
    {
        return $this->sender_in_contacts;
    }

    /**
     * @return bool
     */
    public function isSenderIsAdmin(): bool
    {
        return $this->sender_is_admin;
    }

    /**
     * @return bool
     */
    public function isReceiverIsAdmin(): bool
    {
        return $this->sender_is_admin;
    }

    public function __construct(Array $data = [])
    {
        foreach ($data as $k => $v) {
            if (in_array($k, ['receiver_in_contacts', 'sender_in_contacts', 'sender_is_admin', 'receiver_is_admin']) && is_null($v)) {
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
    public function getIdSender()
    {
        return $this->id_sender;
    }

    /**
     * @return mixed
     */
    public function getIdReceiver()
    {
        return $this->id_receiver;
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
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @return mixed
     */
    public function getTimeCreated()
    {
        if ($this->time_created == null) {
            return null;
        }
        return date('d-m-Y  h:i', strtotime($this->time_created));
    }

    /**
     * @return mixed
     */
    public function getTimeReceived()
    {
        if ($this->time_received == null) {
            return null;
        }

        return date('d-m-Y h:i', strtotime($this->time_received));
    }

    /**
     * @return mixed
     */
    public function getRemovedFromInbox()
    {
        return $this->removed_from_inbox;
    }

    /**
     * @return mixed
     */
    public function getRemovedFromOutbox()
    {
        return $this->removed_from_outbox;
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
        $sql = 'SELECT im.*, sender.fio as sender_fio, receiver.fio as receiver_fio, 
                sender.avatar as sender_avatar, receiver.avatar as receiver_avatar,
                (sencon.id IS NOT NULL) as receiver_in_contacts,                
                (reccon.id IS NOT NULL) as sender_in_contacts,
                (uts.is_admin OR uts.is_operator) as sender_is_admin,               
                (utr.is_admin OR utr.is_operator) as recevier_is_admin
            FROM data.internal_message as im
                LEFT JOIN data.user as sender ON im.id_sender = sender.id
                    LEFT JOIN data.user_contacts as sencon ON sencon.id_user = im.id_sender AND sencon.id_contact = im.id_receiver
                    LEFT JOIN classifiers.user_type AS uts ON uts.id = sender.id_type
                LEFT JOIN data.user as receiver ON im.id_receiver = receiver.id
                    LEFT JOIN data.user_contacts as reccon ON reccon.id_user = im.id_receiver AND reccon.id_contact = im.id_sender
                    LEFT JOIN classifiers.user_type AS utr ON utr.id = receiver.id_type                      
                                
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
        $messages = [];

        foreach ( $stmt->fetchAll(\PDO::FETCH_ASSOC) as $messageData) {
            if ($condition['asArray'] === true) {
                $messages[] = $messageData;
            }
            else {
                $messages[] = new CInternalMessageModel($messageData);
            }
        }

        return $messages;
    }

    static function create(array $data)
    {
        $sql = "INSERT INTO data.internal_message (id_sender, id_receiver, subject, message) 
            VALUES (:sender_id, :receiver_id, :subject, :message)";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindParam('sender_id', $data['sender_id']);
        $stmt->bindParam('receiver_id', $data['receiver_id']);
        $stmt->bindParam('subject', $data['subject']);
        $stmt->bindParam('message', $data['message']);

        if (!$stmt->execute()) {
            throw \Exception('Не удалось отправить сообщение');
        }
    }
}