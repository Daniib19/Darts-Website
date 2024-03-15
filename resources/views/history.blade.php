@extends('test')

@section('content')
  <br>
  <div class="container" style="max-width: 95%!important">
    <script>
      function matchDuration(ended, started) {
        let date = new Date();

        let year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();
        if (month < 10) {
          month = '0' + month;
        }
        if (day < 10) {
          day = '0' + day;
        }
        let today = year + '-' + month + '-' + day + ' ';
        let q = ended.split(' ')[0];

        let date_future = new Date(ended);
        let date_now  = new Date(q + ' ' + started);

        var delta = Math.abs(date_future - date_now) / 1000;

        var days = Math.floor(delta / 86400);
        delta -= days * 86400;

        var hours = Math.floor(delta / 3600) % 24;
        delta -= hours * 3600;

        var minutes = Math.floor(delta / 60) % 60;
        delta -= minutes * 60;

        var seconds = delta % 60;
        
        if (hours > 0)
          return  (hours + ' hours, ' + minutes + ' minutes, ' + seconds + ' seconds');
        else
         return (minutes + ' minutes, ' + seconds + ' seconds');
      }
    </script>
    <h1>Match History</h1>
    <br>
    <div class="matches-list">
      <?php $i = 0 ?>
      @foreach ($matches as $match)
      <a href="show-match/{{$match->id}}" style="width: 75%">
        <div class="card k" style="margin-bottom: 20px; background: white">
          <div class="card-body">
            <div class="container-fluid" style="padding: 0px">
              <div class="row" style="align-items: center;">
                <div class="col">
                  <h3 class="card-title">{{ $match->points }} ( {{ $match->game_type }}, best of {{$match->best_of_sets}} sets )<span class="match-date-text">{{ $match->match_ended  }}</span> </h3>
                  <p class="card-text"><span>Winner: {{ $winners[$i]->name }}</span><span style="margin-left: 25px">
                  <script>
                    document.write('Match Duration : ' + matchDuration({!! json_encode($match->match_ended) !!}, {!! json_encode($match->match_started) !!} ));
                  </script>
                  </span></p>
                </div>
                <div class="col">
                  <a href="/delete-match/{{$match->id}}" style="float: right;"><button class="btn btn-outline-danger" style="border-width: 2px">Delete</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
      <?php $i++ ?>
      @endforeach
    </div>
  </div>
@endsection