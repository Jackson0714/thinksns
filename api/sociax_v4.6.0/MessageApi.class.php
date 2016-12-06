<?php
/**
 * 消息API.
 *
 * @author Medz Seven <lovevipdsw@vip.qq.com>
 **/
class MessageApi extends Api
{
    /**
     * 获取socket地址
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function getSocketAddress()
    {   
        $return = model('Xdata')->get('admin_Application:socket');

        return Ts\Service\ApiMessage::withArray($return, 1, '');
    }

    /**
     * 获取用户信息.
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function getUserInfo()
    {
        $uid = intval($_REQUEST['uid']);

        if (!$uid) {
            $this->error(array(
<<<<<<< HEAD
                'data' => '',
                'status' => '0',
                'msg' => '没有传入UID',
            ));
        } elseif (!($user = model('User')->getUserInfo($uid))) {
            $this->error(array(
                'data' => '',
                'status' => '0',
                'msg' => '用户不存在',
            ));
        }
        $return = array(
            'uname' => $user['uname'],
=======
                'status' => '-1',
                'msg'    => '没有传入UID',
            ));
        } elseif (!($user = model('User')->getUserInfo($uid))) {
            $this->error(array(
                'status' => '-2',
                'msg'    => '用户不存在',
            ));
        }

        return array(
            'status' => '1',
            'uname'  => $user['uname'],
>>>>>>> origin/master
            'remark' => $user['remark'],
            'avatar' => $user['avatar_original'],
            'intro'  => $user['intro'] ? formatEmoji(false, $user['intro']) : '',
        );

        return Ts\Service\ApiMessage::withArray($return, 1, '');
    }

    /**
     * 获取用户头像.
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function getUserFace()
    {
        list($uid, $method, $size) = array($_REQUEST['uid'], $_REQUEST['method'], $_REQUEST['size']);
        list($uid, $method, $size) = array(intval($uid), t($method), t($size));
        $uid or $uid = $this->mid;
        $method or $method = 'stream'; // stream, url, redirect
        $size or $size = 'big';    // original, big, middle, small

        if (!in_array($method, array('stream', 'url', 'redirect'))) {
            $this->error(array(
                'data' => '',
                'status' => 0,
                'msg'    => '获取模式错误',
            ));
        } elseif (!in_array($size, array('original', 'big', 'middle', 'small'))) {
            $this->array(array(
                'data' => '',
                'status' => 0,
                'msg'    => '头像尺寸错误',
            ));
        } elseif (!$uid) {
            $this->error(array(
                'data' => '',
                'status' => 0,
                'msg'    => '不存在用户',
            ));
        } elseif (!($user = model('User')->getUserInfo($uid))) {
            $this->error(array(
                'data' => '',
                'status' => 0,
                'msg'    => '该用户不存在',
            ));
        }

        $size = 'avatar_'.$size;
        $face = $user[$size];

        if ($method == 'stream') {
            ob_end_clean();
            header('Content-type: image/jpg');
            echo file_get_contents($face);
            exit;
        } elseif ($method == 'redirect') {
            ob_end_clean();
            header('Location:'.$face);
            exit;
        }

<<<<<<< HEAD
        $return = array(
            'url' => $face,
=======
        return array(
            'status' => 1,
            'url'    => $face,
>>>>>>> origin/master
        );

        return Ts\Service\ApiMessage::withArray($return, 1, '');
    }

    /**
     * 获取附件信息.
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function getAttach()
    {
        list($hash, $method) = array($_REQUEST['hash'], $_REQUEST['method']);
        list($hash, $method) = array($hash, t($method));

        $logo = intval($this->data['logo']);

        $method or $method = 'stream'; // stream, url, redirect

        // # 解密成ID
        $hash = @desdecrypt($hash, C('SECURE_CODE'));

        $hash or
        $hash = $logo;

        if (!$hash) {
            $this->error(array(
<<<<<<< HEAD
                'data' => '',
                'status' => 0,
                'msg' => '没有传递需要获取的附件ID',
            ));
        } elseif (!in_array($method, array('stream', 'url', 'redirect'))) {
            $this->error(array(
                'data' => '',
                'status' => 0,
                'msg' => '没有正确的传递获取模式',
            ));
        } elseif (!($attach = model('Attach')->getAttachById(intval($hash)))) {
            $this->error(array(
                'data' => '',
                'status' => 0,
                'msg' => '没有这个附件',
=======
                'status' => '-1',
                'msg'    => '没有传递需要获取的附件ID',
            ));
        } elseif (!in_array($method, array('stream', 'url', 'redirect'))) {
            $this->error(array(
                'status' => '-2',
                'msg'    => '没有正确的传递获取模式',
            ));
        } elseif (!($attach = model('Attach')->getAttachById(intval($hash)))) {
            $this->error(array(
                'status' => '-3',
                'msg'    => '没有这个附件',
>>>>>>> origin/master
            ));
        } elseif ($method == 'stream') {
            ob_end_clean();
            header('Content-type:'.$attach['type']);
            echo file_get_contents(getAttachUrl($attach['save_path'].$attach['save_name']));
            exit;
        } elseif ($method == 'redirect') {
            ob_end_clean();
            header('Location:'.getAttachUrl($attach['save_path'].$attach['save_name']));
            exit;
        }

<<<<<<< HEAD
        $return = array(
            'url' => getAttachUrl($attach['save_path'].$attach['save_name']),
            'width' => $attach['width'],
            'height' => $attach['height'],
=======
        return array(
            'status' => '1',
            'url'    => getAttachUrl($attach['save_path'].$attach['save_name']),
            'width'  => $attach['width'],
            'height' => $attach['height'],
            'msg'    => '获取成功',
>>>>>>> origin/master
        );

        return Ts\Service\ApiMessage::withArray($return, 1, '获取成功');
    }

    /**
     * 上传图片.
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function uploadImage()
    {
        return $this->uploadFile('image', 'message_image', 'gif', 'jpg', 'png', 'jpeg', 'bmp');
    }

    /**
     * 上传语音.
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function uploadVoice()
    {
        return $this->uploadFile('file', 'message_voice', 'mp3', 'ogg', 'wav');
    }

    /**
     * 上传位置图片.
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    public function uploadLocationImage()
    {
        return $this->uploadFile('image', 'message_location', 'gif', 'jpg', 'png', 'jpeg', 'bmp');
    }

    /**
     * 上传群组头像接口.
     *
     * @return array
     *
     * @author Seven Du <lovevipdsw@outlook.com>
     **/
    public function uploadGroupLogo()
    {
        $data = $this->uploadFile('image', 'message_group_logo', 'jpg', 'png', 'bmp', 'jpeg', 'gif');
        if ($data['status'] != '1' or !isset($data['list']) or !$data['list'] or !is_array($data['list'])) {
            return $data;
        }
        $data = $data['list'];
        $data = array_pop($data);
        $data = @desdecrypt($data, C('SECURE_CODE'));
        if (!$data) {
<<<<<<< HEAD

            return Ts\Service\ApiMessage::withArray('', 0, '上传失败');
            // return array(
            //     'status' => 0,
            //     'msg' => '上传失败',
            // );
        }

        return Ts\Service\ApiMessage::withArray($data, 1, '');
        // return array(
        //     'status' => 1,
        //     'logo' => $data,
        // );
=======
            return array(
                'status' => 0,
                'mes'    => '上传失败',
            );
        }

