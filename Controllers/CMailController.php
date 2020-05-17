<?php


namespace Glas\Controllers;

use Glas\Models\CAppealModel;
use Glas\Models\CInternalMessageModel;
use Glas\Models\CUserModel;
use Glas\Utils\CRenderer;

class CMailController extends CAbstractController
{
    public function __construct(CUserModel $currentUser)
    {
        parent::__construct($currentUser);
    }

    public function sendForm($data = []) {
        (new CRenderer())->render('SendInternalMailFormView', [
            'title' => 'Личное сообщение',
            'currentUser' => $this->currentUser
        ]);
    }

    public function send($data = []) {
        $receiver_id = CUserModel::getSeveral([
            'asArray' => true,
            'limit' => " LIMIT 1",
            'tail' => " WHERE fio LIKE :receiver",
            'vars' => [
                'receiver' => $_POST['receiver'],
            ]
        ])[0]['id'];

        CInternalMessageModel::create([
            'receiver_id' => $receiver_id,
            'sender_id' => $this->currentUser->getId(),
            'subject' => $_POST['subject'],
            'message' => $_POST['message']
        ]);

        header('Location: /mail/outbox');
        exit;
    }

    public function receiverSearch($data  = []) {
        if (!isset($_GET['request'])) {
            http_response_code(400);
            exit;
        }

        $tail = " WHERE lower(fio) LIKE :request";
        $order = ' ORDER BY fio ASC';
        $limit = ' LIMIT 15';

        $users = CUserModel::getSeveral([
            'asArray' => true,
            'tail' => $tail,
            'order' => $order,
            'limit' => $limit,
            'vars' => [
                'request' => '%' . mb_strtolower($_GET['request']) .'%'
            ]
        ]);

        $result = [];
        foreach ($users as $user) {
            $result[] = ['label' => $user['fio'], 'value' => $user['fio']];
        }

       header('Content-Type: application/json');
        echo json_encode($result);
        exit;

    }

    public function outbox($data = []) {
        $currentPage = 1;
        $offset = 0;
        $records2page = 50;

        $maxPages = ceil($this->currentUser->getInternalMailStats()['outbox_total']/$records2page) + 1;

        if (isset($data['varData']['page']) && $data['varData']['page'] > 0) {
            $currentPage = $data['varData']['page'];

            if ($currentPage > $maxPages) {
                $currentPage = $maxPages;
            }

            $offset = ($currentPage - 1) * $records2page;

        }

        $limit = ' LIMIT '.$records2page.' OFFSET '.$offset;
        $tail = ' WHERE id_sender = :user_id AND removed_from_outbox = false';
        $order = ' ORDER BY time_created DESC';

        $messages = CInternalMessageModel::getSeveral([
            'order' => $order,
            'limit' => $limit,
            'tail' => $tail,
            'vars' => [
                'user_id' => $this->currentUser->getId()
            ]
        ]);

        (new CRenderer())->render('OutboxPageView', [
            'title' => 'Исходящие сообщения',
            'currentUser' => $this->currentUser,
            'messages' => $messages
        ]);
    }

    public function inbox($data = []) {
        $currentPage = 1;
        $offset = 0;
        $records2page = 50;

        $maxPages = ceil($this->currentUser->getInternalMailStats()['inbox_total']/$records2page) + 1;

        if (isset($data['varData']['page']) && $data['varData']['page'] > 0) {
            $currentPage = $data['varData']['page'];

            if ($currentPage > $maxPages) {
                $currentPage = $maxPages;
            }

            $offset = ($currentPage - 1) * $records2page;

        }

        $limit = ' LIMIT '.$records2page.' OFFSET '.$offset;
        $tail = ' WHERE id_receiver = :user_id AND removed_from_inbox = false';
        $order = ' ORDER BY time_created DESC';

        $messages = CInternalMessageModel::getSeveral([
            'order' => $order,
            'limit' => $limit,
            'tail' => $tail,
            'vars' => [
                'user_id' => $this->currentUser->getId()
            ]
        ]);

        (new CRenderer())->render('InboxPageView', [
            'title' => 'Входящие сообщения',
            'currentUser' => $this->currentUser,
            'messages' => $messages
        ]);
    }
}