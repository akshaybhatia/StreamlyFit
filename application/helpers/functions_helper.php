<?php

function h($s) {
    return htmlspecialchars($s);
}

function r($s) {
    return mysql_real_escape_string($s);
}

function jump($s) {
    redirect (site_url($s));
    //header('Location: '.site_url().$s);
    //exit;
}

/* End of file account_helper.php */
/* Location: ./application/helpers/account_helper.php */