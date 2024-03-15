@extends('test')

@section('content')
<br>
<div class="container" style="max-width: 95%!important">
  <script src="{{ URL::asset('js_files/ntc.js') }}"></script>
  <script>
    let color;
  </script>
  <h1>Players</h1>
  <table class="table" style="margin-top: 18px">
    <thead class="thead-dark">
      <tr>
        <th scope="col"></th>
        <th scope="col">Player Name</th>
        <th scope="col">Matches Played</th>
        <th scope="col">Wins / Lost</th>
        <th scope="col">Color</th>
      </tr>
    </thead>
    <tbody>
      <?php $count = 1 ?>
      @foreach ($players as $player)
      <tr>
        <th scope="row">{{$count}}</th>
        <td><a href="/user/{{$player->id}}">{{$player->name}}</a></td>
        <td>{{$player->m_played}}</td>
        <td>{{$player->wins}} / {{$player->m_played - $player->wins}}</td>
        <td style="background: {{$player->fav_color}}; width: 200px" id="player_{{$count}}">
          @if ($player->fav_color)
            <script>
              var n_match = ntc.name({!! json_encode($player->fav_color) !!});
              n_rgb = n_match[0]; // RGB value of closest match
              n_name = n_match[1]; // Text string: Color name
              n_exactmatch = n_match[2]; // True if exact color match
              document.write(n_match[1]);

              color = hexToRgb({!! json_encode($player->fav_color) !!});

              if (getTextColor(color))
                document.getElementById('player_' + {{$count}}).style.color = 'black';
              else
                document.getElementById('player_' + {{$count}}).style.color = 'white';

              color = null;
            </script>
          @else
              Not Set
          @endif
        </td>
      </tr>
      <?php $count ++?>
      @endforeach
    </tbody>
  </table>
  <a href="/add_user"><button style="margin-top: 20px;" type="button" class="btn btn-success">Add Player</button></a>
</div>
@endsection