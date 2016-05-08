<?php
/**
 * Created by PhpStorm.
 * User: bin.shen
 * Date: 5/7/16
 * Time: 13:53
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        //////////////
        //for test only
        $user_info['user_id'] = 1;
        $user_info['username'] = 'test';
        $user_info['rel_name'] = 'Test';
        $user_info['role_id'] = 4;
        $user_info['company_id'] = 1;
        $user_info['subsidiary_id'] = 1;
        $this->session->set_userdata($user_info);
        //////////////

        $this->load->model('activity_model');
    }

    public function list_activity() {
        $this->load->view('list_activity.html');
    }

    public function list_review() {

        $role_id = $this->session->userdata('role_id');
        if($role_id == 1) {
            $company_list = $this->activity_model->get_company_list();
            $this->assign('company_list', $company_list);
        } else if($role_id == 4) {
            $subsidiary_id = $this->session->userdata('subsidiary_id');
            $subsidiary_list = $this->activity_model->get_subsidiary_list(null, $subsidiary_id);
            $this->assign('subsidiary_list', $subsidiary_list);
        } else {
            $company_id = $this->session->userdata('company_id');
            $subsidiary_list = $this->activity_model->get_subsidiary_list($company_id);
            $this->assign('subsidiary_list', $subsidiary_list);
        }

        $data = $this->activity_model->list_activity();
        $this->assign('activity_list', $data);

        $pager = $this->pagination->getPageLink('/activity/list_review', $data['countPage'], $data['numPerPage']);
        $this->assign('pager', $pager);

        $this->assign('role_id', $role_id);
        $this->display('list_review.html');
    }

    public function get_subsidiary_list($company_id) {

        $subsidiary_list = $this->activity_model->get_subsidiary_list($company_id);
        echo json_encode($subsidiary_list);
        die;
    }

    public function get_subsidiary_user_list($subsidiary_id) {

        $subsidiary_user_list = $this->activity_model->get_subsidiary_user_list($subsidiary_id);
        echo json_encode($subsidiary_user_list);
        die;
    }
}