<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail App Password Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        h2 { color: #007bff; margin-top: 30px; }
        .step {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
            border-radius: 5px;
        }
        .step-number {
            font-weight: bold;
            color: #007bff;
            margin-right: 10px;
        }
        .important {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #ffc107;
        }
        .form-group {
            margin: 20px 0;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .note {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Gmail App Password Setup</h1>
        <p>To send verification codes to Gmail, you need to create an App Password. Follow these steps:</p>
        
        <div class="important">
            <strong>⚠️ Important:</strong> You must have 2-Step Verification enabled on your Google Account first!
        </div>
        
        <h2>Step 1: Enable 2-Step Verification</h2>
        <div class="step">
            <span class="step-number">1.</span>
            Go to: <a href="https://myaccount.google.com/signinoptions/two-step-verification" target="_blank">https://myaccount.google.com/signinoptions/two-step-verification</a>
        </div>
        <div class="step">
            <span class="step-number">2.</span>
            Click <strong>Get Started</strong> and follow the steps to enable 2-Step Verification
        </div>
        
        <h2>Step 2: Create App Password</h2>
        <div class="step">
            <span class="step-number">1.</span>
            Go to: <a href="https://myaccount.google.com/apppasswords" target="_blank">https://myaccount.google.com/apppasswords</a>
        </div>
        <div class="step">
            <span class="step-number">2.</span>
            In the "Select app" dropdown, choose <strong>Mail</strong>
        </div>
        <div class="step">
            <span class="step-number">3.</span>
            In the "Select device" dropdown, choose <strong>Other (Custom name)</strong> and type: <strong>BHCA Portal</strong>
        </div>
        <div class="step">
            <span class="step-number">4.</span>
            Click <strong>Generate</strong>
        </div>
        <div class="step">
            <span class="step-number">5.</span>
            <strong>Copy the 16-character password</strong> that appears (it will look like: xxxx xxxx xxxx xxxx)
        </div>
        
        <h2>Step 3: Enter the Password Here</h2>
        <form action="<?=site_url('login/save_app_password')?>" method="post">
            <div class="form-group">
                <label><strong>App Password:</strong></label>
                <input type="text" name="app_password" placeholder="e.g., abcd efgh ijkl mnop" required>
                <p class="note">Enter the 16-character password you just generated</p>
            </div>
            <button type="submit">Save Password</button>
        </form>
        
        <hr>
        <p><a href="<?=site_url('login/forgotpass')?>">← Back to Forgot Password</a></p>
    </div>
</body>
</html>
