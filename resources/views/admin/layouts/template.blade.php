<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменение данных товара</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        .main-form {
            background-color: silver;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 800;
            font-size: 20px;
            width: 60%;
            margin: 40px;
            border: 2px solid black;
            padding: 20px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            height: auto;
        }

        form button {
            background-color: whitesmoke;
        }

        #selectSize {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            justify-content: space-around;
            height: 300px;
        }

        .sizeCheck {
            width: 20px;
            height: 20px;
        }

        @media(max-width: 780px) {
            .main-form {
                width: 90%;
            }
        }

        @media(max-width: 550px) {
            #selectSize {
                height: 400px;
            }
        }


        .product-images {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            margin: 20px;
            border-top: 4px dashed darkslategray;
            border-bottom: 4px dashed darkslategray;
        }

        #images-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .product-images img {
            height: 400px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .img-add {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 8px;
        }

        .img-add label {
            cursor: pointer;
            padding: 4px 12px;
            font-weight: normal;
        }

        .img-add button {
            padding: 5px 12px;
            margin-left: 30px;
            background: none;
        }

        .img-add button,
        .img-add label {
            border: 2px solid black;
            width: 260px;
            text-align: center;
            margin-top: 10px;
        }

        .img-add button:hover,
        .img-add label:hover {
            background: darkslategrey;
            color: whitesmoke;
            transition: 100ms;
        }

        #images {
            opacity: 0;
            position: absolute;
            z-index: -10;
        }

        .prod-img-item {
            position: relative;
        }

        .btn-del-img {
            position: absolute;
            top: 50%;
            background: none;
            border: none;
            width: 70px;
            height: 70px;
            right: -100px;
        }

        .btn-del-img img {
            width: 70px;
            height: 70px;
        }

        .btn-del-img:focus {
            outline: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(() => {
            if (!($("#selectCategory option:selected").text() == "Кольца" || $("#selectCategory option:selected").text() == "Браслеты"))
                $(".sizeCheck").attr("disabled", true)
            else $(".sizeCheck").attr("disabled", false)

            // ADDING CONF
            $("#selectCategory").on("change", function() {
                if (!($("#selectCategory option:selected").text() == "Кольца" || $("#selectCategory option:selected").text() == "Браслеты"))
                    $(".sizeCheck").attr("disabled", true)
                else $(".sizeCheck").attr("disabled", false)
            });

            $('#images-wrapper').sortable()

        })
    </script>
</head>

<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @yield('content')
</body>

</html>