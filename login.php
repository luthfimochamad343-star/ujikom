<?php
session_start();

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // akun demo
    if ($username == "admin" && $password == "12345") {
        $_SESSION['login'] = true;
        $_SESSION['user']  = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Perpustakaan sekolah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #BFBFBF);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            padding: 30px;
            width: 320px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* LOGO */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 15px;
        }

        .login-logo {
            width: 300px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            /* Agar padding tidak merusak lebar input */
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #1e90ff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            /* Jarak antar tombol */
        }

        button:hover {
            background: #0b74d1;
        }

        /* TOMBOL REGISTRASI */
        .btn-register {
            background: #2ecc71;
            text-decoration: none;
            display: block;
            text-align: center;
            padding: 10px;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-register:hover {
            background: #27ae60;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 15px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <div class="logo-wrapper">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJwAAACUCAMAAABRNbASAAAA1VBMVEX///95mD4DUI8HqtrzihLyfgAAptn85diyw5hyky9uw+XF5fMATY19xuXl6vCKob9AtN4ARYkAOIPJ1OHt8PUwX5jo7eEAQYjzhwBNcaF8mkQASoxEap3yggAAPYb72sPw+PwAoNYgsd4AMYH607fk8/mDn02Ambn+9e4XW5a2xNZ6kbVukCXw8+v2o1r0kiT2qGXziiP4xJz0kjIAKX4iZJuW0eqdsMhdeab3tYHI1LamuYmNpmH4vpLU3cf1p230mEMAIHut2+9miw9ph694hq5rd6UGDn32AAAJFklEQVR4nO2a/1eqzBbGERVfExEEAh1AxK9gx9JOYqc6neu19///k+6eGUAUKE9idtfi+aHVKpz5sPfsZw+MDFOoUKFChQoVKlSoUKFChQoVKvR/odrfXHx9LooMDR+Pv/bX0/k4UjU0e8deen3zzzlJUtTT9SMzez3+erjKkXQ/xvX610euot9PP77ux3O9dAm4il79kO5HqV66DFxFX3yQWRy3S8BVsPTquzV7Xcdsl4KrVMyX7Gt+EbQLwlX0edbCewrYLghXMRfDtAt+j29Kl4erVG4fk8H7px7G7evgRo0k3O1tpTrcx/t9s0OLwY1GZ0Szm454CAdot5DbeSy3v59vSqU0uCuneTa8FceVIzg9ZAM6XBfmPY3ej9/jeqmUAcdxXNM+B5rd7JfLEdz0rhrChWVbrdSw7d4cssXgYABOPEfwRK4cg2OYF3OPDVQFuOtDMqw4HCh/ulW/HIeDFA4rOllv+3DdBNr4EE7MmuOzssX9gXuvU6a3iMctC2487h7AcZuc4RrlAzhT7zHTP+YxcPVDuNW54aA+lwd06XDdbgKueXY43LimzJ35Dly3201U65fA4eWmL5bMo5kJ1x2DLgFXo8Vg3k1fqllwgNY9O5wsJ+GY2h21Xr03XGTBPWdHTvCEPND8NZqlwDHMa5XSPfaqevqae35+7mbAyf9RZ6fi2X5b46VJEm64ZJhlRad4y/v3TDgdrs1LP2fKSWxri2fZNLgerDYmDNniTxJu3P0AjmVZzTgleIYEQ6TDQakOmdq9nuVzZLV9AMeyD5+PnU/YMuCgVB/3XTjW+MFFjojcwwM7+yyb0kEUrpUOB1vM2vTVTIGjFvIRnPvwwBufDZ2g8gROS4Mz6R5uOX2sJuDiYcuGe3BZlmc/u+oEIwEXbdOZJS0Gc76jC+HGx8BZD+5JcEoCztnBMTW63HRz+FLR43DdA7Z0OM11YXTe/Twcuw/n7OBqtWinbr6+xHwOuv1RcAgHjuXVvCLnOLE1hx+lX0wastu5voMblw59OD2tZOhT4FAcztmD06vwKL1cULp4WseJHvGOz50At28l+3CQzj81vCE+8Lkk25fAlZ0DnwMj2esRWU9fXwK31/hDI5nem98OLugM8CAxnevfDQ5cmEasOu+FzxHfCI6pBdu5yvL1m8EN5+DCcxoycx73uW8A1zPhyYsJeoS++F6Rg81m9XXKDBMP1d8DDtJ532OG1W/ocz1qJK/T2kK/FJyLd4Tpa4668H0P6IKXTVlwN+F5a75wsJHOshLo+eSESX+s/XkXrl56Dk+qc4bDG8IMn5suaePS58PAUtLg6qWn3SF6vnDseyYMeLgabiuL13kW3M1T/Hz/3AXB9a82DTvCe9XxW2H9Ph2u/vw7GmzUaJa5M8PB0BwnNsOzkmB3oqfB1W9+RUNtrhyOi0Y4Hxwdv7yx6UVhD0vA1aM6GDWdMhf/cC5wwTNEChzM4KwCvOj14R5c5B+jZuKj+cNxiTnE4K34sJpMa/iNCLtJdvfnhRs1RZHj9gEdLjjK6iUbf7Dc4J722fAYziqCY3OBgxiMRo2V0+f26Mq0MmrVfbj/BlV6xdEHypCs76w2o9HIzjlykRpNkYtN2afvd0mH3cHRUmhw5RgYJ141dsPkBscbk5bvyXbw51FD7ONn/2DSK/L3XnUHd0PjtoKMhvfA9Zub8MhLkP3JbI1ygmN5iYjdegJ9Y4XNIZqXHgP2zBCO2pt9RdhEcpUYVLYit9ZkKITYvODYkLGtrVtyhBcmjB4DvugUrv4UsJUdUcTx7YvUEwVvprY1tD9kbnBYSOLVFglfQ4xqg8bujsDVnwk7+acIdFyZRk3eqvDZw+HyhcMDau0ZCd/GCZtlGc8/XRA4XAx2AO4ES1LxjAFKHStvONZlJX4rkPj041WxxHDEfJtBnXIcialvaKlorOueAKdRSShOSXbHaDDBw27CdXeFPxB+RaIZeA09R/KQlUwnkiQYlz0BbjsDC/H91rbDDmAp8zs2kKZ6zK6txc9QNxx9I0UOfYU3bR+Ll6zBQF3D0DDybJvHKZMt+2uVhey4rhutvbVCy5IoctgReVvmUIvxpXhCwZNUY5vPsRdjK4KwG0kBQBSfS3JxYVA6LtojE4Oj9ids2/HL2+osHzASKhWGVFVjPQnHtAU/7ghI8hm6xHaJbfQJGy4RmZXY3aVoKyvRXc46HcNQVRUPbf8dmQBO/u/bZDKZva0Nvt22rIEF9ksJ5Za6W+HWbEdHJxHLJG7wm69Fl2lo69v0nr0tLGALlrDR2c5Ab/+uW7veeASbIEfRh8RCDAdtqC5kzDz6f4+PbEvbhnQ0dBv6Xhsma0lR9xtMaF+RJx3W0iTrpzvxZEGJppCFk7IttzquxCLtZ8cjY8rQIwM6XBZk3TkjXB9OsP4mVlg3BtnVKPLEGkhod4t5ChZhB+KF2gZxOMbbBtHT1kFL4Bq4VB3azibUQXjL9fHdKK21pvF8G03kkw5Z35G8dcGQJWlN1ojcoT6hwbqzSY+FfRJOagOvNxo1FVcMVC3Cn2M7+ccsLsE3SPjWZBrfILmzWmRnWe4zDN5/gvd6JOca28I34W0tCULIBhuac0rxVAgYQiQKdossvbaH95aQV5sjnUzA5Yw0ckwud5CENzOtfKz3Q3lbaBX8gOApM5xbJJOvia3wztxmFJWHSK1xoOQ1BJq3Ov7XkBHJaptnJekNR8NzNVYyoBb65eaKJHUmsZKGfU2ZIZxQyTtXEWTI64CNwd4ET9tikTXBiYXHR9iIeAMeYfdTWj9RVBNfK9tzLbw3wVPLRhsSS77GNmIE+DvOqKdCxWqa/8VRC/F8cAdeWuPc+lrHhraKu8S2jQtBWENkJdS6DBqWMIHKQBYJHoKfDgcBs3Cd+FDFyDr5SzenSe6A70v4yysKRHCzYuwO/t2QeF7rnN/XPpJnaC7bxsEjvkzCZiFWM87bDY6U4iOX196iDApvFuxDLlQHSSkTaJ1aEClPQwid9hWqnOV12ryFiZSZxbbP3N//Xh40DFaW8c8LmO5HUloSfsTVLuhs70mGh3D18vaRJe8bZrRQoUKFChUqVKhQoUKFChUqVOh4/Q8stBh0YEtJ2gAAAABJRU5ErkJggg==" alt="Logo Perpustakaan" class="login-logo">
        </div>

        <h2>Login Perpustakaan </h2>

        <?php if ($error != "") { ?>
            <div class="error"><?= $error ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>

            <a href="registrasi.php" class="btn-register">Registrasi</a>
        </form>

        <div class="footer">
            © 2026 perpustakaan
        </div>

    </div>

</body>

</html>