<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
        <style>
            html, body, section {
                font-family: 'Montserrat', sans-serif;
            }

            a:link{
              text-decoration: none;
            }

            /* for mobile view in genea ID */
            .phonesize{
              font-size: 7px;
            }
              /* For V-Cloak */
            /* [v-cloak] > * { display: none; }
            [v-cloak]::before {
              content: '';
              position: absolute;
              left: 50%;
              top: 50%;
              z-index: 1;
              width: 150px;
              height: 150px;
              margin: -75px 0 0 -75px;
              margin-top: 250px;
              border: 16px solid #4DB6AC;
              border-radius: 50%;
              border-top: 16px solid #f0e10e;
              width: 120px;
              height: 120px;
              -webkit-animation: spin 2s linear infinite;
              animation: spin 2s linear infinite;
            }
            @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            } */
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
