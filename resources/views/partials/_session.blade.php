@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>

@endif

@if (session('warning'))

    <script>
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: "<div><h4 style='color:black;'>Warning!!</h4><br>{{ session('warning') }}</div>",
        }).show();
    </script>

@endif
@if (session('error'))

    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "Warning!!<br>{{ session('error') }}<br>",
        }).show();
    </script>

@endif
