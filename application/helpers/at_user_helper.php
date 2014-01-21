<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function extract_at_users($text){
//    preg_match_all('/(?:@)(\S{1,18})/', $text, $at_users);
//    return $at_users[1];
    preg_match_all('/@\S{1,21}/', $text, $at_users);
    foreach($at_users[0] as &$at_user){
        $at_user = substr($at_user, 1);
    }
    unset($at_user);
    return array_unique($at_users[0]);
}

function at_users_to_html($text, $at_users){
    foreach($at_users as $at_user){
        $replace = "@<a href=\"member/{$at_user['id']}\">{$at_user['username']}</a>";
        $text = str_replace('@'.$at_user['username'], $replace, $text);
    }
    return $text;
//    $html = preg_replace('/@\S{1,18}/', $at_users, $text);
//    return $html;
}