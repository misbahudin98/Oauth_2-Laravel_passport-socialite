<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1> heeloo</h1>
    <button id="logout">logout</button>
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="http://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="http://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="http://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <script src="1_cookie.js"></script>
    <script src="2_oauth.js"></script>
    <script src="3_error.js"></script>
    <script>
        tokenObj = token();
        var refreshToken = getRefreshToken();
        console.log(refreshToken)
        if (tokenObj) {
            $.ajax({
                type: "user",
                url: DOMAIN_API + "api/user",
                type: "get",
                headers: {
                    "Authorization": "Bearer " + tokenObj.access_token,
                    "Accept": "application/json"
                },
                success: function(response) {
                    console.log(response);

                    $("h1").html(tokenObj.access_token)
                },

            });

        } else {

            window.location.href = DOMAIN_API + "auth/redirect";
        }

        ///////////////////////////////        
        $("#logout").click(function(e) {
            e.preventDefault()
            logout()
        })
    </script>
</body>

</html>