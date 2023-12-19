<html lang="en">
<body>
    @if($image == null)
        <h1>No image found...!</h1>
    @else
        <img src="{{ $image }}" alt="webpage-preview-image">
    @endif
</body>
</html>
