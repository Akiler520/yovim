<?php
/**
 * Recommend Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-11-18 12:16:12
 * @author Akiler
 */
class RecommendController extends Yov_Controller{

    /**
     * top 10 sources
     * @var
     */
    private $top10;

    function init(){
        parent::init();

        // set column of list
        $this->filter['column'] = array('id', 'name', 'keywords', 'summary', 'url', 'link', 'snapshot', 'thumb', 'id_user', 'time_add');

        $this->top10 = Recommend::getInstance()->getHottest();
        Yov_init::getInstance()->view->assign('top10', $this->top10);
    }

    public function laudAction(){
        $id_source = $this->request['id_source'];

        if(!User::getInstance()->isLogin()){
            Ak_Message::getInstance()->add('logout')->output(0);
        }

        $userInfo = User::getInstance()->getLoginInfo();

        $data_laud = array(
            'id_source'     => $id_source,
            'id_user'       => $userInfo['id'],
            'time_add'      => date('Y-m-d H:i:s')
        );

        Recommend::getInstance()->insert($data_laud);

        $recommend_cnt = Recommend::getInstance()->getCount('id_source='.$id_source);

        Ak_Message::getInstance()->add('Recommend success, thanks for your join, have a nice day!', array('laud_num' => $recommend_cnt))->output();
    }
}