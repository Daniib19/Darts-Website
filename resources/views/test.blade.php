<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Darts Smecher</title>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL::asset('css_files/style4.css') }}">
  <script src="https://kit.fontawesome.com/dd48fb86da.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"></script>

</head>

<body>
  <nav class="navbar navbar-dark bg-dark" style="margin-bottom: 0px!important; background-color: white!important">
    <a href="/"><h1 class="brand-name">Darts</h1></a>
  </nav>

  <div class="wrapper">
    <nav id="sidebar">
      <div class="sidebar-header">
        <div class="profile-section">
          <div class="profile-image-div">
            <img class='profile-image' src="https://imgresizer.eurosport.com/unsafe/1200x0/filters:format(jpeg):focal(1396x273:1398x271)/origin-imgresizer.eurosport.com/2021/04/09/3026174-62079208-2560-1440.jpg">
          </div>
          <div class="profile-info">
            <span>Daniib</span>
          </div>
        </div>
      </div>

      <ul class="list-unstyled components">
        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <i class="far fa-circle"></i>
              Play
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
              <li>
                <a href="/prepare-match/x01"><i class="fas fa-play"></i>Classic</a>
              </li>
              <li>
                <a href="/prepare-match/x01"><i class="fas fa-user-friends"></i>Teams</a>
              </li>
              <li>
                <a href="/prepare-match/x01"><i class="fas fa-robot"></i>Versus Bot</a>
              </li>
            </ul>
        </li>
      <li>
        <a href="#">
          <i class="far fa-circle"></i>
          Statistics
        </a>
      </li>
      <li>
        <a href="/users">
          <i class="far fa-circle"></i>
          Players
        </a>
      </li>
      <li>
        <a href="/history">
          <i class="far fa-circle"></i>
          Match History
        </a>
      </li>
      </ul>

    </nav>

    <div id="content">
      @yield('content')
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script type="text/javascript">
      $(document).ready(function () {
          $('#sidebarCollapse').on('click', function () {
              $('#sidebar').toggleClass('active');
          });
      });
  </script>
</body>

</html>

