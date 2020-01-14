<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <script>
            // transfers sessionStorage from one tab to another
            var sessionStorage_transfer = function(event) {
                if(!event) { event = window.event; } // ie suq
                if(!event.newValue) return;          // do nothing if no value to work with
                if (event.key == 'getSessionStorage') {
                    // another tab asked for the sessionStorage -> send it
                    localStorage.setItem('sessionStorage', JSON.stringify(sessionStorage));
                    // the other tab should now have it, so we're done with it.
                    localStorage.removeItem('sessionStorage'); // <- could do short timeout as well.
                } else if (event.key == 'sessionStorage' && !sessionStorage.length) {
                    // another tab sent data <- get it
                    var data = JSON.parse(event.newValue);
                    for (var key in data) {
                        sessionStorage.setItem(key, data[key]);
                    }
                }
            };

            // listen for changes to localStorage
            if(window.addEventListener) {
                window.addEventListener("storage", sessionStorage_transfer, false);
            } else {
                window.attachEvent("onstorage", sessionStorage_transfer);
            };


            // Ask other tabs for session storage (this is ONLY to trigger event)
            if (!sessionStorage.length) {
                localStorage.setItem('getSessionStorage', 'foobar');
                localStorage.removeItem('getSessionStorage', 'foobar');
            };
        </script>

        <!-- Styles -->
        <style>* { font-family: 'Montserrat'; !important}</style>
        <style>
            html, body, section {
                font-family: 'Montserrat', sans-serif !important;
            }

            a:link{
              text-decoration: none;
            }
        </style>
        <title>Philippine Tech Community</title>
    </head>
    <body >
      <div id="app" v-cloak class="hide-overflow" style="position: relative;">
        <App></App>
      </div>
        <script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
    </body>
</html>
