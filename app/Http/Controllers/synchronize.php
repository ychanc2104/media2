<?php
$ip = array(
    '172.16.47.252','172.16.47.253','172.16.32.64','172.16.32.65','172.16.32.66','172.16.32.67','172.16.32.68','172.16.32.69',
    '172.16.32.70','172.16.32.71','172.16.32.72','172.16.32.73','172.16.32.74','172.16.32.75','172.16.32.76','172.16.32.77',
    '172.16.32.81','172.16.32.82','172.16.32.83','172.16.32.84','172.16.32.85','172.16.32.86','172.16.32.87','172.16.32.88',
    '172.16.32.89','172.16.32.90','172.16.32.91','172.16.32.92','172.16.32.94','172.16.32.95','172.16.32.96','172.16.32.97'
);

// $ip = array(
//     '172.16.47.253',
// );

foreach($ip as $val){
    //要丟的程式=>要丟的位置 有就取代
    print_r($val."\n");
    // exec("scp /var/www/html/taja/synchronize/conn_monitor.php root@".$val.":/var/www/html/cron_job/conn_monitor.php");
    // exec("scp /var/www/html/taja/ad_keyword_api.php root@".$val.":/var/www/html/api/ad_keyword_api.php");
    exec("scp /var/www/html/taja/DBHelper.php root@".$val.":/var/www/html/likr_library/DBHelper.php");

}

?>