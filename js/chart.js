              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);

              function drawChart() {
                  var jsonData = $.ajax({
                      url: "database/getData.php",
                      dataType:"json",
                      async: false
              }).responseText;

            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(jsonData);

                var options = {
                    title: 'Temperature Over 30 Days',
                    curveType: 'function',
                    legend: {
                        position: 'bottom'
                    },
                    backgroundColor: 'black',
                    hAxis: {
                        showTextEvery: 5,
                        textStyle: {
                            color: 'white',
                        },
                    },
                    vAxis: {
                        textStyle: {
                            color: 'white',
                        },
                    },
                    lineWidth: 1.5,
                    legend: {
                        textStyle: {
                            color: 'white',
                        },
                    },
                    titleTextStyle: {
                        color: 'white',
                    },
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('chart'));

                    chart.draw(data, options);
                  }