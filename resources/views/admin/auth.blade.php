<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel log in</title>
    <style>
    .login-form form{
        border: 2px solid black;
        padding: 20px;
        border-radius: 4px;
        display: flex;
        flex-direction: column;
        width: 40%;
        margin: 100px auto;
        justify-content: space-between;
    }
    form input{
        margin-bottom: 20px;
    }
    form button{
        width: 40%;
        margin: 0 auto;        
    }
    form label{
        padding-left: 40px;
    }
    </style>
</head>
<body>
    <div class="login-form">
        <form action="/admin-check" method="POST">
            @csrf
            <label for="login">Login</label>
            <input type="text" name="login" id="login">
            <label for="passw">Password</label>
            <input type="password" name="passw" id="passw">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>