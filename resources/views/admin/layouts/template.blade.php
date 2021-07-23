<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменение данных товара</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        .main-form {
            background-color: whitesmoke;
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

        .menu {
            padding: 5px;
            width: 100%;
            height: 60px;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }
        .simple-link {
            text-decoration: none;
            padding: 7px 15px;
            border: 1px solid black;
            background: black;
            color: white;
            font-size: 14pt;
            white-space: nowrap;
        }
        .simple-link:hover {
            color: whitesmoke;
            background: gray;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
        }
        td, th {
            text-align: center;
            vertical-align: middle;
        }

    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(() => {
            if ((!($("#selectCategory option:selected").text() == "Кольца" || $("#selectCategory option:selected").text() == "Браслеты")) && $('#is-sale').val() != 'on')
                $(".sizeCheck").attr("disabled", true)
            else $(".sizeCheck").attr("disabled", false)

            // ADDING CONF
            $("#selectCategory").on("change", function() {
                if (!($("#selectCategory option:selected").text() == "Кольца" || $("#selectCategory option:selected").text() == "Браслеты"))
                    $(".sizeCheck").attr("disabled", true)
                else $(".sizeCheck").attr("disabled", false)
            });

            $('#images-wrapper').sortable()

            $('.size-sale-btn.check-all').on('click', () => {
                $('.sizeCheck').prop('checked', true)
            })
            $('.size-sale-btn.decheck-all').on('click', () => {
                $('.sizeCheck').prop('checked', false)
            })
            $('.discount-inp').on('change', (e) => {
                $('.discount-td-handler').text(e.currentTarget.value)
                let price = parseFloat($('.product-price').text())
                let discount = parseFloat(e.currentTarget.value)
                $('.discount-price').text((price - (price * discount / 100)).toFixed(2))
            })
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