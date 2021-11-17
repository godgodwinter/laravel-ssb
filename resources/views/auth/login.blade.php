<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Login - {{ Fungsi::app_nama() }}</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{ asset('/') }}assets/css/kopekstylesheet.css'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;1,300;1,400&display=swap"
        rel="stylesheet">
    <!-- <script src='main.js'></script> -->
    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
</head>

<body>
    <div id="container">
        <div id="wrapper">
            <div id="loginForm">
                <form action="{{ route('login') }}" method="POST" >
                    @csrf

                    <h1>Login</h1>
                    <div id="inputField">
                        <input type="text" placeholder="Username" autocomplete="nope" name="identity">
                    </div>
                    @error('identity')
                        <p id="wrong" class="wrong">
                            {{ $message }}
                        </p>
                    @enderror
                    <div id="inputField">
                        <input type="password" placeholder="Password" autocomplete="nope" name="password">
                    </div>

                    @error('password')
                        <p id="wrong" class="wrong">
                            {{ $message }}
                        </p>
                    @enderror

                    <div id="inputSignIn">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>
            <div id="logoCompany">
                <div id="opacity">
                    <a href="#" id="linkLogo">
                        <img src='{{asset('/assets/img/kopek/cosmetics.png')}}' alt="Your Logo">
                    </a>
                    <p>
                        {{ Fungsi::app_nama() }}
                    </p>
                </div>
            </div>
        </div>
        <div id="credit">
            <p>
                Demo : user = admin // pass = admin
                <br>
                Demo : member = (gunakan username seeder) // passdefault = 123
            </p>
        </div>
    </div>
</body>

</html>
