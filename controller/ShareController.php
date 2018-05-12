<?php
/**
 * Share Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-22 12:46:16
 * @author Akiler
 */
class ShareController extends Yov_Controller{

    function init(){
        parent::init();
    }

    function scriptsAction(){
        $UE_path = ROOT_PATH.'share/scripts/ueditor/php/';
//        require_once($UE_path.'controller.php');

        date_default_timezone_set("Asia/chongqing");
        error_reporting(E_ERROR);
        header("Content-Type: text/html; charset=utf-8");

        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($UE_path."config.json")), true);
        $action = $this->request['action'];

        switch ($action) {
            case 'config':
                $result =  json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = include($UE_path."action_upload.php");
                break;

            /* 列出图片 */
            case 'listimage':
                $result = include($UE_path."action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include($UE_path."action_list.php");
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = include($UE_path."action_crawler.php");
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }

    function fckeditorAction(){
        $editor = new Fckeditor("content"); //content为Fckeditor文本框的名字

         $editor->BasePath = ROOT_PATH."share/script/fckeditor/";

         $editor->Value = "请在此处输入文章内容";

         Yov_init::getInstance()->view->assign('editor', $editor->CreateHtml()); //调用CreateHtml方法产生html语句供视图模板调用。

//         $this->render();
    }
}