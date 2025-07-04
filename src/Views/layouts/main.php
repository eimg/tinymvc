<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'TinyMVC' ?></title>
    <meta name="description" content="TinyMVC is a PHP micro-framework that bundle with MVC pattern and responsive web design boilarplate.">
    <meta http-equiv="cleartype" content="on">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/touch.png">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/layout.css" media="all and (min-width: 33.236em)">
    <!--[if (lt IE 9) & (!IEMobile)]>
    <link rel="stylesheet" href="/css/layout.css">
    <![endif]-->
    <script src="/js/libs/modernizr.js"></script>
</head>
<body>
    <div id="container" class="cf">
        <header>
            <h1 role="brand">Tiny<span>MVC</span></h1>
        </header>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/home/about">About</a></li>
                <li><a href="/home/contact">Contact</a></li>
                <li><a href="/home/license">License</a></li>
                <li><a href="https://github.com/eimg/tinymvc/archive/master.zip">Download</a></li>
            </ul>
        </nav>
        <div id="main" role="main">
            <?= $content ?>
        </div>
        <footer>
            <p class="legal">
                <a href="/home/license">The MIT License</a>: Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated files without restriction, including without limitation the rights to use, copy, modify, and distribute.
            </p>
            <p class="copy">
                &copy; Copyright 2024. All right reserved.
            </p>
        </footer>
    </div>
    <script src="/js/libs/jquery.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
