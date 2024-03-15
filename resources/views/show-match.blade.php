@extends('test')

@section('content')
<script>
  var legs_count = {{ count($legs_avgs[0])  }};
  var players_count = {{ count($players)  }};
  var player_names = [];
  var legs_avgs_js = [];
  var player_colors = [];
</script> 

<div class="container" style="max-width: 95%!important">
  <h1>Match Stats</h1>
  <h5 style="margin-top: 20px">{{$match->game_type}} ({{$match->points}})</h5>
  <h5 style="margin-bottom: 20px">{{date("d-m-Y", strtotime($match->match_ended))}}</h5>
  <div class="cardstats-list">
    @foreach ($players as $player)
    <div class="stats-card" id="stats-card">
      <div class="card">
        <div class="card-body">
          <div class="stats-card-image-div">
            <img class="stats-card-image"
            src="https://imgresizer.eurosport.com/unsafe/1200x0/filters:format(jpeg):focal(1396x273:1398x271)/origin-imgresizer.eurosport.com/2021/04/09/3026174-62079208-2560-1440.jpg">
          </div>
          <h2 class="card-title" style="font-weight: bold">{{ $player->name  }}</h2>
          <hr>
          <div class="stats-card-info">
            <span style="padding-bottom: 10px" class="stats-text bold">Match Avg <span class="stats-text">{{ $player->match_avg  }}</span></span>
            <span style="padding-bottom: 10px" class="stats-text bold">First9 Avg <span class="stats-text">{{ $player->nineDart_avg  }}</span></span>
            <span style="padding-bottom: 10px" class="stats-text bold">26s <span class="stats-text">{{ $player->total_26s  }}</span></span>
            <span style="padding-bottom: 10px" class="stats-text bold">100s <span class="stats-text">{{ $player->total_100s  }}</span></span>
            <span style="padding-bottom: 10px" class="stats-text bold">180s <span class="stats-text">{{ $player->total_180s  }}</span></span>
            <span style="padding-bottom: 10px" class="stats-text bold">Highest <span class="stats-text">{{ $player->highest  }}</span></span>
            <span style="padding-bottom: 15px" class="stats-text bold">Highest Finish <span class="stats-text">{{ $player->highest_finish  }}</span></span>
            <span style="padding-bottom: 1px" class="stats-text bold">Sets Won - Legs Won</span>
            <span style="padding-bottom: 10px" class="stats-text bold">{{ $player->sets_won  }} <span style="margin-left: 20px" class="stats-text bold">{{ $player->legs_won  }}</span></span>

            @if ($player->player_id == $match->winner_id)
              <div class="stats-card-pill">
                <span class="badge badge-pill badge-success winner" style="width: 15%">Winner</span>
              </div>
            @else
              <div class="stats-card-pill">
                <span class="badge badge-pill badge-success loser" style="width: 15%">Loser</span>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
    <script>
      player_names.push({!! json_encode($player->name) !!});
      player_colors.push({!! json_encode($player->fav_color) !!});
    </script>
    @endforeach

    @if (count($players) > 2)
      <script>
        var x = document.getElementsByClassName('stats-card');
        for (var i = 0; i < x.length; i++)
          x[i].style.maxWidth = '25%';  
      </script>
    @endif
    @foreach ($legs_avgs as $leg_avg)
      <script>
        legs_avgs_js.push({!! json_encode($leg_avg) !!});
      </script>
    @endforeach
  </div>

  <script src="{{ URL::asset('js_files/chart.js') }}"></script>

  <div class="card" style="margin-top: 60px">
    <div class="card-body">
      <h1 style="margin-bottom: 15px">Legs Averages</h1>
      <div>
        <canvas id="myChart" height="51"></canvas>
      </div>
      <script>
        const labels = getLabels();

        const data = {
          labels: labels,
        };
        
        const config = {
          type: 'line',
          data,
          options: {
                responsive: true,
                plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 20
                        }
                    }
                },
                title: {
                    display: false,
                }
                }
            },
        };
        
        var myChart = new Chart(
          document.getElementById('myChart'),
          config
        );

        for (var i = 0; i < players_count; i++) {
          addDataset(myChart, i); 
        }
      </script>
      <?php $i = 0 ?>
      <div class="cardstats-list" style="margin-top: 50px">
        @foreach ($legs_avgs as $leg_avg)
        <div class="stats-card">
          <div class="card" style="border: none">
            <div class="card-body">
              <h3 class="card-title" style="font-weight: bold">{{$players[$i]->name}}</h3>
              <h4>Best Leg <span class="highest">{{ max($leg_avg) }}</span></h4>
              <h4>Worst Leg <span class="lowest">{{ min($leg_avg) }}</span></h4>
              <h4>Total <span>{{number_format((float)array_sum($leg_avg)/count($leg_avg), 2, '.', '')}}</span></h4>
            </div>
          </div>
        </div>
        <?php $i++ ?>
        @endforeach
      </div>
    </div>
  </div>

  <div class="footer"></div>
</div>
@endsection