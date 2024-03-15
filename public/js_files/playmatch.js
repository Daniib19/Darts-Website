var turn = 0;
var starter = 0;
var winner_id;

var player_legs = [];
var player_sets = [];
var player_legs_won = [];
var player_sets_won = [];

var shots_history = [];
var player_shots = make2DArray(players_count, 0);
var player_leg_start = [];
var player_leg_avgs = make2DArray(players_count, 0);

document.getElementById('points').addEventListener("keyup", function(event) {
  if (event.code === "Enter" || event.code === "NumpadEnter")
  addPoints();
}
);

for (var i = 0; i < players_count; i++)
{
  player_legs.push(0);
  player_sets.push(0);
  player_leg_start.push(0);
  player_legs_won.push(0);
  player_sets_won.push(0);
  player_leg_avgs[i].push('');
}

updateAllHeaders();

function changeTurn()
{
  if (turn == players_count - 1)
    turn = 0;
  else
    turn ++;
}
function changeStarter()
{
  if (starter == players_count - 1)
    starter = 0;
  else
    starter ++;
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

function checkWinner()
{
  for (let i = 0; i < players_count; i++)
    if (player_sets[i] == first_to_sets)
    {
      winner_id = player_ids[turn];
      updateHeader(turn, 'rgb(253, 209, 12)');
      document.getElementById('savestats').style.display = 'block';
      for (var j = 0; j < players_count; j++){
        let s = document.getElementById('player_' + j + '_leg-avg').innerHTML;
        player_leg_avgs[j][0] = player_leg_avgs[j][0] + s;
      }
      saveStats();
      return true;
    }

    return false;
}

function nextLeg()
{
  for (var i = 0; i < players_count; i++)
  {
    document.getElementById('player_' + i + '_points').innerHTML = game_points;
    let s = document.getElementById('player_' + i + '_leg-avg').innerHTML;
    player_leg_avgs[i][0] = player_leg_avgs[i][0] + s + ',';
    
    document.getElementById('player_' + i + '_leg-avg').innerHTML = 0.00;
    player_leg_start[i] = player_shots[i].length;
  }

  changeStarter();

  turn = starter;
  updateAllHeaders();
}

function getInnerHtml(id, text)
{
  return document.getElementById("player_" + id + "_" + text).innerHTML;
}

function saveStats() {
  var btn = document.getElementById('savestats-btn');

  let url = '?c=' + players_count + '&';

  for (var i = 0; i < players_count; i++)
  {
    let player = 'p' + (i + 1) + '_';
    console.log (player_leg_avgs[i]);
    url += (
      player + 'id=' + player_ids[i]
      + '&' + player + 'match-avg=' + getInnerHtml(i, 'match-avg')
      + '&' + player + 'leg-avgs=' + player_leg_avgs[i][0]
      + '&' + player + '9dart-avg=' + getInnerHtml(i, '9dart-avg')
      + '&' + player + '26s=' + getInnerHtml(i, '26s')
      + '&' + player + '100s=' + getInnerHtml(i, '100s')
      + '&' + player + '180s=' + getInnerHtml(i, '180s')
      + '&' + player + 'highest=' + getInnerHtml(i, 'highest')
      + '&' + player + 'highest-finish=' + getInnerHtml(i, 'highest-finish')
      + '&' + player + 'legs-won=' + player_legs_won[i]
      + '&' + player + 'sets-won=' + player_sets_won[i] + '&'
    );

  }

  url += ( 'winner=' + winner_id + '&bos=' + bos + '&bol=' + bol + '&game-type=standard&points=' + game_points + '&ms=' + match_started);
  btn.setAttribute('href', '/save-stats' + url);
}

function checkSets(index)
{
  if (player_legs[index] == first_to_legs)
  {
    player_sets[index] ++;
    player_sets_won[index] ++;
  
    for (var i = 0; i < players_count; i++){
      player_legs[i] = 0;
      document.getElementById('player_' + i + '_sets').innerHTML = player_sets[i];
    }
  }

  for (var i = 0; i < players_count; i++)
    document.getElementById('player_' + i+ '_legs').innerHTML = player_legs[i];
}

function updateAllHeaders()
{
  for (var i = 0; i < players_count; i++)
  {
    var div = document.getElementById('player_' + i + '_header');
    var text = document.getElementById('player_' + i + '_name');
    text.style.color = 'black';
    // text.style.fontWeight = 'bold';
    updateHeader(i, '#ffffff');
  }
  
  var text = document.getElementById('player_' + turn + '_name');
  let col = hexToRgb(player_colors[turn]);
  if (getTextColor(col))
    text.style.color = 'black';
  else
    text.style.color = 'white';

  // updateHeader(turn, 'rgb(67, 67, 68)');
  updateHeader(turn, player_colors[turn]);
}

function updateHeader(index, color) 
{
  var div = document.getElementById('player_' + index + '_header');
  div.style.backgroundColor = color;
}

function calculateAvg(index, start)
{
  var sum = 0;
  var shots = 0;

  for (var i = start; i < player_shots[index].length; i++)
  {
    sum += player_shots[index][i];
    shots ++;
  }
  if (sum == 0)
    return 0;
  
  var number = sum / parseInt(shots);

  if (Number.isInteger(number))
      return number;
  else
      return (Math.round(number * 100) / 100).toFixed(2);
}

function calculateFirst9(index)
{
  var sum = 0;
  var shots = 0;

  var end = 9;
  if (player_shots[index].length < 9)
    end = player_shots[index].length;
  
  for (var i = 0; i < end; i++)
  {
    sum += player_shots[index][i];
    shots ++;
  }

  if (sum == 0)
    return 0;
  
  var number = sum / parseInt(shots);

  if (Number.isInteger(number))
      return number;
  else
      return (Math.round(number * 100) / 100).toFixed(2);
}

function addPoints()
{
  if (isBot == true && bot_turn == turn)
  {
    var rem_points = document.getElementById('player_' + turn + '_points').innerHTML;
    
    points = generateScore(parseInt(rem_points));

    document.getElementById('points').value = points;
  } else {
    var points = parseInt(document.getElementById("points").value);
  }

  var points_text = document.getElementById("points");
  var rem_points = parseInt(document.getElementById("player_" + turn + "_points").innerHTML);

  // check if valid points

  if (points < 0 || points > 180) {
    console.log ('trist -1');
  } else if (!Number.isInteger(points)) {
    console.log ('trist 0');
  } else if (points > rem_points) {
    console.log ('invalid 1');
  } else if ( ( rem_points - points ) < 0) {
    console.log ('invalid 2');
  } else if (rem_points == points)
  {
    // next Leg
    shots_history.push (points);
    player_shots[turn].push(points);

    if (points == 26){
      var c_26 = parseInt(document.getElementById("player_" + turn + "_26s").innerHTML) + 1;
      document.getElementById("player_" + turn + "_26s").innerHTML = c_26;
    }
    if (points >= 100){
      var c_100 = parseInt(document.getElementById("player_" + turn + "_100s").innerHTML) + 1;
      document.getElementById("player_" + turn + "_100s").innerHTML = c_100;
    }
    document.getElementById("player_" + turn + "_points").innerHTML = rem_points - points;
    document.getElementById("player_" + turn + "_latest").innerHTML = points;
    if (points > document.getElementById("player_" + turn + "_highest-finish").innerHTML)
      document.getElementById("player_" + turn + "_highest-finish").innerHTML = points;
    
    document.getElementById("player_" + turn + "_match-avg").innerHTML = calculateAvg(turn, 0);
    document.getElementById("player_" + turn + "_leg-avg").innerHTML = calculateAvg(turn, player_leg_start[turn]);
    document.getElementById("player_" + turn + "_9dart-avg").innerHTML = calculateFirst9(turn);

    points_text.value = '';
    points_text.focus();

    player_legs[turn] ++;
    player_legs_won[turn] ++;

    checkSets(turn);

    if (checkWinner()) {
    document.getElementById("player_" + turn + "_match-avg").innerHTML = calculateAvg(turn, 0);
    
      return 0;
    } else
      nextLeg();
    
  } else
  {

    shots_history.push (points);
    player_shots[turn].push(points);
    // points
    document.getElementById("player_" + turn + "_points").innerHTML = rem_points - points;
    // 26
    if (points == 26){
      var c_26 = parseInt(document.getElementById("player_" + turn + "_26s").innerHTML) + 1;
      document.getElementById("player_" + turn + "_26s").innerHTML = c_26;
    }
    // 100 +
    if (points >= 100){
      var c_100 = parseInt(document.getElementById("player_" + turn + "_100s").innerHTML) + 1;
      document.getElementById("player_" + turn + "_100s").innerHTML = c_100;
    }
    // 100 +
    if (points == 180){
      var c_180 = parseInt(document.getElementById("player_" + turn + "_180s").innerHTML) + 1;
      document.getElementById("player_" + turn + "_180s").innerHTML = c_180;
    }
    // latest
    document.getElementById("player_" + turn + "_latest").innerHTML = points;
    //highest
    var highest = document.getElementById("player_" + turn + "_highest").innerHTML;
    // match avg
    document.getElementById("player_" + turn + "_match-avg").innerHTML = calculateAvg(turn, 0);
    // leg avg
    document.getElementById("player_" + turn + "_leg-avg").innerHTML = calculateAvg(turn, player_leg_start[turn]);
    // first 9
    document.getElementById("player_" + turn + "_9dart-avg").innerHTML = calculateFirst9(turn);

    if (points > highest)
      document.getElementById('player_' + turn + '_highest').innerHTML = points;
    

    changeTurn();
    updateAllHeaders();
    if (isBot == true && bot_turn == turn)
      addPoints();
    
  }
  
  points_text.value = '';
  points_text.focus();
}