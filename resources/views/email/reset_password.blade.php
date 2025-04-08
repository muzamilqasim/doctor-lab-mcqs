<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $formData['subject'] }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: royalblue;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #fff;
        }

        .content {
            padding: 30px;
        }

        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .cta {
            text-align: center;
            margin: 20px 0;
        }

        .cta a {
            background-color: royalblue;
            color: #fff;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .footer {
            background-color: #f4f4f7;
            padding: 15px;
            text-align: center;
        }

        .footer p {
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $formData['subject'] }}</h1>
        </div>

        <div class="content">
            <p>Hello,</p>
            <p>Use the following code to complete your action:</p>
            <div class="cta">
                <a href="#">{{ $formData['code'] }}</a>
            </div>
            <p>If you did not request this, please ignore this email or contact our support team.</p>
        </div>

            <div class="footer">
                <p>© {{ date('Y') }} All rights reserved.</p>
            </div>
    </div>
</body>
</html>
