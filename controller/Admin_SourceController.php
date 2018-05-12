<?php
/**
 * Admin Source Management Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-26 12:46:16
 * @author Akiler
 */
class Admin_SourceController extends Yov_Controller{

    function init(){
        parent::init();

        // set column of list
        $this->filter['column'] = array('id', 'name', 'keywords', 'summary', 'snapshot', 'id_user', 'time_add');
    }

    function listAction(){
        $list = Source::getInstance()->lists($this->filter);

        $count = Source::getInstance()->getCount('active=1');

        $data_output = array(
            'total' => $count,
            'rows'  => $list
        );

        Ak_Message::getInstance()->add(json_encode($data_output))->output(1, 0);
    }

    function addPageAction(){
        // get source type list
        $sourceTypeList = Source_Type::getInstance()->lists();

        Yov_init::getInstance()->view->assign('source_type_list', $sourceTypeList);

        $this->display('admin_source/add.tpl', false);
    }

    function editPageAction(){
        $sourceTypeList = Source_Type::getInstance()->lists();

        Yov_init::getInstance()->view->assign('source_type_list', $sourceTypeList);

        $this->display('admin_source/edit.tpl', false);
    }

    function addAction(){
        $loginInfo = User::getInstance()->getLoginInfo();

        $sourceName = $this->request['source'];
        $sourceLink = '';
        $snapshotLink = '';
        $snapshotThumbLink = '';

        $nameInfo = pathinfo($sourceName);

        $sourceNameReal = $nameInfo['filename'];

        $dateFolder = date('Ym').'/';

        $url = $this->request['url'];

        $sourceTmp = UPLOAD_PATH_TMP.$sourceName;
        $sourceTargetPath = UPLOAD_PATH.$dateFolder;
        $sourceTarget = $sourceTargetPath.$sourceName;

        Ak_FileSystem_Dir::make($sourceTargetPath);

        // move source to the target folder and decompress it
        if(is_file($sourceTmp)){
            // move it to target folder by month
            if(Ak_FileSystem_File::move($sourceTmp, $sourceTarget)){
                // decompress it
                $sourceLink = 'source/'.$dateFolder.$sourceNameReal.'/';

                $zipObj = new ZipArchive();

                if($zipObj->open($sourceTarget) === true){
                    if($zipObj->extractTo($sourceTargetPath)){
                        // check if there is an index file in the source
                        $extractFiles = Ak_FileSystem_File::getFilesByType($sourceTargetPath.$sourceNameReal);

                        if(!empty($extractFiles)){
                            foreach($extractFiles as $val_file){
                                if($val_file == 'index.html' || $val_file == 'index.htm'){
                                    $url = $val_file;
                                    break;
                                }
                            }
                        }

                        // move snapshot to the source root path
                        if(!empty($this->request['snapshot']) && is_file(UPLOAD_PATH_TMP.$this->request['snapshot'])){
                            Ak_FileSystem_File::move(UPLOAD_PATH_TMP.$this->request['snapshot'],
                                                    $sourceTargetPath.$sourceNameReal.'/'.$this->request['snapshot']);
                            Ak_FileSystem_File::move(UPLOAD_PATH_TMP.THUMB_KEY.$this->request['snapshot'],
                                                    $sourceTargetPath.$sourceNameReal.'/'.THUMB_KEY.$this->request['snapshot']);

                            $snapshotLink = $sourceLink.$this->request['snapshot'];
                            $snapshotThumbLink = $sourceLink.THUMB_KEY.$this->request['snapshot'];
                        }
                    }

                    $zipObj->close();
                }
            }
        }

        $data_add = array(
            'name'          => $this->request['name'],
            'keywords'      => $this->request['keywords'],
            'summary'       => $this->request['summary'],
            'description'   => $this->request['description'],
            'url'           => $url,
            'link'          => $sourceLink,
            'snapshot'      => $snapshotLink,
            'thumb'         => $snapshotThumbLink,      // thumbnail
            'hash'          => $this->request['source_hash'],
            'hash_snap'     => $this->request['snapshot_hash'],
            'id_user'       => $loginInfo['id'],
            'id_source_type'=> $this->request['type'],
            'origin'        => $this->request['origin'],
            'time_add'      => date('Y-m-d H:i:s')
        );

        $id_source = Source::getInstance()->insert($data_add);

        // remove the AD code in source file
        Source::getInstance()->removeAD($id_source);

        Ak_Message::getInstance()->add('Success')->output();
    }

    function addSnapshotAction(){
        $uploadObj = new Ak_Upload($_FILES['fileBarSnapshot']);

        if ($uploadObj->getError() == 0) {
            $upfileInfo = $uploadObj->getUpFileInfo();

            $uploadObj->setSavePath(UPLOAD_PATH_TMP);
            $uploadObj->setFileNameRand(1);
            $uploadObj->setSaveFileNamePrefix();

            $uploadObj->uploadAll();

            $ret = $uploadObj->getResult();

            // create thumbnail
            Source::getInstance()->createThumb(UPLOAD_PATH_TMP.$ret['save_name'][0], UPLOAD_PATH_TMP.THUMB_KEY.$ret['save_name'][0]);

            $ret_data = array('filename'=> $ret['save_name'][0]);

            Ak_Message::getInstance()->add('ok', $ret_data)->output();
        }else{
            Ak_Message::getInstance()->add('Error happened')->output(0);
        }
    }

