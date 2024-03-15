var turn = 0;
var div = document.getElementById('card-deck');
var max_players = div.getElementsByTagName("div").length / 2;
var maxPoints = parseInt ( document.getElementById('player_0_points').innerHTML );

var shots_history = [];
var player_names = [];
var player_scores = [];
var player_highest = [];
var player_shots = make2DArray (max_players, 0);

var shots;

var starter = 0;

document.getElementById('points').focus();
putStarterMarker( 0 );

for (var i = 0; i < max_players; i++)
{
    var playerName = document.getElementById ('player_' + i + '_name').innerHTML;
    
    player_names.push (playerName);
    player_scores.push (0);
    player_highest.push (0);
}

// updateDiv(turn, '#ac518c');
updateAllDivs();

document.getElementById('points').addEventListener("keyup", function(event) {
    if (event.code === "Enter")
    addPoints();
}
);

function changeTurn() {
    if (turn == max_players - 1)
        turn = 0;
    else
        turn ++;
}

function changeStarter() {
    if (starter == max_players - 1)
        starter = 0;
    else
        starter ++;
}

function newGame() {
    for (var i = 0; i < max_players; i++)
    {
        document.getElementById('player_' + i + '_points').innerHTML = maxPoints;
    }

    changeStarter();

    turn = starter;

    putStarterMarker(turn);
    updateAllDivs();
}

function checkWinner() {
    for (var i = 0; i < max_players; i++) {
        if (player_scores[i] == firstTo) {
            console.log ("cineva a castigat");
            updateDiv(turn, '#47b518');
            return true;
        }
    }

    return false;
}

function calculateAverage(index) {
    var sum = 0.00;
    var shots = 0;

    for (var i = 0; i < player_shots[index].length; i++) {
        sum += player_shots[index][i] * 1.00;
        shots ++;
    }

    var number = sum / parseInt(shots);

    if (Number.isInteger(number))
        return number;
    else
        return (Math.round(number * 100) / 100).toFixed(2);
}

function getAllShots(index) {
    var arr = [];

    for (var i = index; i < shots_history.length; i += max_players) {
        arr.push(shots_history[i]);
    }

    return arr;
}

function getLabels() {
    var n = parseInt ( shots_history.length / max_players ) + 1;
    var arr = [];

    for (var i = 1; i <= n; i++)
    {
        var s;

        if (i % 10 == 1)
            s = 'st';
        else if (i % 10 == 2)
            s = 'nd';
        else if (i % 10 == 3)
            s = 'rd';
        else 
            s = 'th';
        
        var str = i + '' + s + ' shot';

        arr.push ( str );
    }

    return arr;
}

function randomData() {
    var rem = parseInt( document.getElementById('player_' + turn + '_points').innerHTML );

    if (rem > 180)
        rem = 180;

    document.getElementById('points').value = Math.floor(Math.random() * rem) + 1;
}

function putStarterMarker(index) {
    for (var i = 0; i < max_players; i++) {
        if (i != index) {
            var d = document.getElementById ('player_' + i + '_starter');
            d.setAttribute ('visibility', 'hidden');
        }
    }

    var dd = document.getElementById ('player_' + index + '_starter');
        
    dd.setAttribute ('visibility', 'visible');
}

function make2DArray(rows, cols) {
    let x = [];

    for (let i = 0; i < rows; i++) {
        x[i] = [];
        for (let j = 0; j < cols; j++) {
        x[i][j] = [];
        }
    }
    return x;
}

function addPoints() {

    var points = parseInt ( document.getElementById('points').value );
    var remainingPoints = parseInt( document.getElementById('player_' + turn + '_points').innerHTML );

    if (points < 0 || points > 180) {
        console.log ('trist -1');
    } else if (!Number.isInteger(points)) {
        console.log ('trist 0');
    } else if (points > remainingPoints) {
        console.log ('invalid 1');
    } else if ( ( remainingPoints - points ) < 0) {
        console.log ('invalid 2');
    } else if (remainingPoints == points) {
        // winner
        
        var playerName = document.getElementById ('player_' + turn + '_name').innerHTML;
        document.getElementById('player_' + turn + '_points').innerHTML = '0';

        winner = playerName;
        
        shots_history.push(points);
        player_shots[turn].push (points);

        document.getElementById('player_' + turn + '_lastShot').innerHTML = points;
        player_scores[turn] ++;
        document.getElementById('player_' + turn + '_score').innerHTML = player_scores[turn];
        document.getElementById('player_' + turn + '_average').innerHTML = calculateAverage(turn);
        
        if (checkWinner() ) {
            drawGraph();
            return 0; 
        } else {
            newGame();
        }
        // createPGN();
    } else {
        shots_history.push(points);
        player_shots[turn].push (points);

        document.getElementById('player_' + turn + '_points').innerHTML = remainingPoints - points;
        document.getElementById('player_' + turn + '_lastShot').innerHTML = points;
        document.getElementById('player_' + turn + '_average').innerHTML = calculateAverage(turn);

        if (points > player_highest[turn]) {
            player_highest[turn] = points;
            document.getElementById('player_' + turn + '_highest').innerHTML = points;
        }

        changeTurn();
        updateAllDivs();
    }

    document.getElementById('points').value = '';
    document.getElementById('points').focus();
}

function updateAllDivs() {

    for (var i = 0; i < max_players; i++)
    {
        var div = document.getElementById('player_' + i + '_div');
        updateDiv(i, background_color);
    }

    var div = document.getElementById('player_' + turn + '_div');
    div.className = "card bg-danger";
    updateDiv(turn, turn_color);
}

function updateDiv(index, option) {
    var div = document.getElementById('player_' + index + '_div');
    div.setAttribute ('style', 'background-color: ' + option + ' !important');
}

function undoLastShot() {
    if (shots_history.length > 0) {
        if (turn != 0)
            turn--;
        else {
            turn = max_players - 1;
        }

        var remainingPoints = parseInt ( document.getElementById('player_' + turn + '_points').innerHTML );
        document.getElementById('player_' + turn + '_points').innerHTML = remainingPoints + parseInt ( shots_history.pop() );
        player_shots[turn].pop();
        if (player_shots[turn][player_shots[turn].length - 1] == null)
            document.getElementById('player_' + turn + '_average').innerHTML = '0';
        else
            document.getElementById('player_' + turn + '_average').innerHTML = calculateAverage(turn);

        updateAllDivs();
    }   
}

function createPGN() {
    var txt = '--Match( '+ p +' )--\n\n\n--' + winner + ' is winner--\n\n--Shots History--\n\n';

    for (var i = 0; i < shots_history.length; i++) {
        var name = player_names[i % max_players];
        txt += '--' + name + ' -> ' + shots_history[i] + '--\n';
    }
    console.log ( txt );

    return txt;
}

function addDataset(chart, index) {
    const data = chart.data;
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);

    // const dsColor = 'rgb(' + r + ', ' + g + ', ' + b + ')';
    // const dsColor = getRandomColor();
    const dsColor = player_colors [index];
    data.labels = getLabels();

    const newDataset = {
        label: player_names[index],
        backgroundColor: dsColor,
        borderColor: dsColor,
        tension: 0.4,
        data: player_shots[index]
    };

    chart.data.datasets.push(newDataset);
    chart.update();
}