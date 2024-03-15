function getLabels() {
  let labels = [];

  for (var i = 1; i <= legs_count; i++) {
    var s;

    if (i % 10 == 1)
        s = 'st';
    else if (i % 10 == 2)
        s = 'nd';
    else if (i % 10 == 3)
        s = 'rd';
    else 
        s = 'th';
    
    var str = i + '' + s + ' leg';

    labels.push(str);
  }
  return labels;
}

function addDataset(chart, index) {
  const data = chart.data;
  var r = Math.floor(Math.random() * 255);
  var g = Math.floor(Math.random() * 255);
  var b = Math.floor(Math.random() * 255);

  data.labels = getLabels();

  const newDataset = {
      label: player_names[index],
      // backgroundColor: 'rgb('+ r + ', ' + g + ', ' + b +')',
      // borderColor: 'rgb('+ r + ', ' + g + ', ' + b +')',
      backgroundColor: player_colors[index],
      borderColor: player_colors[index],
      tension: 0.4,
      data: legs_avgs_js[index]
  };

  chart.data.datasets.push(newDataset);
  chart.update();
}