    function editSnapshotAction(){
        $id_source = $this->request['id'];

        $uploadObj = new Ak_Upload($_FILES['fileBarSnapshot']);

        if ($uploadObj->getError() == 0) {
            $upfileInfo = $uploadObj->getUpFileInfo();

            $uploadObj->setSavePath(UPLOAD_PATH_TMP);
            $uploadObj->setFileNameRand(1);
            $uploadObj->setSaveFileNamePrefix();

            $uploadObj->uploadAll();

            $ret = $uploadObj->getResult();

            $snapshotName = $ret['save_name'][0];

            // get source info
            $sourceInfo = Source::getInstance()->getById($id_source);

            if(!empty($sourceInfo)){
                // if the source path is exist, move snapshot into it,or throw error
                if(!empty($sourceInfo['link']) && is_dir(ROOT_PATH.$sourceInfo['link'])){
                    // create thumbnail
                    Source::getInstance()->createThumb(UPLOAD_PATH_TMP.$snapshotName, UPLOAD_PATH_TMP.THUMB_KEY.$snapshotName);

                    $snapshotPath = ROOT_PATH.$sourceInfo['snapshot'];  // cover the old one directly
                    $snapshotThumbPath = ROOT_PATH.$sourceInfo['thumb'];  // cover the old one directly

                    $hasSnapshot = true;
                    // there is not snapshot or thumb, create it
                    if(empty($sourceInfo['snapshot']) || empty($sourceInfo['thumb'])){
                        $hasSnapshot = false;
                        $snapshotPath = ROOT_PATH.$sourceInfo['link'].$snapshotName;
                        $snapshotThumbPath = ROOT_PATH.$sourceInfo['link'].THUMB_KEY.$snapshotName;
                    }

                    if(Ak_FileSystem_File::move(UPLOAD_PATH_TMP.$snapshotName, $snapshotPath )
                        && Ak_FileSystem_File::move(UPLOAD_PATH_TMP.THUMB_KEY.$snapshotName, $snapshotThumbPath)
                    ){
                        if(!$hasSnapshot){
                            // save the path into database
                            $data_edit = array(
                                'snapshot'   => $sourceInfo['link'].$snapshotName,
                                'thumb'      => $sourceInfo['link'].THUMB_KEY.$snapshotName,
                                'hash_snap'  => $this->request['hash']
                            );

                            $ret = Source::getInstance()->update($data_edit, 'id='.$id_source);
                            if($ret){
                                Ak_Message::getInstance()->add("Change snapshot success!")->output();
                            }else{
                                Ak_Message::getInstance()->add("Error: failed to update the link into database!!")->output(0);
                            }
                        }else{
                            // update the hash code
                            $data_edit = array(
                                'hash_snap'  => $this->request['hash']
                            );

                            $ret = Source::getInstance()->update($data_edit, 'id='.$id_source);
                            if($ret){
                                Ak_Message::getInstance()->add("Change snapshot success!")->output();
                            }else{
                                Ak_Message::getInstance()->add("Error: failed to update the link into database!!")->output(0);
                            }
                        }
                    }else{
                        Ak_Message::getInstance()->add("Error: failed to change the link of snapshot!")->output(0);
                    }
                }else{
                    Ak_Message::getInstance()->add("Error: can't find the source, check please!")->output(0);
                }
            }else{
                Ak_Message::getInstance()->add("Error: can't find the source, check please!")->output(0);
            }
        }else{
            Ak_Message::getInstance()->add('Error happened')->output(0);
        }
    }

    function addSourceAction(){
        $uploadObj = new Ak_Upload($_FILES['fileBarSource']);
//        Ak_String::printm($_FILES);
        if ($uploadObj->getError() == 0) {
            $upfileInfo = $uploadObj->getUpFileInfo();

            $uploadObj->setSavePath(UPLOAD_PATH_TMP);
            $uploadObj->setFileNameRand(0);
            $uploadObj->setSaveFileNamePrefix();

            $uploadObj->uploadAll();

            $ret = $uploadObj->getResult();

            $ret_data = array('filename'=> $ret['save_name'][0]);

            Ak_Message::getInstance()->add('ok', $ret_data)->output();
        }else{
            Ak_Message::getInstance()->add('Error happened')->output(0);
        }
    }

    function detailAction(){
        $id_source = $this->request['id_source'];

        $info = Source::getInstance()->getById($id_source);

        if(empty($info)){
            Ak_Message::getInstance()->add('Error, don\'t find the source, check please!')->output(0);
        }

        Ak_Message::getInstance()->add('ok', $info)->output();
    }

    function editAction(){
        if(empty($this->request['id'])){
            Ak_Message::getInstance()->add("Can't find the source!")->output(0);
        }

//        Ak_String::printm($this->request);

        $data_edit = array(
            'name'          => $this->request['name'],
            'keywords'      => $this->request['keywords'],
            'summary'       => $this->request['summary'],
            'description'   => $this->request['description'],
            'url'           => empty($this->request['url']) ? 'index.html' : $this->request['url'],
            'id_source_type'=> $this->request['type'],
            'origin'        => $this->request['origin']
        );

        $ret = Source::getInstance()->update($data_edit, 'id='.$this->request['id']);

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('Edit source success.')->toLog(LOG_SYS_SUCCESS);
            Ak_Message::getInstance()->add('Edit source success.')->output();
        }
    }

    function uniqueAction(){
        $hashCode = $this->request['hash'];
        $uniqType = $this->request['type'];

        $ret = Source::getInstance()->uniqueCheck($hashCode, $uniqType);

        Ak_Message::getInstance()->add('ok', $ret)->output();
    }

    function deleteAction(){
        $id_source = $this->request['id_source'];

        $ret = Source::getInstance()->update(array('active' => 0), 'id IN('.$id_source.')');

        if(!$ret){
            Ak_Message::getInstance()->add('Error')->output(0);
        }else{
            Ak_Message::getInstance()->add('ok')->output();
        }
    }
}