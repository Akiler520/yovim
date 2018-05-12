<?php
/**
 * Admin source type management Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-11-27 12:46:16
 * @author Akiler
 */
class Admin_SourceTypeController extends Yov_Controller{

    function init(){
        parent::init();

        // set column of list, don't set it, default to be *.
//        $this->filter['column'] = array('id', 'name');
    }

    function listAction(){
        $list = Source_Type::getInstance()->lists($this->filter);

        $count = Source_Type::getInstance()->getCount('active=1');

        $data_output = array(
            'total' => $count,
            'rows'  => $list
        );

        Ak_Message::getInstance()->add(json_encode($data_output))->output(1, 0);
    }

    function addPageAction(){
        $this->displaySingle('admin_sourceType/add.tpl');
    }

    function addAction(){
        if(Source_Type::getInstance()->getCount('name="'.$this->request['name'].'"') > 0){
            Ak_Message::getInstance()->add('Error, the type is exist, check please!')->output(0);
        }

        $data = $this->request;
        $data['time_add'] = date('Y-m-d H:i:s');

        $ret = Source_Type::getInstance()->insert($data);

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }

    function editPageAction(){
        $this->displaySingle('admin_sourceType/edit.tpl');
    }

    function editAction(){
        $id_source_type = $this->request['id'];

        $info = Source_Type::getInstance()->getById($id_source_type);

        if(empty($info)){
            Ak_Message::getInstance()->add('Error, don\'t find the source type, check please!')->output(0);
        }

        $data_edit = array(
            'name'          => $this->request['name'],
            'description'   => $this->request['description']
        );

        $ret = Source_Type::getInstance()->update($data_edit, 'id='.$id_source_type);

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }

    function detailAction(){
        $id_source_type = $this->request['id_source_type'];

        $info = Source_Type::getInstance()->getById($id_source_type);

        if(empty($info)){
            Ak_Message::getInstance()->add('Error, don\'t find the source type, check please!')->output(0);
        }

        Ak_Message::getInstance()->add('ok', $info)->output();
    }

    function deleteAction(){
        $id_source_type = $this->request['id_source_type'];

        $data_edit = array(
            'active'          => 0
        );

        $ret = Source_Type::getInstance()->update($data_edit, 'id IN('.$id_source_type.')');

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }
}