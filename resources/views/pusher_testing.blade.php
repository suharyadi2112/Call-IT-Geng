<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>


    var pusher = new Pusher('9ede8272955f9628c5d9', {
      cluster: 'ap1',
      encrypted: true
    });
    
    // matikan di prod
    Pusher.logToConsole = true;

    var channel = pusher.subscribe('callit-geng');
    channel.bind('callit-geng-event', function(data) {
      console.log(data.message);
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    testing pusher untuk notif Laporan Pengaduan baru
  </p>
</body>