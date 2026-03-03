<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>

<h2>Upload Image</h2>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form action="{{ url('/upload-image') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>

<hr>

<h2>Uploaded Images</h2>

@foreach($images as $img)
    <div style="margin-bottom:20px;">
        <img src="{{ $img->image_url }}" width="200">
    </div>
@endforeach

</body>
</html>
