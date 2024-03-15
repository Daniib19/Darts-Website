<html>

<head>
  <meta charset="utf-8">

  <title>Darts Smecher</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL::asset('css_files/style4.css') }}">
  <script src="https://kit.fontawesome.com/dd48fb86da.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
  <script type="text/javascript">
    let players_count = {{ count($players) }};
    let game_points = {{ $game_type }};
    var bos = {{ $best_of_sets }};
    var bol = {{ $best_of_legs }};
    var first_to_sets = parseInt( bos / 2 ) + 1;
    var first_to_legs = parseInt( bol / 2 ) + 1;
    var player_ids = [];
    var player_colors = [];

    var isBot = false;
    var bot_turn = 0;

    let match_started;

    date = new Date();
    let hours = date.getHours();
    let mins = date.getMinutes();
    let secs = date.getSeconds();
    if (hours < 10) {
      hours = '0' + hours;
    }
    if (mins < 10) {
      mins = '0' + mins;
    }
    if (secs < 10) {
      secs = '0' + secs;
    }
    match_started = hours+':'+mins+':'+secs;
    
    if ({{ count($players) }} > 4)
      document.body.style.zoom = "90%"
  </script>
  <?php
    $i = 0;
  ?>
  <nav class="navbar navbar-dark bg-dark" style="margin-bottom: 0px!important; background-color: white!important">
    <a href="/"><h1 class="brand-name">Darts (Best of {{ $best_of_sets }} sets)</h1></a>
  </nav>
  <br>
  <div class="container" style="max-width: 97%!important">
    <div class="card-deck" style="justify-content: center;">
      @foreach ($players as $player)
      <script>
        player_ids.push({{ $player->id }});
        player_colors.push({!! json_encode($player->fav_color) !!});
      </script>
      <div class="card" style="max-width: 75%; border: 0">
        <div class="card-body" style="text-align: center; padding: 0px;">
          <div style="padding: 20px 0px 20px; border-bottom: 0.5px solid #cccccc;" id="player_{{ $i }}_header">
            <h1 class="card-title" style="font-size: 50px"><span id="player_{{ $i }}_name" style="font-weight: bold">{{ $player->name }}</span></h1>
          </div>
          <div style="padding: 20px">
            <div class="points-div">
              <a class="points-text" id="player_{{ $i }}_points">{{ $game_type }}</a>
            </div>
            <div class="player-scores" style="padding-bottom: 20px; border-bottom: 0.5px solid #cccccc;">
              <a style="padding-right: 10px; font-size: 25px" >Sets: <span id="player_{{ $i }}_sets">0</span></a>
              <a style="font-size: 25px">Legs: <span id="player_{{ $i }}_legs">0</span></a>
            </div>

            <div class="row" style="padding-top: 20px;">
              <div class="col" style="font-size: 20px; display: inline; text-align: left">
                <div style="padding-bottom: 2px"><strong>Leg Avg </strong><span id="player_{{ $i }}_leg-avg">0.00</span></div>
                <div style="padding-bottom: 2px"><strong>Match Avg </strong><span id="player_{{ $i }}_match-avg">0.00</span></div>
                <div style="padding-bottom: 2px"><strong>9-Dart Avg </strong><span id="player_{{ $i }}_9dart-avg">0.00</span></div>
              </div>

              <div class="col" style="font-size: 20px; display: inline; text-align: center">
                <div style="padding-bottom: 2px"><strong>26 </strong><span id="player_{{ $i }}_26s">0</span></div>
                <div style="padding-bottom: 2px"><strong>100+ </strong><span id="player_{{ $i }}_100s">0</span></div>
                <div style="padding-bottom: 2px"><strong>180 </strong><span id="player_{{ $i }}_180s">0</span></div>
              </div>

              <div class="col" style="font-size: 20px; display: inline; text-align: right">
                <div style="padding-bottom: 2px"><strong>Latest </strong><span id="player_{{ $i }}_latest">0</span></div>
                <div style="padding-bottom: 2px"><strong>Highest </strong><span id="player_{{ $i }}_highest">0</span></div>
                <div style="padding-bottom: 2px"><strong>Highest Finish </strong><span id="player_{{ $i }}_highest-finish">0</span></div>
              </div>

            </div>

          </div>
        </div>
      </div>
      <?php $i++ ?>
      @endforeach
    </div>

    <br>
    <div style="text-align: center">
      <input id="points" type="text" class="shot-button" autocomplete="off">
    </div>
    <div style="text-align: center; padding-top: 15px">
      <button onclick="addPoints()" class="nice-button red"><i class="fas fa-angle-double-right fa-lg"></i></i></button>
      <button class="nice-button blue" style="margin-left: 20px"><i class="fas fa-undo fa-lg"></i></button>
    </div>

    <div style="text-align: center; padding-top: 50px; display: none" id="savestats">
      <a id="savestats-btn" class="btn btn-dark" style="color: white; font-size: 30px; font-weight: bold">Save Match</a>
    </div>
  
  </div>
  @foreach ($players as $player)
    @if ($player->name == 'BOT Test')
      <script> isBot = true; bot_turn = 1;</script>
    @endif
  @endforeach

  <script src="{{ URL::asset('js_files/ntc.js') }}"></script>
  <script src="{{ URL::asset('js_files/bots/bot_3.js') }}"></script>
  <script src="{{ URL::asset('js_files/generateScore.js') }}"></script>
  <script src="{{ URL::asset('js_files/playmatch.js') }}"></script>
</body>