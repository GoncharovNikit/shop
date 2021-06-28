<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin panel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        form {
            background-color: silver;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 800;
            font-size: 20px;
        }

        form button {
            background-color: whitesmoke;
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

    <form action="/admin" method="POST" style="width: 60%; margin: 40px; border: 2px solid black; padding: 20px; border-radius: 20px; display:flex; flex-direction:column; justify-content:space-around; height: 1400px;">
        <div class="mb-3">
            <label for="vendorCodeInput" class="form-label">Артикул</label>
            <input name="vendorCode" type="text" class="form-control" id="vendorCodeInput" autocomplete="off" value="{{ old('vendorCode') }}">
        </div>
        <div class="mb-3">
            <label for="priceInput" class="form-label">Цена</label>
            <input name="price" type="number" min="1" max="10000" step="0.01" class="form-control" id="priceInput" value="{{ old('price') }}">
        </div>
        <label for="descriptionInput">Описание</label>
        <div class="form-floating">
            <textarea name="description" class="form-control" placeholder="Description" id="descriptionInput" style="height: 100px" value="{{ old('description') }}"></textarea>
        </div>
        <label for="selectMetal">Метал</label>
        <select name="metal" class="form-select" id="selectMetal" value="{{ old('metal') }}">
            @foreach($metals as $metal)
            <option value="{{$metal->id}}">{{$metal->name}}</option>
            @endforeach
        </select>
        <label for="selectColor">Цвет камня</label>
        <select name="color" class="form-select" id="selectColor" value="{{ old('color') }}">
            @foreach($colors as $color)
            <option value="{{$color->id}}">{{$color->name}}</option>
            @endforeach
            <option value="null">Без камня</option>
        </select>
        <label for="selectCategory">Категория</label>
        <select name="category" class="form-select" id="selectCategory" value="{{ old('category') }}">
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name_rus}}</option>
            @endforeach
        </select>
        <label for="selectSize">Размер</label>
        <div name="size" id="selectSize" style="display:flex; flex-direction:column; flex-wrap:wrap; justify-content:space-around; height: 300px;">
            @foreach($sizes as $size)
            <div><input name="size[{{$size->id}}]" class="sizeCheck" type="checkbox" checked style="width:20px; height:20px;" value="{{$size->id}}">&nbsp;&nbsp;{{$size->size}}</div> <br>
            @endforeach
        </div>
        {{ csrf_field() }}

        <button type="submit" class="btn btn-success">Создать</button>
    </form>
    
    <h1>Таблица товаров:</h1>

    <table class="table table-striped table-hover" style="border: 2px solid black;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Артикул</th>
                <th scope="col">Цена</th>
                <th scope="col">Описание</th>
                <th scope="col">Метал</th>
                <th scope="col">Цвет камня</th>
                <th scope="col">Категория</th>
                <th scope="col">Дата создания</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            @foreach($products as $product)
            <tr>
                <th scope="row">{{$counter}}</th>
                <td>{{$product->vendorCode}}</td>
                <td>{{$product->price}}</td>
                <td>{{mb_substr($product->description, 0, 32).'...'}}</td>
                <td>{{$product->metals->name}}</td>
                <td>{{$product->stone_colors->name}}</td>
                <td>{{$product->categories->name}}</td>
                <td>{{$product->created_at}}</td>
                <td><a href="{{ route('admin.edit', ['id' => $product->vendorCode]) }}">Изменить</a></td>
                <td><a href="{{route('admin.delete', ['id' => $product->vendorCode])}}">Удалить</a></td>
            </tr>
            <?php $counter += 1; ?>
            @endforeach
        </tbody>
    </table>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        window.jQuery || document.write("<script src='{{asset('js/jquery-1.11.1.min.js')}}'>\x3C/script>")
    </script>
    <script>
        
        
  // ADDING CONF
  $("#selectCategory").on("change", function(){
    if(!($("#selectCategory").val() == "1" || $("#selectCategory").val() == "7")){
      $(".sizeCheck").attr("disabled", true);
    }
    else $(".sizeCheck").attr("disabled", false);
  });

  
    </script>
</body>

</html>