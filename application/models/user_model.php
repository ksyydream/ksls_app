<?php
/**
 * Created by PhpStorm.
 * User: bin.shen
 * Date: 5/9/16
 * Time: 13:40
 */

class User_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * 用户登录检查
     *
     * @return boolean
     */
    public function check_login ()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->where('password', sha1($password));
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            $res = $rs->row();
            $user_info['login_user_id'] = $res->id;
            $user_info['login_username'] = $username;
            $user_info['login_rel_name'] = $res->rel_name;
            $user_info['login_role_id'] = $res->role_id;
            $user_info['login_company_id'] = $res->company_id;
            $user_info['login_subsidiary_id'] = $res->subsidiary_id;
            $this->session->set_userdata($user_info);
            return true;
        }
        return false;
    }
}