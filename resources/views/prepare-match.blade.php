@extends('test')

@section('content')
<div class="container" style="width: 50%!important;">
<div style="margin-top: 50px; margin-bottom: 50px"><h1>Match Settings</h1></div>
<script>
  let player_names = [];
  let player_ids = [];
  let lindex = 1;
</script>
<div class="card" style="border-radius: 9px">
  <div class="card-body">
    {{ Form::open() }}
    <div class="row" style="margin-bottom: 28px; align-items: center;">
      <div class="col-sm-4">
        <label class="form-text">Game Type</label>
      </div>
      <div class="col-sm-8" style="text-align: right">
        <select class="form-select" name="game-type">
          <option value="101">101</option>
          <option value="301">301</option>
          <option value="501" selected>501</option>
          <option value="701">701</option>
          <option value="1001">1001</option>
        </select>
      </div>
    </div>
    <div class="row" style="margin-bottom: 28px; align-items: center;">
      <div class="col-sm-4">
        <label class="form-text">Game Mode</label>
      </div>
      <div class="col-sm-8" style="text-align: right">
        <select class="form-select" name="game-mode" id="gamemode-select">
          <option value="standard" selected>Standard</option>
          <option value="teams">Teams</option>
        </select>
      </div>
    </div>

    <div id="standard-players" style="display: block">
      <div class="row" style="margin-bottom: 14px; align-items: center;">
        <div class="col-sm-4">
          <label class="form-text">Players</label>
        </div>
        <div class="col-sm-8" style="text-align: right">
          <button type="button" class="btn btn-success" onclick="addPlayer()">Add Player</button>
        </div>
      </div>
      <div class="row" style="margin-bottom: 28px; align-items: center; width: 100%">
        <div class="col" style="margin-left: 20px">
          <ul class="list-group" id="players-list">
            <li class="list-group-item">
              <select name="players[]" class="form-select" style="border: none; width: 100%">
                
                @foreach ($players as $player)
                <option value="{{ $player->id }}">{{ $player->name }}</option>
                <script>
                  player_names.push( {!! json_encode($player->name) !!} );
                  player_ids.push({{ $player->id }});
                </script>
                @endforeach
              </select>
            </li>

          </ul>
          
        </div>

        <div class="col" style="max-height: auto">
          <ul class="list-group" style="list-style: none" id="player-remove-button-list">
            <li class="list-group-item" style="border: none">
              <button type="button" class="btn btn-outline-dark btn-sm" disabled>x</button>
            </li>

          </ul>
        </div>

      </div>
    </div>

    <div id="teams-players" style="display: none">
      <div class="row" style="margin-bottom: 14px; align-items: center;">
        <div class="col-sm-4">
          <label class="form-text">Teams</label>
        </div>
        <div class="col-sm-8" style="text-align: right">
          <button type="button" class="btn btn-success" onclick="addTeam()">Add Team</button>
        </div>
      </div>
      <div class="row">
        <div class="cardstats-list" id="teams-div">

          <div class="stats-card" id="team_default">
            <div class="card" style="border: none">
              <div class="card-body">
                <h4><input style="border: none; text-align: center" type="text" name="team_1[]" value="Team 1"></h4>
                <div style="display: flex; flex-direction: column; align-items: center">
                  <select name="team_1[]" style="width: 50%; border:none">
                    @foreach ($players as $player)
                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                    @endforeach
                  </select>
                  <select name="team_1[]" style="width: 50%; border:none">
                    @foreach ($players as $player)
                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="stats-card" id="team_default">
            <div class="card" style="border: none">
              <div class="card-body">
                <h4><input style="border: none; text-align: center" type="text" name="team_2[]" value="Team 2"></h4>
                <div style="display: flex; flex-direction: column; align-items: center">
                  <select name="team_2[]" style="width: 50%; border:none">
                    @foreach ($players as $player)
                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                    @endforeach
                  </select>
                  <select name="team_2[]" style="width: 50%; border:none">
                    @foreach ($players as $player)
                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>

    <hr>
    <div class="row" style="margin-bottom: 28px; margin-top: 28px; align-items: center;">
      <div class="col-sm-4">
        <label class="form-text">Best of Sets</label>
      </div>
      <div class="col-sm-8" style="text-align: right">
        <select class="form-select" name="best-of-sets">
          @for ($i = 1; $i <= 20; $i += 2)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
    </div>
    <div class="row" style="margin-bottom: 28px; align-items: center;">
      <div class="col-sm-4">
        <label class="form-text">Best of Legs</label>
      </div>
      <div class="col-sm-8" style="text-align: right">
        <select class="form-select" name="best-of-legs">
          @for ($i = 1; $i <= 20; $i += 2)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
    </div>
    <div style="text-align: center">
      {!! Form::submit('Start Match', ['class' => 'start-button', 'type' => 'button']) !!}
    </div>
    {{ Form::close() }}
  </div>
