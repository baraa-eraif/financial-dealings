<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>api Dashboard </title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
{{--  @include('core::common.favicon')--}}

  {{--Laravel Mix - CSS File--}}
  <link rel="stylesheet" href="{{ url('css/seller/app.css') }}">
</head>

<body>
<script>
  let direction = localStorage.getItem('seller_locale') === "ar" ? 'rtl' : 'ltr';
  document.querySelector('html').setAttribute("dir", direction);
  document.querySelector('body').setAttribute("dir", direction);
</script>


{{--</script>--}}
@yield('content')

{{--Laravel Mix - JS File--}}
<script src="{{ url('js/seller/app.js') }}"></script>
</body>

</html>
