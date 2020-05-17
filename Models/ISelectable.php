<?php

namespace Glas\Models;

interface ISelectable {
    static function getAll();
    static function getOne($id);
    static function getSeveral($conditions = []);
}
