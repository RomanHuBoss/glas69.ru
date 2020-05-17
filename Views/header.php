<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.ico">
    <title>ИС "Глас народа" | <?=$data['title']?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- chartist CSS -->
    <link href="/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">

    <!-- morris CSS -->
    <link href="/assets/plugins/morrisjs/morris.css" rel="stylesheet">

    <!-- Vector CSS -->
    <link href="/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="/Views/css/style.css" rel="stylesheet">

    <!-- You can change the theme colors from here -->
    <link href="/Views/css/colors/blue.css" id="theme" rel="stylesheet">

    <link href="/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/assets/plugins/autocomplete/autocomplete.css" rel="stylesheet">
    <link href="/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <? if ($data['usemap'] === true): ?>
    <link rel="stylesheet" href="/assets/plugins/leaflet/leaflet.css" />
    <script src="/assets/plugins/leaflet/leaflet.js"></script>
    <? endif; ?>

</head>


<body class="fix-header fix-sidebar card-no-border">

<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
