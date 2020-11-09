@if($errors->any())
    <div class = "Huialert Huialert-error"> <i class = "Hui-iconfont"> x </i>
        @foreach($errors -> all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif