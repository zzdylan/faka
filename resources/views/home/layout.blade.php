<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{config('base.site_name')}}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/layuicms/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/layuicms/css/public.css" media="all" />
</head>
<body class="childrenBody">
@yield('content')
<script type="text/javascript" src="/layui/layui.js"></script>
<script>
    var noticeData = {!! json_encode(config('notice')) !!};
    localStorage.setItem('noticeData',JSON.stringify(noticeData));
</script>
@yield('script')
</body>
</html>
