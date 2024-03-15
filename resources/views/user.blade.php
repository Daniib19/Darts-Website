@extends('test')

@section('content')
<br>
<div class="container" style="max-width: 80%!important">
<script>
  let avgs = [];
</script>

@foreach ($d as $i)
  <script>
    avgs.push ({{$i}});
  </script>
@endforeach

<h1>{{$player->name}} <a href="/edit_player/{{$player->id}}" class="btn btn-warning" style="margin-left: 40px">Edit Player</a>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  Delete Player
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <a href="/delete/{{$player->id}}" class="btn btn-danger">Yes</a>
      </div>
    </div>
  </div>
</div>
</h1>

<div class="card mg40">
<div class="card-body">
  <div class="row" style="align-items: center">
    <div class="col-8">
      <div style="width: 100%">
        <div class="flex">
          <div class="item-flex">Name : </div>
          <div class="item-flex right">{{$player->name}}</div>
        </div>
      </div>
      <div style="width: 100%; margin-top: 40px">
        <div class="flex">
          <div class="item-flex">Nationality : </div>
          <div class="item-flex right">Romania</div>
        </div>
      </div>
      <div style="width: 100%; margin-top: 40px">
        <div class="flex">
          <div class="item-flex">Matches Played : </div>
          <div class="item-flex right">{{$matches_played}}</div>
        </div>
      </div>
      <div style="width: 100%; margin-top: 40px">
        <div class="flex">
          <div class="item-flex">Legs Played : </div>
          <div class="item-flex right">{{$darts_thrown}}</div>
        </div>
      </div>
      <div style="width: 100%; margin-top: 40px">
        <div class="flex">
          <div class="item-flex">Throwing Games Since : </div>
          <div class="item-flex right">15.05.2021</div>
        </div>
      </div>
    </div>
    <div class="col-4" style="text-align: center">
      <img class="stats-card-image big"
      src="https://imgresizer.eurosport.com/unsafe/1200x0/filters:format(jpeg):focal(1396x273:1398x271)/origin-imgresizer.eurosport.com/2021/04/09/3026174-62079208-2560-1440.jpg">
      <div style="width: 100%; height: 25px; background: {{$player->fav_color}}">zeu pe aruncat</div>
    </div>
  </div>
</div>
</div>

<br>
<h1 style="margin-top: 20px">Statistics</h1>

<div class="card mg40">
  <div class="card-body flex">
    <div class="col-6" style="display: flex; flex-direction: column; height: 100%">
      <div class="item-flex">
        <canvas id="winrateChart" height="200" width="200"></canvas>
      </div>
      <div class="item-flex pd10" style="text-align: center"><strong>Win Rate - {{$winrate}}%</strong></div>
    </div>
    <div class="col-6 flex colm">
      <strong class="item-flex pd10">Favourite Gamemode : <span>{{$player->fav_gt}} ({{$player->fav_gt_length}} matches)</span></strong>
      <strong class="item-flex pd10">Most Played Gametype : <span>{{$player->fav_points}} ({{$player->fav_points_length}} matches)</span></strong>
      <strong class="item-flex pd10">Best Match Performance : <span>{{$best->match_avg}} avg</span></strong>
      <strong class="item-flex pd10">Form : <span>
      @foreach ($form as $f)
        {{$f}}
      @endforeach
      </span></strong>
    </div>
  </div>
</div>

<div class="card mg40">
  <div class="card-body">
    <canvas id="avgbyDay" height="200" width="200"></canvas>
  </div>
</div>

<div class="card mg40">
  <div class="card-body" style="text-align: center">
    <div class="row">
      <div class="col flex colm" style="font-size: 19px">
        <h3 style="margin-bottom: 12px"><strong>3 Dart Average</strong></h3>
        <strong style="margin-bottom: 7px">Highest : <span>{{max($d)}}</span></strong>
        <strong style="margin-bottom: 7px">Lowest : <span>{{min($d)}}</span></strong>
        <strong style="margin-bottom: 7px">Total : <span>{{number_format((float)array_sum($d)/count($d), 2, '.', '')}}</span></strong>
      </div>
      <div class="col flex colm" style="font-size: 19px">
        <h3 style="margin-bottom: 12px"><strong>First 9 Average</strong></h3>
        <strong style="margin-bottom: 7px">Highest : <span>0.00</span></strong>
        <strong style="margin-bottom: 7px">Lowest : <span>0.00</span></strong>
        <strong style="margin-bottom: 7px">Total : <span>0.00</span></strong>
      </div>
    </div>
  </div>
</div>

<div class="card mg40">
  <div class="card-body" style="text-align: center">
    <div class="col flex colm">
      <h2 style="margin-bottom: 12px"><strong>Scoring</strong></h2>
      <strong style="margin-bottom: 7px">26s : <span>{{$player->t_26s}}</span></strong>
      <strong style="margin-bottom: 7px">100s : <span>{{$player->t_100s}}</span></strong>
      <strong style="margin-bottom: 7px">180s : <span>{{$player->t_180s}}</span></strong>
      <strong style="margin-bottom: 7px">Highest : <span>{{$player->highest}}</span></strong>
      <strong style="margin-bottom: 7px">Highest Finish : <span>{{$player->highest_finish}}</span></strong>
    </div>
  </div>
</div>

<div style="height: 70px"></div>

<script>
  const data_winrate = {
    labels: [
      'Wins',
      'Loses'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [{{$wins}}, {{$matches_played - $wins}}],
    backgroundColor: [
      "{{$player->fav_color}}",
      '#D6DAD8'
    ],
    hoverOffset: 4
  }]};

  const config_winrate = {
    type: 'doughnut',
    data: data_winrate,
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
  };

  var winrateChart = new Chart(
    document.getElementById('winrateChart'),
    config_winrate
  );
  //

  const data_avg = {

  labels: avgs,
  datasets: [{
    label: '3 Dart Average',
    type: 'line',
    data: {!! json_encode($d) !!},
    backgroundColor: "{{$player->fav_color}}",
    borderColor: "{{$player->fav_color}}", 
    hoverOffset: 4
  }]};

  const config_avg = {
    type: 'line',
    data: data_avg,
    options: {
      responsive: true,
      maintainAspectRatio: false,

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

  var avg = new Chart(
    document.getElementById('avgbyDay'),
    config_avg
  );

</script>

@endsection