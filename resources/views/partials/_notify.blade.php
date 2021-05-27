@if ($message = Session::get('success'))
    <script !src="">
        alertify.success(`{{ $message }}`);
    </script>
@endif
@if ($message = Session::get('error'))
    <script !src="">
        alertify.error(`{{ $message }}`);
    </script>
@endif
@if ($message = Session::get('status'))
    <script !src="">
        alertify.success(`{{ $message }}`);
    </script>
@endif
@if ($message = Session::get('danger'))
    <script !src="">
        alertify.error(`{{ $message }}`);
    </script>
@endif
@if ($message = Session::get('warning'))
    <script !src="">
        alertify.warning(`{{ $message }}`);
    </script>
@endif
@if ($message = Session::get('info'))
    <script !src="">
        alertify.message(`{{ $message }}`);
    </script>
@endif
@if ($errors->any())
    @foreach($errors->all() as $error)
        <script !src="">
            alertify.error(`{{ $error }}`);
        </script>
    @endforeach
@endif
