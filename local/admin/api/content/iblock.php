<?php
/**
 * @var $userId;
 * @var $userGroupIdList;
 * */

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/api/auth/guard.php");

echo json_encode([
    'list_type' => [0,1],
    'userId'          => $userId,
    'userGroupIdList' => $userGroupIdList,
]);
