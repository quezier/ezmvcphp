<?php
namespace App\Test\Controller;
use Core\PubFunc;
use Core\PdoHelper;
use Core\CreateModel;

/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
class CreateModelController
{

    function createModel()
    {
        $dbConfigArray = PubFunc::config('db');
        $createModel = new CreateModel();
        $tableName = $_GET['table_name'];
        $rs = $createModel->createModel($dbConfigArray['dbName'],$tableName);
        PubFunc::varDump($rs);
    }
}