</div>

</div>

<script>
  function addPlayer() {
    var ul = document.getElementById('players-list');
    var ul_buttons = document.getElementById('player-remove-button-list');
    var li = document.createElement('li');
    li.setAttribute('class', 'list-group-item');
    li.setAttribute('id', 'li_' + lindex);

    var select = document.createElement('select');
    select.setAttribute("name", 'players[]');
    select.setAttribute("class", 'form-select');
    select.setAttribute('style', 'border: none; width: 100%');

    for (let i = 0; i < player_names.length; i++)
    {
      var opt = document.createElement('option');
      opt.setAttribute('value', player_ids[i]);
      opt.innerHTML = player_names[i];

      select.appendChild(opt);
    }
    
    li.appendChild(select);
    ul.appendChild(li);
    
    var li2 = document.createElement('li');
    li2.setAttribute('class', 'list-group-item');
    li2.setAttribute('id', 'btn_' + lindex);
    li2.setAttribute('style', 'border: none');
    var btn = document.createElement('button');
    btn.setAttribute('class', 'btn btn-outline-danger btn-sm');
    btn.setAttribute('type', 'button');
    btn.setAttribute('onClick', 'removePlayer(' + lindex +')');
    btn.innerHTML = 'x';
    li2.appendChild(btn);

    ul_buttons.appendChild(li2);
    console.log(lindex);
    lindex ++;
  }

  function removePlayer(index) {
    var li = document.getElementById('li_'+ index);
    var btn = document.getElementById('btn_' + index);

    li.remove();
    btn.remove();
  }

  function addTeam() {
    var number = document.getElementById('teams-div').childElementCount;
    
    var div = document.createElement('div');
    div.setAttribute('class', 'stats-card');

    var div_card = document.createElement('div');
    div_card.setAttribute('class', 'card');
    div_card.setAttribute('style', 'border:none');

    var div_body = document.createElement('div');
    div_body.setAttribute('class', 'card-body');

    var h4 = document.createElement('h4');
    var inp = document.createElement('input');
    inp.setAttribute('style', 'border: none; text-align: center');
    inp.setAttribute('type', 'text');
    inp.setAttribute('name', 'team_' + (number + 1) + '[]');
    inp.setAttribute('value', 'Team ' + (number + 1));
    h4.appendChild(inp);

    var div_colm = document.createElement('div');
    div_colm.setAttribute('style', 'display: flex; flex-direction: column');

    h4.appendChild(div_colm);
    div_body.appendChild(h4);
    div_card.appendChild(div_body);
    div.appendChild(div_card);

    document.getElementById('teams-div').appendChild(div);
  }

  document.getElementById('gamemode-select').addEventListener('change', function (e) {
    if (e.target.value === "teams") {
      document.getElementById('standard-players').style.display = 'none';
      document.getElementById('teams-players').style.display = 'block';
    } else {
      document.getElementById('standard-players').style.display = 'block';
      document.getElementById('teams-players').style.display = 'none';
    }
  });
</script>

@endsection