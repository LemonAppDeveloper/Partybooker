<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Implement Social Share Button in Laravel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        div#social-links {
            margin: 0 auto;
            max-width: 500px;
        }

        div#social-links ul li {
            display: inline-block;
        }

        div#social-links ul li a {
            padding: 10px;
            border: 1px solid #ccc;
            margin: 1px;
            font-size: 30px;
            color: #222;
            background-color: #ccc;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-5 text-center d-none">Laravel Social Share Buttons Example</h2>
        <div class="col-12 text-center social-share">
            {!! $shareComponent !!}
        </div>
    </div>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.social-share a').forEach(function(anchor) {
        anchor.setAttribute('target', '_blank');
    });
});

    // Adding target="_blank" to all social share links
    document.querySelectorAll('.social-share a').forEach(function(anchor) {
        anchor.setAttribute('target', '_blank');
    });
</script>