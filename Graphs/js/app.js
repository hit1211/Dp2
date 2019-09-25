
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("data.php",
                function (data)
                {
                    console.log(data);
                     var player = [];
                    var score = [];

                    for (var i in data) {
                        player.push(data[i].playerID);
                        score.push(data[i].score);
                    }

                    var chartdata = {
                        labels: player,
                        datasets: [
                            {
                                label: 'player Score',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: score
                            }
                        ]
                    };

                    var ctx = $("#mycanvas");
					
                    var mycanvas = new Chart(ctx, {
                        type: 'line',
                        data: chartdata
                    });
                });
            }
        }
