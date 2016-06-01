<?php

function error_res($msg) {
    $msg = $msg == "" ? "error" : $msg;
    return array("status" => 0, "msg" => $msg);
}

function success_res($msg) {

    $msg = $msg == "" ? "Success" : $msg;
    return array("status" => 1, "msg" => $msg);
}

function check_login() {
    $CI = & get_instance();
    $aid = $CI->session->userdata('aid');
    if ($aid == "") {
        return false;
    }
    return true;
}

function admin_id() {

    $CI = & get_instance();
    $aid = $CI->session->userdata('aid');
    return $aid;
}
