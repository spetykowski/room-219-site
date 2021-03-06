<?php
// Access provided by database configuration file
require_once 'config.php';

// Create connection to MySQL Database
$conn = new mysqli($servername, $username, $password, $dbname);
    
// Check for sucessful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
        
// Request most recent recorded temperature
$res = $conn->query("SELECT * FROM env_sensors ORDER BY TempID DESC LIMIT 1");

// Request lowest temperature of the past 7 days
// Request will gather the oldest reading within the last 7 days. i.e. if it was 64 on 3/1 and 3/5, the data provided will reflect 3/1
$lowtempreq = $conn->query("SELECT TemperatureF AS low_temp, DATE_FORMAT(Date_Time, '%c/%e') AS date_of_reading FROM env_sensors WHERE Date_Time BETWEEN (CURRENT_TIMESTAMP() - INTERVAL 7 DAY) AND CURRENT_TIMESTAMP() ORDER BY low_temp, date_of_reading LIMIT 1");
$lowtemp = $lowtempreq->fetch_row();    

// Request average temperature of the past 7 days       
$avg = $conn->query("SELECT AVG(TemperatureF) AS average_temp FROM env_sensors WHERE Date_Time BETWEEN (CURRENT_TIMESTAMP() - INTERVAL 7 DAY) AND CURRENT_TIMESTAMP()");
$avgrow = $avg->fetch_row();

// Request highest temperature of the past 7 days 
// Request will gather the oldest reading within the last 7 days. i.e. if it was 72 on 3/1 and 3/5, the data provided will reflect 3/1
$hightempreq = $conn->query("SELECT TemperatureF AS high_temp, DATE_FORMAT(Date_Time, '%c/%e') AS date_of_reading FROM env_sensors WHERE Date_Time BETWEEN (CURRENT_TIMESTAMP() - INTERVAL 7 DAY) AND CURRENT_TIMESTAMP() ORDER BY high_temp DESC, date_of_reading LIMIT 1");
$hightemp = $hightempreq->fetch_row();

// Request date and time of most recent recorded temperature
$currentDateReq = $conn->query("SELECT Date_Time FROM env_sensors ORDER BY TempID DESC LIMIT 1");
$currentDate = $currentDateReq ->fetch_row();
date_default_timezone_set('America/New_York');

//
// HISTORICAL DATA
//

// Request highest temperature ever recorded
$recordhighrequest = $conn->query("SELECT TemperatureF AS 'Temperature', DATE_FORMAT(Date_Time, '%M %e\, %Y') AS 'Date'
FROM env_sensors
WHERE TemperatureF IN (
	SELECT MAX(TemperatureF)
	FROM env_sensors
)
LIMIT 1");
$recordhigh = $recordhighrequest->fetch_row();

// Request lowest temperature ever recorded
$recordlowrequest = $conn->query("SELECT TemperatureF AS 'Temperature', DATE_FORMAT(Date_Time, '%M %e\, %Y') AS 'Date'
FROM env_sensors
WHERE TemperatureF IN (
	SELECT MIN(TemperatureF)
	FROM env_sensors
)
LIMIT 1");
$recordlow = $recordlowrequest->fetch_row();
        
?>