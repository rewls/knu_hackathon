<?php
function getBrowser() {
    $broswerList = array('MSIE', 'Chrome', 'Firefox', 'iPhone', 'iPad', 'Android', 'PPC', 'Safari', 'Trident', 'none');
    $browserName = 'none';

    foreach ($broswerList as $userBrowser){
        if($userBrowser === 'none') break;
        if(strpos($_SERVER['HTTP_USER_AGENT'], $userBrowser)) {
            $browserName = $userBrowser;
            break;
        }
    }
    return $browserName;
}

function isBlockBrowser() {
    $BrowserName = getBrowser();
    if($BrowserName === 'MSIE'||$BrowserName === 'Trident'){
        die("Internet Explorer is not supported.");
    }
}
isBlockBrowser();
?>
