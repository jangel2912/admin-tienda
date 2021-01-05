<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>QR Code PDF Template</title>
	<style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        h1 {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: inherit;
            margin-top: 20px;
            margin-bottom: 10px;
            margin: .67em 0;
            font-size: 2em; 
            margin: .67em 0;
            font-size: 2em;
        }
        p {
            margin-bottom: 0px;
            margin-top: 0px;
        }
        a {
            font-family: inherit;
            line-height: 1.1;
            color: inherit;
        }
        .page-break {
            page-break-after: always;
        }
        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }
        .text-center {
            text-align: center;
        }
        .bg-color {
            background-color: #62cb31;
            padding: 8px;
            color: #fff;
        }
        .mb-30 {
            margin-bottom: 30px;
        }
        .shop-link {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="bg-color text-center mb-30">{{ $shop->shopname }}</h1>
        <div class="text-center mb-30">
            <img src="data:image/png;base64, {!! $qrcode !!}">
        </div>
        <p class="bg-color text-center"><a class="shop-link" href="{{ $url}}">{{ $url }}</a></p>
    </div>
</body>
</html>