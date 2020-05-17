<?php


namespace Glas\Controllers;


use Glas\Models\CAppealModel;
use Glas\Models\CFiasModel;
use Glas\Models\CReferendumModel;
use Glas\Models\CUserModel;
use Glas\Utils\CRenderer;

class CCommonController extends CAbstractController
{
    public function __construct(CUserModel $currentUser)
    {
        parent::__construct($currentUser);
    }

    public function main($data = []) {
        (new CRenderer())->render('MainPageView', [
            'currentUser' => $this->currentUser,
            'usemap' => true,
            'referendumsStats' => CReferendumModel::getReferendumsStats(),
            'appealsStats' => CAppealModel::getAppealsStats(),
            'awardedUsers' => CUserModel::getAwardedUsers(),
            'freshReferendums' => CReferendumModel::getSeveral([
                'asArray' => true,
                'order' => ' ORDER BY r.time_start DESC',
                'limit' => ' LIMIT 4'
            ]),
            'freshAppeals' => CAppealModel::getSeveral([
                'asArray' => true,
                'tail' => ' WHERE a.is_public = TRUE',
                'order' => ' ORDER BY a.time_created DESC',
                'limit' => ' LIMIT 4'
            ])
        ]);
    }


    public function fiasSearch($data = []) {
        //неверный формат запроса
        if (!isset($_GET['request'])) {
            http_response_code(400);
            exit;
        }

        $addressesData = CFiasModel::getByFulltextSearch($_GET['request'], 5);
        $result = [];
        foreach ($addressesData as $addressData) {
            $result[] = ['label' => $addressData['full_address'], 'value' => $addressData['full_address']];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}