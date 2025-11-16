<?php
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$full_url = $protocol . "://" . $host . $request_uri;
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/styles.css">
        <link rel="icon" href="assets/icons/apnlogo.png">

        <meta property="og:title" content="Alt på Nett">
        <meta property="og:type" content="article">
        <meta property="og:site_name" content="Alt på Nett">
        <meta property="og:url" content="<?php echo $full_url; ?>">
        <meta property="og:image" content="/altpanett/assets/icons/apnlogo.png">
        <meta property="og:description" content="Alt på Nett er en portal for alle 'på nett' programmene.">
    </head>

    <body>
        <div class="sidebar">
            <div class="sidebar-application-icon" data-url="/ordpanett/index.php"><img src="/ordpanett/assets/opnlogo-highres.png"></div>
            <div class="sidebar-application-icon" data-url="/samtalerpanett/main.php"><img src="/samtalerpanett/assets/icons/logo.ico"></div>
            <div class="sidebar-application-icon" data-url="/tonerpanett/index.php"><img src="/tonerpanett/assets/icons/logo.png"></div>
        </div>
        <iframe id="content-iframe" src="/ordpanett/index.php"></iframe>

        <script src="scripts/iframes.js"></script>
    </body>
</html>