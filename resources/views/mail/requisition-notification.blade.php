<!DOCTYPE html>
<html>
<head>
    <title>New Requisition Notification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
        <h2 style="color: #2c3e50; text-align: center;">New Requisition Submitted</h2>
        <p style="font-size: 16px;">Hello,</p>
        <p style="font-size: 16px;">
            A new requisition <strong>{{ $details['requisitionName'] }}</strong> for the project 
            <strong>{{ $details['projectName'] }}</strong> has been submitted by <strong>{{ $details['submittedBy'] }}</strong>.
        </p>
        <p style="font-size: 16px;"><strong>Total Amount:</strong> {{ number_format($details['totalAmount'], 2) }}</p>
        <p style="font-size: 16px;"><strong>Description:</strong> {{ $details['description'] }}</p>
        
        <h3 style="color: #2c3e50;">Requisition Items</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background-color: #2c3e50; color: #fff;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Title</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Quantity</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Unit Cost</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details['requisition_items'] as $item)
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $item['title'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $item['quantity'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format($item['unit_cost'], 2) }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="font-size: 16px;">Please check the system for further details.</p>
        <p style="font-size: 16px;">Thank you.</p>
    </div>
</body>
</html>
