<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
  function test() {
    return view('home2');
  }

  function showUser($id) {
    $player = DB::table('users')->where('id', $id)->get()->first();
    $d = array();
    $form = array();

    $player->{'t_26s'} = 0;
    $player->{'t_100s'} = 0;
    $player->{'t_180s'} = 0;
    $player->{'highest'} = 0;
    $player->{'highest_finish'} = 0;

    $s = DB::table('player_stats')->where('player_id', $id)->orderBy('stat_id', 'desc')->take(5)->get('match_id');

    foreach($s as $st) {
      $match = DB::table('matches')->where('id', $st->match_id)->get('winner_id')->first();
      if ($match->winner_id == $id)
        array_push($form, 'W');
      else
        array_push($form, 'L');
    }
    $legs = DB::table('player_stats')->where('player_id', $id)->get('leg_avgs');

    if (count($legs) == 0) {
      $best = new \stdClass();
      $best->{"match_avg"} = 0.00;
      $player->{"fav_gt"} = 'Not Available';
      $player->{"fav_gt_length"} = 0;
      $form = ['Not available'];
      $player->{"fav_points"} = 'Not Available';
      $player->{"fav_points_length"} = 0;

      $matches_played = 0;
      $darts_thrown = 0;
      $wins = 0;
      $winrate = 0;
      $d = [0];

      return view('user', compact('player', 'darts_thrown', 'matches_played', 'best', 'wins', 'form', 'winrate', 'd'));
    }

    $matches_played = count(DB::table('player_stats')->where('player_id', $id)->get());

    foreach($legs as $leg) {
      $str = explode(',', $leg->leg_avgs);

      if (count($str) > 0)
        for ($i = 0; $i < count($str); $i++) {
          array_push($d, $str[$i]);
        }
      else {
        array_push($d, $str);
      }
    }
    $best = DB::table('player_stats')->where('player_id', $id)->orderBy('match_avg', 'desc')->get('match_avg')->first();

    $matches_id = DB::table('player_stats')->where('player_id', $id)->get('match_id');
    
    $game_type_name = ['Standard', 'I dont know'];
    $game_type = [0, 0];

    $points = [101, 301, 501, 701, 1001];
    $ok = [0, 0, 0, 0, 0];
    $wins = 0;

    foreach($matches_id as $match_id) {
      $match = DB::table('matches')->where('id', $match_id->match_id)->get()->first();

      if ($match->winner_id == $player->id)
        $wins ++;

      if ($match->game_type == 'standard')
        $game_type[0] ++;
      else
        $game_type[1] ++;

      if ($match->points == 101)
        $ok[0] ++;
      else if ($match->points == 301)
        $ok[1] ++;
      else if ($match->points == 501)
        $ok[2] ++;
      else if ($match->points == 701)
        $ok[3] ++;
      else if ($match->points == 1001)
        $ok[4] ++;
    }

    $max_gt = max($game_type);
    $gt_index = array_keys($game_type, $max_gt);
    
    $max_gt = max($ok);
    $points_index = array_keys($ok, $max_gt);

    $player->{"fav_gt"} = $game_type_name[$gt_index[0]];
    $player->{"fav_gt_length"} = $game_type[$gt_index[0]];

    $player->{"fav_points"} = $points[$points_index[0]];
    $player->{"fav_points_length"} = $ok[$points_index[0]];



    $stats = DB::table('player_stats')->where('player_id', $id)->get();
    foreach($stats as $stat) {
      $player->{'t_26s'} += $stat->total_26s;
      $player->{'t_100s'} += $stat->total_100s;
      $player->{'t_180s'} += $stat->total_180s;

      if ($stat->highest > $player->highest)
        $player->highest = $stat->highest;
      if ($stat->highest_finish > $player->highest_finish)
        $player->highest_finish = $stat->highest_finish;
    }

    $darts_thrown = count($d);
    $winrate = intval($wins / $matches_played * 100);
    return view('user', compact('player', 'darts_thrown', 'matches_played', 'best', 'wins', 'form', 'winrate', 'd'));
  }

  function showUsers() {
    $players = DB::table('users')->get();

    for ($i = 0; $i < count($players); $i++) {
      $s = DB::table('player_stats')->where('player_id', $players[$i]->id)->get();
      $players[$i]->{"m_played"} = count($s);
      $wins = DB::table('matches')->where('winner_id', $players[$i]->id)->get();
      $players[$i]->{"wins"} = count($wins);
    }

    return view('users', compact('players'));
  }

  function addUser() {
    return view('add_player');
  }

  function addUser_POST() {
    $name = $_POST['username'];

    $user = DB::table('users')->where('name', $name)->get()->first();
    if ($user != null)
      return redirect('/add_user');

    DB::table('users')->insert([
      'name' => $name,
      'fav_color' => $_POST['fav_color']
    ]);

    return redirect('users');
  }

  function editUser($id) {
    $user = DB::table('users')->where('id', $id)->get()->first();
    return view('edit_player', compact('user'));
  }

  function editUser_POST($id) {
    DB::table('users')->where('id', $id)->update([
      'name' => $_POST['username'],
      'fav_color' => $_POST['fav_color']
    ]);

    return redirect('/user'.'/'.$id);
  }

  function deleteUser($id) {
    DB::table('users')->where('id', $id)->delete();
    return redirect('/users');
  }

  function prepareMatch($game) {
    $players = DB::table('users')->get();

    return view('prepare-match', compact('players'));
  }

  function startMatch() {
    $game_type = $_POST['game-type'];
    $ids = $_POST['players'];
    $ids_ordered = implode(',', $ids);

    $players = DB::table('users')->whereIn('id', $ids)->orderByRaw("FIELD(id, $ids_ordered)")->get();

    $best_of_sets = $_POST['best-of-sets'];
    $best_of_legs = $_POST['best-of-legs'];

    return view('playmatch', compact('game_type', 'players', 'best_of_sets', 'best_of_legs'));
  }

  function saveStats() {
    $c = request('c');
    $winner = request('winner');
    $best_of_legs = request('bol');
    $best_of_sets = request('bos');

    $match_id = DB::table('matches')->insertGetId([
      'winner_id' => $winner,
      'match_started' => request('ms'),
      'best_of_sets' => $best_of_sets,
      'best_of_legs' => $best_of_legs,
      'total_players' => $c,
      'game_type' => request('game-type'),
      'points' => request('points')
    ]);

    for ($i = 1; $i <= $c; $i++)
    {
      $p = 'p'.$i.'_';
      $player = DB::table('users')->where('id', request($p.'id'))->get()->first();

      DB::table('player_stats')->insert([
        'player_id' => $player->id,
        'match_id' => $match_id,
        'match_avg' => request($p.'match-avg'),
        'leg_avgs' => request($p.'leg-avgs'),
        'nineDart_avg' => request($p.'9dart-avg'),
        'total_26s' => request($p.'26s'),
        'total_100s' => request($p.'100s'),
        'total_180s' => request($p.'180s'),
        'highest' => request($p.'highest'),
        'highest_finish' => request($p.'highest-finish'),
        'legs_won' => request($p.'legs-won'),
        'sets_won' => request($p.'sets-won')
      ]);
    }

    return redirect('/show-match'.'/'.$match_id);
  }

  function history() {
    $matches = DB::table('matches')->get();
    $winners = array();

    foreach($matches as $match) {
      $player = DB::table('users')->where('id', $match->winner_id)->get('name')->first();

      array_push($winners, $player);
    }
    return view('history', compact('matches', 'winners'));
  }

  function deleteMatch($id) {
    DB::table('matches')->where('id', $id)->delete();
    DB::table('player_stats')->where('match_id', $id)->delete();

    return redirect('/history');
  }

  function showMatch($id) {
    $match = DB::table('matches')->where('id', $id)->get()->first();
    $players = DB::table('player_stats')->where('match_id', $id)->get();
    $legs_avgs = array();

    foreach($players as $player) {
      $name = DB::table('users')->where('id', $player->player_id)->select('name')->get()->first();
      $color = DB::table('users')->where('id', $player->player_id)->select('fav_color')->get()->first();
      $player->{"name"} = $name->name;
      $player->{"fav_color"} = $color->fav_color;

      $str = explode(',', $player->leg_avgs);
      array_push($legs_avgs, $str);
    }
    return view('show-match', compact('match', 'players', 'legs_avgs'));
  }

}
