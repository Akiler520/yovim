<?php
/**
 * Index Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-12 12:46:16
 * @author Akiler
 */
class IndexController extends Yov_Controller{

    function init(){
        parent::init();

        // set column of list
        $this->filter['column'] = array('id', 'name', 'keywords', 'summary', 'url', 'link', 'snapshot', 'thumb',  'id_user', 'time_add');
    }

    public function indexAction(){
        $filter = $this->filter;
        $filter['_list_type'] = 'sourceList';

        $list = Source::getInstance()->lists($filter);

        $count = Source::getInstance()->getCount('active=1');

        $PagerObj = new Ak_Pagination($count,intval($this->filter['page']), intval($this->filter['limit']));

        $pageStr = $PagerObj->getPagination();

        $top10 = Recommend::getInstance()->getHottest();

        $top_tag = Hot_Tag::getInstance()->getHottest();
        Yov_init::getInstance()->view->assign('top_tag', $top_tag);

        Yov_init::getInstance()->view->assign('pagination', $pageStr);
        Yov_init::getInstance()->view->assign('list', $list);
        Yov_init::getInstance()->view->assign('top10', $top10);

        $this->display('source/list.tpl');
    }

    public function testAction(){
        $postData = array(
            'name'  => 'test'
        );
//        $data_replay = Yov_Relay::getInstance()->setUrl('http://yovim.com')->setPostData($postData)->relay();


        $str = 'test <script  dd src="/gg_bd_ad_720x90.js" type="text/javascript">    </script> 123';

        $contents_new = preg_replace('/<script(.*?)src="\/gg_bd_ad.*?>(.*?)<\/script>/is', " ", $str);

        Ak_String::printm($contents_new);

//        User::getInstance()->login('admin', '123123');
//        $this->display('admin_source/add.tpl', false);
    }

    public function postAction(){
        Ak_String::printm($_SERVER, false);
        Ak_String::printm($_REQUEST, false);
        Ak_String::printm($_POST, false);
        Ak_String::printm($_GET, false);
        Ak_String::printm(Yov_Router::getInstance()->getRequest());
    }

    public function testuserAction(){
        $userObj = new User();

        $userInfo = $userObj->getById(1);

        Ak_String::printm($userInfo);
    }
}