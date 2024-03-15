@extends('template')

@section('content')
    <h1>Match</h1>
    <h5 id="bestOf">Best of {{ $bestOf }}</h5>
    <br>

    <script>
        var winner;
        var p = {{ $maxPoints }};
        var bestOf = {{ $bestOf }};
        var firstTo = parseInt ( bestOf / 2 ) + 1;
        var player_colors = [];
        var turn_color = <?php echo json_encode($turn_color); ?>;
        var background_color = <?php echo json_encode($background_color); ?>;
        // var firstTo = 1;
    </script>

        @foreach ($colors as $color)
        <script>
            player_colors.push ( <?php echo json_encode($color); ?> );     
        </script>
        @endforeach

    <div class="card-deck" id="card-deck">
        <?php $i = 0 ?>
        @foreach ($players as $player)

        <div class="card bg-info" id="player_{{$i}}_div">
            <div class="card-body text-center">
                <p id="player_{{$i}}_points" class="card-text" style="font-size: 65px;">{{ $maxPoints }}</p>
                <p id="player_{{$i}}_name" style="font-size: 25px;">{{ $player }}</p>
                <hr>
                <p id="player_{{$i}}_score" style="font-size: 16px;">0</p>
                <p>
                    <svg id="player_{{$i}}_starter" visibility="hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
                        <circle style="color: #00ffc8" cx="8" cy="8" r="8"/>
                    </svg>
                </p>
                <p style="font-size: 25px" >Average</p>
                <p id="player_{{$i}}_average">0.00</p>
                <p style="font-size: 25px" >Last Shot</p>
                <p id="player_{{$i}}_lastShot">0</p>
                <p style="font-size: 25px" >Highest</p>
                <p id="player_{{$i}}_highest">0</p>
            </div>
        </div>
        <?php $i ++ ?>
        @endforeach
        
    </div>
    
    <hr>
    
    <input type="text" id="points" class="example_d" autocomplete="off">
    <button onclick="addPoints()" class="example_c">Shot</button>
    <button onclick="undoLastShot()" class="example_c">Undo</button>
    <button onclick="randomData()" class="example_c">Random Shot</button>
    
    <script src="{{ URL::asset('js_files/play_match.js') }}"></script>
    <br>
    <br>
    
    <div class="container" style="max-width: 90%">
        <canvas id="myChart"></canvas>
        <script>
            const labels = [
                
            ];
            const data = {
            labels: labels,
            datasets: [
                {
                    label: '',
                    data: [0, 180],
                    borderColor: 'rgba(0, 0, 0, 0)',
                    backgroundColor: 'rgba(0, 0, 0, 0)',
                },
            ]
        };

        const config = {
            type: 'line',
            data: data,
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
                    display: true,
                    text: 'Points Distribution'
                }
                }
            },
        };

        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        function drawGraph() {
            for (var i = 0; i < max_players; i++) {
                addDataset(myChart, i);            
            }

            document.getElementById("myChart").scrollIntoView({behavior: 'smooth'});
        }

    </script>
    </div>

@endsection