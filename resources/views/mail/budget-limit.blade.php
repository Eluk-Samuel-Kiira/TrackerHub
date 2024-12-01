<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Limit Exceeded</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #eaeaea;
        }
        .email-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.8;
            font-size: 16px;
            color: #555;
        }
        .email-body h2 {
            color: #007bff;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-body ul {
            list-style-type: none;
            padding: 0;
        }
        .email-body ul li {
            margin: 8px 0;
        }
        .email-body ul li strong {
            color: #333;
        }
        .btn {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .highlight {
            color: #dc3545;
            font-weight: bold;
        }
        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
        }
        .email-footer strong {
            color: #333;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                width: 95%;
            }
            .email-body {
                font-size: 14px;
                line-height: 1.6;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $companyName }}</h1>
        </div>
        <div class="email-body">
            <h2>{{ $subject }}</h2>
            <p>
                Dear Team,<br><br>
                This is to notify you that the project 
                <strong>{{ $projectName }}</strong> has exceeded its budget limit of 
                <strong class="highlight">{{ $projectBudgetLimit }}</strong>.
            </p>
            <p>
                The requisition <strong>{{ $requisitionName }}</strong> has an expenditure of 
                <strong class="highlight">{{ $requisitionAmount }} {{ $currency }}</strong>, which exceeds the allocated budget. Below are the details:
            </p>
            <ul>
                <li><strong>Description:</strong> {!! $description !!}</li>
                <li><strong>Project Name:</strong> {{ $projectName }}</li>
                <li><strong>Budget Limit:</strong> {{ $projectBudgetLimit }}</li>
                <li><strong>Requisition Amount:</strong> {{ $requisitionAmount }} {{ $currency }}</li>
            </ul>
            <p>
                Please take the necessary actions to address this matter promptly.
            </p>
            <a href="{{ route('requistion.index') }}" class="btn">View Requisition Details</a>
        </div>
        <div class="email-footer">
            <p>
                Regards,<br>
                <strong>Management</strong><br>
                {{ $companyName }}
            </p>
        </div>
    </div>
</body>
</html>
