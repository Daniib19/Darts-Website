const closest = (arr, num) => {
	return arr.reduce((acc, val) => {
		 if(Math.abs(val - num) < Math.abs(acc)){
				return val - num;
		 }else{
				return acc;
		 }
	}, Infinity) + num;
}

function generateScore(max) {
	var perc = Math.random();

	var score_max;
	var score_min;

	for (var i = 0; i < bot.length; i++) {
		if (perc > bot[i][2] && perc < bot[i][3]) {
			score_max = bot[i][0];
			score_min = bot[i][1];
		}
	}

	var score = Math.floor(Math.random() * (score_max - score_min + 1) + score_min);
	var possible_scores = [3, 5, 7, 9, 11, 15, 21, 25, 26, 30, 35,40,41,45,55,60,66,70,76,80,81,85,95,97,99,100,121,123,125,135,140,174,177,180];

	score = closest(possible_scores, score);

	if (score > max)
		score = max;

	return score;
}