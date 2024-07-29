<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <!-- Custom styles for this template-->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
            color: #5a5c69;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        h2 {
            color: #4e73df;
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        p {
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .button {
            display: block;
            width: fit-content;
            padding: 10px 20px;
            font-size: 0.9rem;
            color: #ffffff;
            background-color: #4e73df;
            text-decoration: none;
            border-radius: 0.35rem;
            text-align: center;
            margin: 0 auto 20px auto;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #b7b9cc;
            font-size: 0.8rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
        }

        .text-gray-900 {
            color: #3a3b45 !important;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <h2 class="text-gray-900">Halo,</h2>
        <p>Kami menerima permintaan untuk mereset password akun Anda.</p>
        <p>Klik link berikut untuk mereset password Anda:</p>
        <a href="{{ route('reset.password.get', $token) }}" class="button">Reset Password</a>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        <p>Terima kasih,</p>
        <p>Prohana Team</p>
        <div class="footer">
            <p>&copy; 2024 Prohana. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
