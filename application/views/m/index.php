<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>每天一签</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="format-detection" content="email=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="王龙">
    <link rel="stylesheet" href="/public/m/static/css/every.css">
</head>
<body>
<header class="text-center">
    少年干了这碗鸡汤
</header>

<div class="mask">
    <div class="mask-info">
        生成中...
    </div>
</div>

<div id="template"></div>

<img id="templateImg" src="">

<section class="section-wrap">
    <section class="section-box">
        <div class="top-box">
            <div id="left" class="left-box">
                六月初十
            </div>
            <div class="right-box">
                <div class="yearMonth" id="year">2017.07</div>
                <div class="day" id="day">
                    03
                </div>
            </div>
        </div>
        <div class="bottom-box">
            <p class="content" id="contentP">
                心若不动，风又奈何？你若不伤，岁月无恙。珍惜现在，走过了就不要后悔；
            </p>
        </div>
    </section>
</section>

<small class="info">长按上图保存到手机相册</small>

<div class="content-box">
    <textarea id="content" placeholder="属于自己的鸡汤"></textarea>
</div>

<div class="footer-group">
    <a class="cursor transition js-generate">
        生成
    </a>
</div>


<script src="/public/m/static/js/jquery.min.js"></script>
<script src="/public/m/static/js/html2canvas.min.js"></script>
<script src="/public/m/static/js/getCNDate.js"></script>
<script src="/public/m/static/js/every.js"></script>

</body>
</html>