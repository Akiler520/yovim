<?php
/**
 * Source Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-18 12:46:16
 * @author Akiler
 */
class SourceController extends Yov_Controller{

    /**
     * top 10 sources
     * @var
     */
    private $top10;

    /**
     * top tag
     * @var
     */
    private $top_tag;

    function init(){
        parent::init();

        // set column of list
        $this->filter['column'] = array('id', 'name', 'keywords', 'summary', 'url', 'link', 'snapshot', 'thumb', 'id_user', 'time_add');

        $this->top10 = Recommend::getInstance()->getHottest();
        Yov_init::getInstance()->view->assign('top10', $this->top10);

        $this->top_tag = Hot_Tag::getInstance()->getHottest();
        Yov_init::getInstance()->view->assign('top_tag', $this->top_tag);
    }
    public function indexAction(){

    }

    function listAction(){
        $filter = $this->filter;

        $where = array('active=1');

        if(isset($this->request['type'])){
            $where[] = $filter['where'] = 'id_source_type='.$this->request['type'];
        }

        $filter['_list_type'] = 'sourceList';

        $list = Source::getInstance()->lists($filter);

        $count = Source::getInstance()->getCount(implode(' AND ', $where));

        $PagerObj = new Ak_Pagination($count,intval($this->filter['page']), intval($this->filter['limit']));

        $pageStr = $PagerObj->getPagination();

        Yov_init::getInstance()->view->assign('pagination', $pageStr);
        Yov_init::getInstance()->view->assign('list', $list);

        $this->display('source/list.tpl');
    }

    function detailAction(){
        $id_source = $this->request['code'];

        $info = Source::getInstance()->getDetail($id_source);

        Yov_init::getInstance()->view->assign('info', $info);

        $this->display('source/detail.tpl');
    }

    function demoAction(){
        $id_source = $this->request['code'];

        $sourceInfo = Source::getInstance()->getById($id_source);

        $this->displaySource($sourceInfo['url']);
    }

    function searchAction(){
        $keyword = $this->request['keyword'];
        $typeId = $this->request['type'];

        $filter = $this->filter;

        $filter['keyword'] = $keyword;

        $filter['_list_type'] = 'sourceList';

        $ret_search = Source::getInstance()->search($filter);

        $count = $ret_search['count'];
        $list = $ret_search['data'];

        $PagerObj = new Ak_Pagination($count,intval($this->filter['page']), intval($this->filter['limit']));

        $PagerObj->setParams(array('keyword' => $keyword));

        $pageStr = $PagerObj->getPagination();

        Hot_Tag::getInstance()->updateTag($keyword);

        Yov_init::getInstance()->view->assign('pagination', $pageStr);
        Yov_init::getInstance()->view->assign('list', $list);

        $this->display('source/search.tpl');
    }

}