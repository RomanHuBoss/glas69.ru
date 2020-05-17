<?php


namespace Glas\Controllers;


use Glas\Models\CAppealModel;

class CAppealController extends CAbstractController
{
    function search($data = []) {
        $limitNum = 50;
        $tail = 'WHERE is_public = true ';

        if (isset($_GET['time'])) {

            $vars = [];

            if ($_GET['limit'] && intval($_GET['limit']) > 0 && intval($_GET['limit']) <= 50) {
                $limitNum = intval($_GET['limit']);
            }

            if ($_GET['time'] == 'all') {
            }
            else if ($_GET['time'] == 'till_new_year') {
                $tail .= ' AND time_created >= :time_created';
                $vars['time_created'] = '01-01-'.date('Y');
            }
        }
        else if (isset($_GET['status']) && $_GET['status'] == 'active') {
            $tail .= ' AND time_moderated IS NULL OR time_official_response IS NULL';
        }

        $limit = ' LIMIT '.$limitNum;

        $appeals = CAppealModel::getSeveral([
            'tail' => $tail,
            'vars' => $vars,
            'asArray' => true,
            'limit' => $limit
        ]);

        header('Content-type: application/json');
        echo json_encode($appeals);
        exit;
    }
}