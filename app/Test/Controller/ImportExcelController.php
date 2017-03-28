<?php


namespace App\Test\Controller;


use App\Logic\AnswerLogic;
use App\Logic\QuestionLogic;
use Core\BaseController;
use Core\PubFunc;
class ImportExcelController extends BaseController
{
    private $questionLogic;
    private $answerLogic;
    function __construct()
    {
        parent::__construct();
        $this->questionLogic = new QuestionLogic();
        $this->answerLogic = new AnswerLogic();
    }

    function index(){

        try{
            $xlsPath = PROJECT_ROOT.DIR_SP.'files'.DIR_SP.'question.xls';
            $objPHPExcel = \PHPExcel_IOFactory::load($xlsPath);
            if(!empty($objPHPExcel))
            {
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                if(!empty($sheetData)&&count($sheetData)>0)
                {
                    array_shift($sheetData);
                    $tmpQuestionArray = array();
                    foreach ($sheetData as $sdKey => $sdVal)
                    {
                        $tmpQA = array();
                        $tmpQA['content'] = $sdVal['A'];
                        $tmpQA['score'] = 0.00;
                        $tmpQA['is_del'] = 1;
                        $insertQAResult = $this->questionLogic->insertFromTestData($tmpQA);
                        if($insertQAResult['status']==1&&!empty($insertQAResult['result']))
                        {
                            $newQAID = $insertQAResult['result'];

                            $tmpAData = array();
                            $tmpBData = array();
                            $answerAndTypeA = $sdVal['B'];
                            $answerAndTypeB = $sdVal['C'];
                            $answerAndTypeAArray = explode("|",$answerAndTypeA);
                            $answerAndTypeBArray = explode("|",$answerAndTypeB);
                            $tmpAData['answer_type'] = $this->changeAnswerType(trim($answerAndTypeAArray[0]));
                            $tmpBData['answer_type'] = $this->changeAnswerType(trim($answerAndTypeBArray[0]));
                            $tmpAData['question_id'] = $newQAID;
                            $tmpBData['question_id'] = $newQAID;
                            $tmpAData['content'] = trim($answerAndTypeAArray[1]);
                            $tmpBData['content'] = trim($answerAndTypeBArray[1]);
                            $insertAResult = $this->answerLogic->insertFromTestData($tmpAData);
                            $insertBResult = $this->answerLogic->insertFromTestData($tmpBData);
                        }
                        else{
                            throw new \Exception('插入题目失败');
                        }
                    }
                    PubFunc::varDump($insertQAResult);
                    PubFunc::varDump($insertAResult);
                    PubFunc::varDump($insertBResult);
                }
                else{
                    throw new \Exception('数据转换失败');
                }
            }
            else{
                throw new \Exception('读取excel文件失败');
            }
        }
        catch (\Exception $e)
        {
            echo '处理excel失败:'.$e->getMessage();exit;
        }

    }

    function changeAnswerType(string $type):int
    {
        $_type = 0;
        switch ($type)
        {
            case "E":
                $_type = 1;
                break;
            case "I":
                $_type = 2;
                break;
            case "S":
                $_type = 3;
                break;
            case "N":
                $_type = 4;
                break;
            case "T":
                $_type = 5;
                break;
            case "F":
                $_type = 6;
                break;
            case "J":
                $_type = 7;
                break;
            case "P":
                $_type = 8;
                break;
        }
        return $_type;
    }
}