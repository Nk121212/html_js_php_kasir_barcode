<?php $active = 'index'; include 'template/header.php'; ?>

<div class="container-fluid py-4">
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="chart">
                <canvas id="bar-chart" class="chart-canvas" height="120px"></canvas>
            </div>
        </div>
    </div>
</div>


<?php include 'template/footer.php'; ?>

<script>
    // var barChartData = {
    //   labels: ,
    //   datasets: [{
    //     label: 'Monthly Sales',
    //     backgroundColor: 'rgba(75, 192, 192, 0.2)',
    //     borderColor: 'rgba(75, 192, 192, 1)',
    //     borderWidth: 1,
    //     data: [65, 59, 80, 81, 56]
    //   }]
    // };

    // // Get the canvas element
    // var ctx = document.getElementById('bar-chart').getContext('2d');

    // // Create the bar chart
    // var myBarChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: barChartData,
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        const data = JSON.parse(this.responseText);
        createChart(data);
      }
    };
    xhr.open('GET', 'api/chart/top_10_sell.php', true);
    xhr.send();

    // Chart creation function
    function createChart(data) {
        // console.log(data.labels);
        // console.log(data.values);
      const ctx = document.getElementById('bar-chart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Top 10 Selling Item',
            data: data.values,
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Adjust color as needed
            borderColor: 'rgba(54, 162, 235, 1)', // Adjust color as needed
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }

</script>