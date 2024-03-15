<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DartsController extends Controller
{
    public function playMatch() {
        $players = $_POST['players'];
        $maxPoints = $_POST['maxPoints'];
        $bestOf = $_POST['bestOf'];
        $colors = [];

        $turn_color = $_POST['turn-color'];
        $background_color = $_POST['background-color'];
        
        for ($i = 0; $i < count ($players); $i++) {
            array_push ($colors, $_POST['player_'. $i . '_color']);
        }

        if ($maxPoints == 'freeplay')
        {
            $maxPoints = 501;
            $bestOf = 100;
        }

        return view('play-match', compact("players", "maxPoints", "bestOf", "colors", "turn_color", "background_color"));
    }
}

