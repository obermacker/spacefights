<?php
    session_start();
    session_unset(); 
    session_destroy(); 
    $_SESSION = array(); 
?>
     <html><head>
     <meta http-equiv="refresh" content="0; URL=index.html"></head>
<body></body></html>