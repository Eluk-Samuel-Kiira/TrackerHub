<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f8fb;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            margin: 15px 0;
            line-height: 1.6;
        }
        .email-footer {
            background-color: #f4f8fb;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }
        .btn-primary {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 15px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $companyName }}</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Hello <strong>{{ $username }}</strong>,</p>
            <p>{!! nl2br($emailMessage ) !!}</p>
            <p><strong>Project Name:</strong> {{ $projectName }}</p>
            <p>If you have any questions or need further clarification, please do not hesitate to reach out.</p>
            <a href="{{ url('/') }}" class="btn-primary">Visit Dashboard</a>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
        </div>
    </div>
</body>
</html>
