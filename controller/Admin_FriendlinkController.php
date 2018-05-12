<?php
/**
 * Friend link Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-11-30 22:46:16
 * @author Akiler
 */
class Admin_FriendLinkController extends Yov_Controller{

    function init(){
        parent::init();
    }

    public function indexAction(){

    }

    public function listAction(){
        $list = Friend_Link::getInstance()->lists($this->filter);

        $count = Friend_Link::getInstance()->getCount('active=1');

        $data_output = array(
            'total' => $count,
            'rows'  => $list
        );

        Ak_Message::getInstance()->add(json_encode($data_output))->output(1, 0);
    }

    public function addPageAction(){
        $this->displaySingle('admin_friendLink/add.tpl');
    }

    public function addAction(){
        if(empty($this->request['name']) || empty($this->request['url'])){
            Ak_Message::getInstance()->add('Error, you missed some parameters, check please!')->output(0);
        }

        $data_add = array(
            'name'          => $this->request['name'],
            'url'           => $this->request['url'],
            'description'   => $this->request['description'],
            'order'         => $this->request['order'],
            'time_add'      => date('Y-m-d H:i:s')
        );

        $ret_add = Friend_Link::getInstance()->insert($data_add);

        if(!$ret_add){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }

    public function editPageAction(){
        $this->displaySingle('admin_friendLink/edit.tpl');
    }

    public function editAction(){
        $id_friendlink = $this->request['id'];

        $info = Friend_Link::getInstance()->getById($id_friendlink);

        if(empty($info)){
            Ak_Message::getInstance()->add('Error, don\'t find the friend link, check please!')->output(0);
        }

        $data_edit = array(
            'name'          => $this->request['name'],
            'url'           => $this->request['url'],
            'description'   => $this->request['description'],
            'order'         => $this->request['order']
        );

        $ret = Friend_Link::getInstance()->update($data_edit, 'id='.$id_friendlink);

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }

    public function deleteAction(){
        $id_friendlink = $this->request['id_friendlink'];

        $data_edit = array(
            'active'          => 0
        );

        $ret = Friend_Link::getInstance()->update($data_edit, 'id IN('.$id_friendlink.')');

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }

    public function detailAction(){
        $id_friendlink = $this->request['id_friendlink'];

        $info = Friend_Link::getInstance()->getById($id_friendlink);

        if(empty($info)){
            Ak_Message::getInstance()->add('Error, don\'t find the friend link, check please!')->output(0);
        }

        Ak_Message::getInstance()->add('ok', $info)->output();
    }
}