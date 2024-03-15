@extends('template')

@section('content')
    <h1 id="title">Match Settings</h1>
    <br>

    <script>
        var players = [];
        var player_count = 0;
    </script>

<div id="div" style="display: block">

    <form action="/play" method="post">
        {{ csrf_field() }}

        <p>Turn Background Color
            <input type="color" style="margin-left: 40px" value="#ac518c" name="turn-color">
        </p>

        <p>Background Color
            <input type="color" style="margin-left: 90px" value="#17a2b8" name="background-color">
        </p>

        <div class="row" style="width: 50%">
            <p style="margin-left: 15px">Points :</p>
            <div class="col-sm-4">
                <select name="maxPoints">
                    <option value="101">101</option>
                    <option value="301">301</option>
                    <option value="501" selected>501</option>
                    <option value="701">701</option>
                    <option value="1001">1001</option>
                    <option value="freeplay">FreePlay</option>
                </select>
            </div>
            
            <hr>
            <p>Best Of :</p>

            <div class="col-sm-4">
                <select name="bestOf">
                    <option value="3" selected>3</option>
                    <option value="5">5</option>
                    <option value="7">7</option>
                    <option value="9">9</option>
                </select>
            </div>

        </div>

        
        <hr>
        <p>Players : </p>

        <ul id="players-list"></ul>

        <input type="text" id="player" name="player-name" class="example_d" />
        <button onclick="addPlayerToList()" type="button"  class="example_c">Add Player</button>
        <button onclick="removePlayerFromList()" type="button"  class="example_c">Remove Player</button>
    
        <script src="{{ URL::asset('js_files/chestie.js') }}"></script>
        
        <hr>

        <button type="submit" id="submit-button" class="example_c" style="margin-left: -0px">Play</button>
    </form>

</div>

@endsection