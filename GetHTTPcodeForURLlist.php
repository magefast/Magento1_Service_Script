<pre>
<?php
/**
 * Get HTTP code for URL list
 */

$list = [];
$list[] = 'https://site.com/link1/';
$list[] = 'https://site.com/link2/';
$list[] = 'https://site.com/link3/';

foreach ($list as $url) {
    echo checkUrlCode($url) . ';' . $url . '<br>';
}

function checkUrlCode($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpcode;
}

?>
</pre>
