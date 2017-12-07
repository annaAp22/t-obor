@if (count($errors) > 0)
    <div class="alert alert-danger" style="background-color: #f2dede;border-color: #ebccd1; color: #a94442;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif