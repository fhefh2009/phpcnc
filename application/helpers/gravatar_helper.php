<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function get_gravatar_hash($email){
    return md5(strtolower(trim( $email)));
}