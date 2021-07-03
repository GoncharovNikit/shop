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
            height: <?= ($product->categories->id == 1 || $product->categories->id == 7) ? '1400px' : '800px'; ?>;
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
    </style>
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

    <form class="main-form" action="{{ route('admin.save') }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="text" value="{{ $product->vendorCode }}" name="old-vendor-code" hidden>
        <div class="mb-3">
            <label for="vendorCodeInput" class="form-label">Артикул</label>
            <input name="vendorCode" type="text" class="form-control" id="vendorCodeInput" autocomplete="off" value="{{ old('vendorCode') ?? $product->vendorCode }}">
        </div>
        <div class="mb-3">
            <label for="priceInput" class="form-label">Цена</label>
            <input name="price" type="number" min="1" max="10000" step="0.01" class="form-control" id="priceInput" value="{{ old('price') ?? $product->price }}">
        </div>
        <div>
            <label for="descriptionInput">Описание</label>
            <div class="form-floating">
                <textarea name="description" class="form-control" placeholder="Description" id="descriptionInput" style="height: 100px">{{ old('description') ?? $product->description }}</textarea>
            </div>
        </div>
        <div>
            <label for="selectMetal">Метал</label>
            <select name="metal" class="form-select" id="selectMetal">
                @foreach($metals as $metal)
                <option value="{{$metal->id}}" <?= $product->metals->id == $metal->id ? 'selected' : '' ?>>{{$metal->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="selectColor">Цвет камня</label>
            <select name="color" class="form-select" id="selectColor">
                @foreach($colors as $color)
                <option value="{{$color->id}}" <?= $product->stone_colors->id == $color->id ? 'selected' : '' ?>>{{$color->name}}</option>
                @endforeach
                <option value="null">Без камня</option>
            </select>
        </div>
        <div>
            <label for="selectCategory">Категория</label>
            <select name="category" class="form-select" id="selectCategory">
                @foreach($categories as $category)
                <option value="{{$category->id}}" <?= $product->categories->id == $category->id ? 'selected' : '' ?>>{{$category->name_rus}}</option>
                @endforeach
            </select>
        </div>
        @if ($product->categories->id == 1 || $product->categories->id == 7)
        <div>
            <label for="selectSize">Размер</label>
            <br><br>
            <div name="size" id="selectSize">
                @foreach($sizes as $size)
                <div>
                    <input id="cb_size_{{ $size->id }}" name="size[{{$size->id}}]" class="sizeCheck" type="checkbox" <?= in_array($size->size, array_column($product->sizes->toArray(), 'size')) ? 'checked' : ''; ?> value="{{$size->id}}">

                    <label for="cb_size_{{ $size->id }}">&nbsp;&nbsp;{{$size->size}}</label>
                </div>
                <br>
                @endforeach
            </div>
        </div>
        @endif
        <div>


        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>


</body>

</html>