        return array(
            'status' => 1,
            'logo'   => $data,
        );
>>>>>>> origin/master
    }

    /**
     * 上传文件.
     *
     * @param string $uploadType 上传文件的类型
     * @param string $attachType 保存文件的类型
     * @param string [$param, $param ...] 限制文件上传的类型
     *
     * @return array
     *
     * @author Medz Seven <lovevipdsw@vip.qq.com>
     **/
    protected function uploadFile($uploadType, $attachType)
    {
        $ext = func_get_args();
        array_shift($ext);
        array_shift($ext);

        $option = array(
            'attach_type' => $attachType,
        );
        count($ext) and $option['allow_exts'] = implode(',', $ext);

        $info = model('Attach')->upload(array(
            'upload_type' => $uploadType,
        ), $option);

        // # 判断是否有上传
        if (count($info['info']) <= 0) {
            $this->error(array(
<<<<<<< HEAD
                'data' => '',
                'status' => 0,
                'msg' => '没有上传的文件',
=======
                'status' => '-1',
                'msg'    => '没有上传的文件',
>>>>>>> origin/master
            ));

        // # 判断是否上传成功
        } elseif ($info['status'] == false) {
            $this->error(array(
<<<<<<< HEAD
                'data' => '',
                'status' => 0,
                'msg' => $info['info'],
=======
                'status' => '0',
                'msg'    => $info['info'],
>>>>>>> origin/master
            ));
        }

        $data = array();
        foreach ($info['info'] as $value) {
            $value = desencrypt($value['attach_id'], C('SECURE_CODE'));
            array_push($data, $value);
        }

<<<<<<< HEAD
        return Ts\Service\ApiMessage::withArray($data, 1, '');
        // return array(
        //     'status' => '1',
        //     'list' => $data,
        // );
=======
        return array(
            'status' => '1',
            'list'   => $data,
        );
>>>>>>> origin/master
    }

    public function unreadcount()
    {
        /*return array(
'comment' => 0, 'atme' => 0, 'digg' => 0, 'follower' => 0, 'weiba' => 0, 'weiba_comment' => 0, 'unread_digg_weibapost' => 0,
        );*/
<<<<<<< HEAD
        $count = model('UserData')->setUid($GLOBALS ['ts'] ['mid'])->getUserData();
        $return = array(
            'comment' => (string) intval($count ['unread_comment']),
            'atme' => (string) intval($count ['unread_atme']),
            'digg' => (string) intval($count ['unread_digg']),
            'follower' => (string) intval($count ['new_folower_count']),
            'weiba' => (string) intval($count ['new_folower_count']),
            'weiba_comment' => intval($count['unread_comment_weiba']),
=======
        $count = model('UserData')->setUid($GLOBALS['ts']['mid'])->getUserData();

        return array(
            'comment'               => (string) intval($count['unread_comment']),
            'atme'                  => (string) intval($count['unread_atme']),
            'digg'                  => (string) intval($count['unread_digg']),
            'follower'              => (string) intval($count['new_folower_count']),
            'weiba'                 => (string) intval($count['new_folower_count']),
            'weiba_comment'         => intval($count['unread_comment_weiba']),
>>>>>>> origin/master
            'unread_digg_weibapost' => intval($count['unread_digg_weibapost']),
        );

        return Ts\Service\ApiMessage::withArray($return, 1, '');
    }

    /**
     * 获取群聊信息 --using.
     *
     * @param int $list_id
     *                     群聊ID
     *
     * @return array 成员、及群聊创建者的信息
     */
    public function get_list_info()
    {
        $list_id = intval($this->data['list_id']);
        $list_info = D('message_list')->field('list_id,from_uid,type as room_type,title,member_num, logo')->where('list_id='.$list_id)->find();
<<<<<<< HEAD
        if (! $list_info) {

            return Ts\Service\ApiMessage::withArray('', 0, '房间不存在');
            // return $this->error('房间不存在');
        }
        // 加入成员列表
        $members = D('message_member')->where('list_id='.$list_id)->order('ctime ASC')->field('member_uid')->findAll();
        if (! $members) {

            return Ts\Service\ApiMessage::withArray('', 0, '没有任何用户');
            // return $this->error('没有任何用户');
=======
        if (!$list_info) {
            return $this->error('房间不存在');
        }
        // 加入成员列表
        $members = D('message_member')->where('list_id='.$list_id)->order('ctime ASC')->field('member_uid')->findAll();
        if (!$members) {
            return $this->error('没有任何用户');
>>>>>>> origin/master
        }
        foreach ($members as $k => $v) {
            $user_info_whole = model('User')->getUserInfo($v['member_uid']);
            $user_info['uid'] = $user_info_whole['uid'];
            $user_info['uname'] = $user_info_whole['uname'];
            $user_info['avatar'] = $user_info_whole['avatar_middle'];
            $user_info['remark'] = $user_info_whole['remark'];
            $list_info['memebrs'][] = $user_info;
            unset($user_info, $user_info_whole);
        }
        // 格式化信息
        if ($list_info['room_type'] == 1) {
            $list_info['room_type'] = 'chat';
        } elseif ($list_info['room_type'] == 2) {
            $list_info['room_type'] = 'group';
        }
        $list_info['status'] = 1;

        return Ts\Service\ApiMessage::withArray($list_info, 1, '');
        // return $list_info;
    }

    /**
     * 判断是否有发私信的权限	--using.
     *
     * @param
     *        	integer user_id 目标用户ID
     *
     * @return array 状态+提示
     */
    public function can_send_message()
    {
        $uid = intval($this->user_id);
<<<<<<< HEAD
        if (! $uid) {

            return Ts\Service\ApiMessage::withArray('', 0, '请选择用户');
            // return $this->error('请选择用户');
=======
        if (!$uid) {
            return $this->error('请选择用户');
>>>>>>> origin/master
        }
        $data = model('UserPrivacy')->getPrivacy($this->mid, $uid);
        if ($data['message'] == 1) {

            return Ts\Service\ApiMessage::withArray('', 0, '您没有权限给TA发私信');
            // return $this->error('您没有权限给TA发私信');
        }

        return Ts\Service\ApiMessage::withArray('', 1, '可以发私信');
        // return $this->success('可以发私信');
    }

    /**
     * 获取当前用户聊天列表  --using.
     *
     * @param
     *
     * @return array
     */
    public function get_message_list()
    {
        $this->data['type'] = $this->data['type'] ? $this->data['type'] : array(1, 2);
        $this->data['order'] = $this->data['order'] == 'ASC' ? '`list_ctime` ASC' : '`list_ctime` DESC';
        $message = model('Message')->getMessageListByUidForAPI($this->mid, $this->data['type']);
        $message = $this->__formatMessageList($message);
        foreach ($message as &$_l) {
            $_l['from_uid'] = $_l['last_message']['from_uid'];
            $_l['content'] = $_l['last_message']['content'];
            unset($_l['last_message']);
            unset($_l['to_user_info']);
        }

        return Ts\Service\ApiMessage::withArray($message, 1, '');
        // return $message;
    }

    private function __formatMessageList($message)
    {
        foreach ($message as $k => $v) {
            $message[$k] = $this->__formatMessageDetail($v);
        }

        return Ts\Service\ApiMessage::withArray($message, 1, '');
        // return $message;
    }

    private function __formatMessageDetail($message)
    {
        unset($message['deleted_by']);
        $fromUserInfo = model('User')->getUserInfo($message['from_uid']);
        $message['from_uname'] = $fromUserInfo['uname'];
        $message['remark'] = $fromUserInfo['remark'];
        $message['from_face'] = $fromUserInfo['avatar_middle'];
        $message['timestmap'] = $message['mtime'];
        $message['ctime'] = date('Y-m-d H:i', $message['mtime']);
        $uids = explode('_', $message['min_max']);
        $message['with_uid'] = $uids[0] == $this->mid ? $uids[1] : $uids[0];
        $message['with_uid_userinfo'] = model('User')->getUserInfo($message['with_uid']);

        return Ts\Service\ApiMessage::withArray($message, 1, '');
        // return $message;
    }
}
