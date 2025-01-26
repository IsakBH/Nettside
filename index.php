<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="skjema.css">
    <link rel="icon" href="your-favicon-url">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include("../Include/HTML/navbar.html"); ?>

    <div id="mainContent">
        <h1>Avfall Data Visualisering</h1>

        <!-- Container for graphs -->
        <div class="graphs-container">
            <!-- Pie Chart -->
            <div class="chart-wrapper">
                <canvas id="pieChart"></canvas>
            </div>

            <!-- Bar Chart -->
            <div class="chart-wrapper">
                <canvas id="barChart"></canvas>
            </div>

            <!-- Line Chart -->
            <div class="chart-wrapper">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Sample data - replace with your actual data
        const data1 = {
            labels: ['Fordi det er viktig med kildesortering', 'Jeg liker å ta vare på miljøet', 'Jeg kildesorterer ikke'],
            datasets: [{
                data: [10, 3, 14],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ]
            }]
        };

        const data2 = {
            labels: ['Jeg er imot kildesortering', 'Har ikke lyst', 'Fordi jeg kunne ikke brydd meg mindre'],
            datasets: [{
                data: [5, 6, 3],
                backgroundColor: [
                    '#444444',
                    '#999999',
                    '#077653'
                ]
            }]
        };

        const data3 = {
            labels: ['Ja', 'Nei', 'Noen ting men ikke alle'],
            datasets: [{
                data: [7, 12, 8],
                backgroundColor: [
                    '#F5FF8F',
                    '#53342',
                    '#eeeeee'
                ]
            }]
        };

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: data1,
            datasets: [{
                data: [10, 3, 14]
            }],
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Hvorfor kildesorterer du?'
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('barChart'), {
            type: 'pie',
            data: data2,
            datasets: [{
                data: [3, 3, 5]
            }],
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Hvorfor kildesorterer du ikke?'
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'pie',
            data: data3,
            datasets: [{
                data: [10, 3, 14]
            }],
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Kildesorterer du?'
                    }
                }
            }
        });
    </script>

    <style>
        .graphs-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .chart-wrapper {
            width: 400px;
            height: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1, p {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 10px;
        }
    </style>

    <h1>Hva betyr dette for miljøet?</h1>
    <p>Svarene på denne spørreundersøkelsen viser at det er et flertall som enten ikke kildesorterer i det hele tatt, eller som ikke kildesorterer alle ting. Det er ikke særlig bra for miljøet, fordi boss kommer på feil sted og blir prosessert på feil måte. For eksempel hvis du kaster batterier i et papirboss og det ikke blir sortert vekk av de som driver med boss greiene, så blir de prossesert på feil måte og det er ikke bra.</p>
</body>
</html>
