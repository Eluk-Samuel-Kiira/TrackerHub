<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Requisition Approved and Paid') }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
        <h2 style="color: #2c3e50; text-align: center;">{{ __('Requisition Approved and Paid') }}</h2>
        <p style="font-size: 16px; margin: 10px 0;">Hello,</p>
        <p style="font-size: 16px; margin: 10px 0;">
            The requisition <strong style="color: #2c3e50;">{{ $details['requisitionName'] }}</strong> for the project 
            <strong style="color: #2c3e50;">{{ $details['projectName'] }}</strong> has been approved and the payment has been processed.
        </p>
        <p style="font-size: 16px; margin: 10px 0;"><strong>Accountant:</strong> <span style="color: #27ae60;">{{ $details['accountantName'] }}</span></p>
        <p style="font-size: 16px; margin: 10px 0;"><strong>Approved Amount:</strong> <span style="color: #27ae60;">{{ number_format($details['approvedAmount'], 2) }}</span></p>
        <p style="font-size: 16px; margin: 10px 0;"><strong>Payment Voucher:</strong> <span style="color: #27ae60;">{{ $details['voucher_number'] }}</span></p>
        
        <h3 style="color: #2c3e50; text-align: center;">Requisition Items</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background-color: #2c3e50; color: #fff;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Title/Item</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Receipt No</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Quantity</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Unit Cost</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details['requisition_items'] as $item)
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $item['title'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $item['receipt_no'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $item['quantity'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format($item['unit_cost'], 2) }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <p style="font-size: 16px; margin: 10px 0;">Please reach out if you have any questions.</p>
        <p style="font-size: 16px; margin: 20px 0; text-align: center;">Thank you.</p>
    </div>
</body>
</html>
