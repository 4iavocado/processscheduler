<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CPU Scheduling Solver</title>
  <style>
    /* Reset some basic styling */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      height: 100vh;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: white;
      padding: 20px;
      overflow-y: auto;
    }
    
    h1 {
      text-align: center;
      color: white;
      margin-bottom: 30px;
      font-size: 36px;
      letter-spacing: 1px;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .input-section, .output-section {
      background-color: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      padding: 30px;
      margin-bottom: 30px;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      color: white;
    }
    
    table th, table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    table th {
      background-color: rgba(255, 255, 255, 0.1);
      font-weight: normal;
    }
    
    input[type="number"] {
      width: 100%;
      padding: 10px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      color: white;
      outline: none;
    }
    
    input[type="number"]::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }
    
    select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      color: white;
      outline: none;
      appearance: none;
      cursor: pointer;
    }
    
    select option {
      background-color: #1e3c72;
      color: white;
    }
    
    button {
      padding: 15px 30px;
      border: 2px solid white;
      border-radius: 50px;
      background: rgba(255, 255, 255, 0.1);
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s ease;
      color: white;
      font-size: 16px;
      letter-spacing: 0.5px;
    }
    
    button:hover {
      background-color: white;
      color: #1e3c72;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }
 /* Position the home button to align with algorithm label */
.home-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 20px;
  font-size: 16px;
  color: white;
  background: rgba(255, 255, 255, 0.1);
  border: 2px solid white;
  border-radius: 50px;
  text-decoration: none;
  transition: all 0.3s ease;
  margin-bottom: 30px;
  margin-left: 30px;
  position: absolute;
  top: 20px;
  right: 30px;
}

.home-link:hover {
  background-color: white;
  color: #1e3c72;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
}
    
    .submit-containers {
      display: flex;
      justify-content: center;
      width: 100%;
      margin-top: 20px;
    }
    
    .btn-primary {
      width: 50%;
    }
    
    .btn-add, .btn-remove {
      min-width: 150px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      font-weight: 500;
      display: block;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }
    
    .process-controls {
      display: flex;
      justify-content: flex-end;
      margin: 20px 0;
      gap: 15px;
    }
    
    /* Gantt Chart Styling */
    .gantt-container {
      margin-top: 20px;
    }
    
    .gantt-chart {
      width: 100%;
      height: 100px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      position: relative;
      display: flex;
      margin-top: 20px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 8px;
    }
    #gantt-chart {
      position: relative;
      height: 60px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      background-color: #f0f0f0;
    }

    #gantt-time-axis {
      display: flex;
      justify-content: space-between;
    }
    
    .gantt-block {
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 10px 15px;
      text-align: center;
      background: rgba(255, 255, 255, 0.1);
      min-width: 40px;
      position: relative;
      border-radius: 4px;
      margin: 1px;
    }
    
    .gantt-block.active {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      font-weight: bold;
    }
    
    .gantt-block span.process {
      display: block;
      font-size: 14px;
      font-weight: bold;
    }
    
    .gantt-block span.time {
      display: block;
      font-size: 12px;
      margin-top: 5px;
      color: rgba(255, 255, 255, 0.7);
    }
    
    .gantt-time-axis {
      display: flex;
      gap: 2px;
      padding: 0 10px;
      overflow-x: auto;
    }
    
    .time-marker {
      font-size: 12px;
      width: 100%;
    }
    
    .results-table {
      margin-top: 30px;
      overflow-x: auto;
    }
    
    .tab {
      margin-top: 20px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 10px 10px 0 0;
    }
    
    .tab button {
      background-color: transparent;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 12px 20px;
      border-radius: 0;
      color: white;
      transition: 0.3s;
      font-weight: normal;
      border-bottom: 2px solid transparent;
    }
    
    .tab button:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: none;
      box-shadow: none;
    }
    
    .tab button.active {
      background-color: rgba(255, 255, 255, 0.1);
      border-bottom: 2px solid white;
      font-weight: bold;
    }
    
    .tabcontent {
      display: none;
      padding: 20px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-top: none;
      border-radius: 0 0 10px 10px;
      background-color: rgba(255, 255, 255, 0.05);
      animation: fadeIn 0.5s;
    }
    
    #average-div {
      margin-top: 20px;
      padding: 15px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
    }
    
    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
    }
  </style>
</head>
<body>
  <h1>CPU Scheduling Solver</h1>
  
  <a href="index.php" class="home-link" id="homeBtn">Home</a>
  
  <div class="container">
    <div class="input-section">
      <form id="scheduler-form">
        <div class="form-group">
          <label class="form-label" for="algorithm">Algorithm:</label>
          <select name="algorithm" id="algorithm">
            <option value="fcfs" selected>First Come First Serve (FCFS)</option>
            <option value="sjf-nonpreemptive">Shortest Job First (Non-preemptive)</option>
            <option value="srtf">Shortest Remaining Time First (SRTF)</option>
            <option value="roundrobin">Round Robin</option>
            <option value="priority-nonpreemptive">Priority (Non-preemptive)</option>
            <option value="priority-preemptive">Priority (Preemptive)</option>
          </select>
        </div>
        
        <!-- Priority input (hidden by default) -->
        <div class="form-group" id="priority-group" style="display:none;">
          <label class="form-label" for="priority">Priority:</label>
          <input type="number" name="priority" id="priority" min="1" value="1">
        </div>
        
        <!-- Quantum input (hidden by default) -->
        <div class="form-group" id="quantum-group" style="display:none;">
          <label class="form-label" for="quantum">Time Quantum:</label>
          <input type="number" name="quantum" id="quantum" min="1" value="2">
        </div>
        
        <div class="process-controls">
          <button type="button" id="add-process" class="btn-add">Add Process</button>
          <button type="button" id="remove-process" class="btn-remove">Remove Process</button>
        </div>
        
        <table id="process-table">
          <thead>
            <tr>
              <th>Process</th>
              <th>Arrival Time</th>
              <th>Burst Time</th>
              <th class="priority-column" style="display:none;">Priority</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>P1</td>
              <td><input type="number" name="arrival_time[]" min="0" value="0" required></td>
              <td><input type="number" name="burst_time[]" min="1" value="5" required></td>
              <td class="priority-column" style="display:none;"><input type="number" name="priority[]" min="1" value="1" required></td>
            </tr>
          </tbody>
        </table>
        <div class="submit-containers">
          <button type="submit" class="btn-primary">Solve Scheduling Problem</button>
        </div>
      </form>
    </div>
    
    <!-- Output Section -->
    <div class="output-section">
      <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'gantt-tab')">Gantt Chart</button>
        <button class="tablinks" onclick="openTab(event, 'results-tab')">Calculation Results</button>
      </div>
      
      <div id="gantt-tab" class="tabcontent active">
        <div class="gantt-container">
          <div class="gantt-time-axis" id="gantt-time-axis"></div>
          <div class="gantt-chart" id="gantt-chart"></div>
        </div>
      </div>
      
      <div id="results-tab" class="tabcontent">
        <table id="results-table" class="results-table">
          <thead>
            <tr>
              <th>Job</th>
              <th>Arrival Time</th>
              <th>Burst Time</th>
              <th>Finish Time</th>
              <th>Turnaround Time</th>
              <th>Waiting Time</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
  // Event listener for algorithm selection
document.getElementById('algorithm').addEventListener('change', function() {
  const priorityColumns = document.querySelectorAll('.priority-column');
  const quantumGroup = document.getElementById('quantum-group');
  
  // Show the priority input only for priority algorithms
  if (this.value === 'priority-nonpreemptive' || this.value === 'priority-preemptive') {
    priorityColumns.forEach(col => col.style.display = 'table-cell');
  } else {
    priorityColumns.forEach(col => col.style.display = 'none');
  }
  
  // Show Time Quantum input for Round Robin only
  if (this.value === 'roundrobin') {
    quantumGroup.style.display = 'block';
  } else {
    quantumGroup.style.display = 'none';
  }
});

  // Handle adding a new process row
  document.getElementById('add-process').addEventListener('click', function() {
    const tableBody = document.getElementById('process-table').getElementsByTagName('tbody')[0];
    const newRow = document.createElement('tr');
    const algorithm = document.getElementById('algorithm').value;
    const priorityDisplay = (algorithm === 'priority-nonpreemptive' || algorithm === 'priority-preemptive') ? 'table-cell' : 'none';
    
    const processCount = tableBody.rows.length + 1;

    newRow.innerHTML = `
      <td>P${processCount}</td>
      <td><input type="number" name="arrival_time[]" min="0" value="0" required></td>
      <td><input type="number" name="burst_time[]" min="1" value="5" required></td>
      <td class="priority-column" style="display:${priorityDisplay};"><input type="number" name="priority[]" min="1" value="1" required></td>
    `;

    tableBody.appendChild(newRow);
  });

  // Handle removing the last process row
  document.getElementById('remove-process').addEventListener('click', function() {
    const tableBody = document.getElementById('process-table').getElementsByTagName('tbody')[0];
    
    // Only remove the last row if there's more than one row
    if (tableBody.rows.length > 1) {
      tableBody.deleteRow(tableBody.rows.length - 1);
    }
  });

  function openTab(evt, tabName) {
    const tabcontents = document.querySelectorAll('.tabcontent');
    tabcontents.forEach(content => content.style.display = "none");
    const tablinks = document.querySelectorAll('.tablinks');
    tablinks.forEach(link => link.classList.remove("active"));
    
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");
  }

  document.getElementById('scheduler-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const processRows = document.getElementById('process-table').getElementsByTagName('tbody')[0].rows;
    const processes = [];
    
    for (let i = 0; i < processRows.length; i++) {
      const arrivalTime = parseInt(processRows[i].cells[1].querySelector('input').value);
      const burstTime = parseInt(processRows[i].cells[2].querySelector('input').value);
      const priority = parseInt(processRows[i].cells[3].querySelector('input').value);
      
      processes.push({ name: `P${i + 1}`, arrival_time: arrivalTime, burst_time: burstTime, priority: priority });
    }

    const algorithm = document.getElementById('algorithm').value;
    let ganttChart = [];
    let results = [];
    let totalWaitingTime = 0;
    let totalTurnaroundTime = 0;

    switch (algorithm) {
      case 'fcfs':
        ({ ganttChart, results } = fcfs(processes));
        break;
      case 'sjf-nonpreemptive':
        ({ ganttChart, results } = sjfNonPreemptive(processes));
        break;
      case 'srtf':
        ({ ganttChart, results } = srtf(processes));
        break;
      case 'roundrobin':
        const quantum = parseInt(document.getElementById('quantum').value);
        ({ ganttChart, results } = roundRobin(processes, quantum));
        break;
      case 'priority-nonpreemptive':
        ({ ganttChart, results } = priorityNonPreemptive(processes));
        break;
      case 'priority-preemptive':
        ({ ganttChart, results } = priorityPreemptive(processes));
        break;
      default:
        alert("Please select an algorithm.");
        return;
    }

    results.forEach(result => {
      totalWaitingTime += result.waitingTime;
      totalTurnaroundTime += result.turnaroundTime;
    });

    // Calculate averages
    const numProcesses = results.length;
    const avgWaitingTime = totalWaitingTime / numProcesses;
    const avgTurnaroundTime = totalTurnaroundTime / numProcesses;

    displayGanttChart(ganttChart);
    displayResults(results, avgWaitingTime, avgTurnaroundTime, totalWaitingTime, totalTurnaroundTime);
  });

  function displayGanttChart(ganttChart) {
  const ganttChartElement = document.getElementById('gantt-chart');
  const ganttTimeAxis = document.getElementById('gantt-time-axis');
  const totalTime = ganttChart[ganttChart.length - 1].end;

  // Clear previous data
  ganttChartElement.innerHTML = '';
  ganttTimeAxis.innerHTML = '';

  // Set relative positioning and 100% total width
  ganttChartElement.style.position = 'relative';
  ganttChartElement.style.display = 'flex';

  // Generate time axis markers
  for (let i = 0; i <= totalTime; i++) {
    const timeMarker = document.createElement('div');
    timeMarker.className = 'time-marker';
    timeMarker.innerText = i;
    timeMarker.style.flex = '1';
    timeMarker.style.textAlign = 'center';
    ganttTimeAxis.appendChild(timeMarker);
  }

  // Generate Gantt blocks
  ganttChart.forEach(block => {
    const ganttBlock = document.createElement('div');
    ganttBlock.className = 'gantt-block active';

    const blockDuration = block.end - block.start;
    const leftPercent = (block.start / totalTime) * 100;
    const widthPercent = (blockDuration / totalTime) * 100;

    ganttBlock.style.position = 'absolute';
    ganttBlock.style.left = `${leftPercent}%`;
    ganttBlock.style.width = `${widthPercent}%`;
    ganttBlock.style.height = '40px';
    ganttBlock.style.backgroundColor = 'blue'; // Green color for the block
    ganttBlock.style.border = '1px solid #333';
    ganttBlock.style.color = 'white';
    ganttBlock.style.display = 'flex';
    ganttBlock.style.alignItems = 'center';
    ganttBlock.style.justifyContent = 'space-between';
    ganttBlock.style.padding = '0 10px';
    ganttBlock.style.boxSizing = 'border-box';

    ganttBlock.innerHTML = `
      <span class="process">${block.process}</span>
      <span class="time">${block.start} - ${block.end}</span>
    `;

    ganttChartElement.appendChild(ganttBlock);
  });
}

  function displayResults(results, avgWaitingTime, avgTurnaroundTime, totalWaitingTime, totalTurnaroundTime) {
    const resultsTable = document.getElementById('results-table').getElementsByTagName('tbody')[0];
    resultsTable.innerHTML = '';

    results.forEach(result => {
      const row = resultsTable.insertRow();
      row.innerHTML = `
        <td>${result.process}</td>
        <td>${result.arrivalTime}</td>
        <td>${result.burstTime}</td>
        <td>${result.finishTime}</td>
        <td>${result.turnaroundTime}</td>
        <td>${result.waitingTime}</td>
      `;
    });

    // Remove any previously displayed averages before adding the new ones
    const avgDiv = document.getElementById('average-div');
    if (avgDiv) {
      avgDiv.remove();
    }

    // Create and append averages
    const avgContainer = document.createElement('div');
    avgContainer.id = 'average-div';
    avgContainer.innerHTML = `
      <p>Average Waiting Time: ${totalWaitingTime} / ${results.length} = ${avgWaitingTime.toFixed(2)}</p>
      <p>Average Turnaround Time: ${totalTurnaroundTime} / ${results.length} = ${avgTurnaroundTime.toFixed(2)}</p>
    `;
    document.getElementById('results-tab').appendChild(avgContainer);
  }

  // Scheduling Algorithms Functions
  function fcfs(processes) {
  let currentTime = 0;
  let ganttChart = [];
  let results = [];

  // Sort by arrival time
  processes.sort((a, b) => a.arrival_time - b.arrival_time);

  processes.forEach(process => {
    // Wait if the process hasn't arrived yet
    if (currentTime < process.arrival_time) {
      currentTime = process.arrival_time;
    }

    const startTime = currentTime;
    const finishTime = startTime + process.burst_time;
    const turnaroundTime = finishTime - process.arrival_time;
    const waitingTime = turnaroundTime - process.burst_time;

    ganttChart.push({ process: process.name, start: startTime, end: finishTime });
    currentTime = finishTime;

    results.push({
      process: process.name,
      arrivalTime: process.arrival_time,
      burstTime: process.burst_time,
      finishTime: finishTime,
      turnaroundTime: turnaroundTime,
      waitingTime: waitingTime
    });
  });

  return { ganttChart, results };
}

function srtf(processes) {
  let remainingProcesses = [...processes].map(p => ({
    ...p,
    remainingBurstTime: p.burst_time,
    isCompleted: false,
  }));

  let currentTime = 0;
  let ganttChart = [];
  let results = [];
  let lastProcess = null;

  while (remainingProcesses.some(p => !p.isCompleted)) {
    // Get processes that have arrived and are not completed
    let readyProcesses = remainingProcesses.filter(p => p.arrival_time <= currentTime && !p.isCompleted);

    if (readyProcesses.length === 0) {
      currentTime++;
      continue;
    }

    // Pick the process with the shortest remaining time
    readyProcesses.sort((a, b) => a.remainingBurstTime - b.remainingBurstTime);
    let currentProcess = readyProcesses[0];

    // Gantt chart: check if process changed
    if (!lastProcess || lastProcess.name !== currentProcess.name) {
      // End the previous process slice
      if (ganttChart.length > 0 && ganttChart[ganttChart.length - 1].end === undefined) {
        ganttChart[ganttChart.length - 1].end = currentTime;
      }
      ganttChart.push({ process: currentProcess.name, start: currentTime });
    }

    // Execute for 1 time unit
    currentProcess.remainingBurstTime--;
    currentTime++;
    lastProcess = currentProcess;

    // If process finishes
    if (currentProcess.remainingBurstTime === 0) {
      currentProcess.isCompleted = true;
      currentProcess.finishTime = currentTime;
      currentProcess.turnaroundTime = currentTime - currentProcess.arrival_time;
      currentProcess.waitingTime = currentProcess.turnaroundTime - currentProcess.burst_time;

      results.push({
        process: currentProcess.name,
        arrivalTime: currentProcess.arrival_time,
        burstTime: currentProcess.burst_time,
        finishTime: currentProcess.finishTime,
        turnaroundTime: currentProcess.turnaroundTime,
        waitingTime: currentProcess.waitingTime
      });

      // End current Gantt slice
      ganttChart[ganttChart.length - 1].end = currentTime;
    }
  }

  return { ganttChart, results };
}


function srtf(processes) {
  let remainingProcesses = processes.map(p => ({
    ...p,
    remainingBurstTime: p.burst_time,
    finishTime: 0,
    turnaroundTime: 0,
    waitingTime: 0,
    started: false
  }));

  let currentTime = 0;
  let ganttChart = [];
  let results = [];
  let lastProcess = null;

  while (
    remainingProcesses.some(p => p.remainingBurstTime > 0)
  ) {
    let readyQueue = remainingProcesses.filter(p => p.arrival_time <= currentTime && p.remainingBurstTime > 0);

    if (readyQueue.length === 0) {
      currentTime++;
      continue;
    }

    // SRTF logic: pick process with smallest remaining burst
    readyQueue.sort((a, b) => a.remainingBurstTime - b.remainingBurstTime);
    let currentProcess = readyQueue[0];

    // Gantt Chart logic
    if (!lastProcess || lastProcess.name !== currentProcess.name) {
      if (ganttChart.length > 0 && ganttChart[ganttChart.length - 1].end === currentTime) {
        ganttChart[ganttChart.length - 1].end = currentTime;
      }
      ganttChart.push({ process: currentProcess.name, start: currentTime, end: currentTime + 1 });
    } else {
      ganttChart[ganttChart.length - 1].end++;
    }

    currentProcess.remainingBurstTime--;
    currentTime++;
    lastProcess = currentProcess;

    // If process is finished
    if (currentProcess.remainingBurstTime === 0) {
      currentProcess.finishTime = currentTime;
      currentProcess.turnaroundTime = currentProcess.finishTime - currentProcess.arrival_time;
      currentProcess.waitingTime = currentProcess.turnaroundTime - currentProcess.burst_time;

      results.push({
        process: currentProcess.name,
        arrivalTime: currentProcess.arrival_time,
        burstTime: currentProcess.burst_time,
        finishTime: currentProcess.finishTime,
        turnaroundTime: currentProcess.turnaroundTime,
        waitingTime: currentProcess.waitingTime
      });
    }
  }

  return { ganttChart, results };
}



  // Round Robin Scheduling Function
  function roundRobin(processes, quantum) {
  // Create deep copies of processes to avoid modifying originals
  let remainingProcesses = processes.map(p => ({
    ...p,
    remainingBurstTime: p.burst_time,
    firstExecution: false,
    finishTime: 0
  }));
  
  let ganttChart = [];
  let results = [];
  let currentTime = 0;
  let queue = [];
  
  // Sort processes by arrival time initially
  remainingProcesses.sort((a, b) => a.arrival_time - b.arrival_time);
  
  // Continue until all processes are completed
  while (remainingProcesses.length > 0 || queue.length > 0) {
    // Add newly arrived processes to the queue
    let newArrivals = remainingProcesses.filter(p => p.arrival_time <= currentTime);
    if (newArrivals.length > 0) {
      queue.push(...newArrivals);
      // Remove these processes from remaining list
      remainingProcesses = remainingProcesses.filter(p => p.arrival_time > currentTime);
    }
    
    // If queue is empty but we still have processes to arrive
    if (queue.length === 0 && remainingProcesses.length > 0) {
      currentTime = remainingProcesses[0].arrival_time;
      continue;
    }
    
    // Process the first item in the queue
    if (queue.length > 0) {
      let currentProcess = queue.shift();
      
      // Calculate execution time for this quantum
      let executionTime = Math.min(quantum, currentProcess.remainingBurstTime);
      
      // Add to Gantt chart
      ganttChart.push({
        process: currentProcess.name,
        start: currentTime,
        end: currentTime + executionTime
      });
      
      // Update process state
      currentProcess.remainingBurstTime -= executionTime;
      currentTime += executionTime;
      
      // If process is complete
      if (currentProcess.remainingBurstTime <= 0) {
        currentProcess.finishTime = currentTime;
        results.push({
          process: currentProcess.name,
          arrivalTime: currentProcess.arrival_time,
          burstTime: currentProcess.burst_time,
          finishTime: currentProcess.finishTime,
          turnaroundTime: currentProcess.finishTime - currentProcess.arrival_time,
          waitingTime: (currentProcess.finishTime - currentProcess.arrival_time) - currentProcess.burst_time
        });
      } else {
        // Add newly arrived processes before re-adding current process
        let newArrivalsWhileExecuting = remainingProcesses.filter(p => p.arrival_time <= currentTime);
        queue.push(...newArrivalsWhileExecuting);
        remainingProcesses = remainingProcesses.filter(p => p.arrival_time > currentTime);
        
        // Add current process back to queue for another round
        queue.push(currentProcess);
      }
    }
  }
  
  // Merge adjacent Gantt chart blocks for same process
  let mergedGantt = [];
  for (let i = 0; i < ganttChart.length; i++) {
    if (i === 0 || ganttChart[i].process !== ganttChart[i-1].process) {
      mergedGantt.push({...ganttChart[i]});
    } else {
      mergedGantt[mergedGantt.length-1].end = ganttChart[i].end;
    }
  }
  
  return { ganttChart: mergedGantt, results };
}


  function priorityPreemptive(processes) {
  // Create a deep copy of processes to work with
  let remainingProcesses = processes.map(p => ({...p, remainingTime: p.burst_time}));
  let currentTime = 0;
  let ganttChart = [];
  let completed = [];
  let currentProcess = null;
  let lastProcess = null;

  // Continue until all processes are completed
  while (remainingProcesses.length > 0) {
    // Find all processes that have arrived by the current time
    let availableProcesses = remainingProcesses.filter(p => p.arrival_time <= currentTime);
    
    // If no processes are available, advance time to the next arrival
    if (availableProcesses.length === 0) {
      let nextArrival = Math.min(...remainingProcesses.map(p => p.arrival_time));
      currentTime = nextArrival;
      continue;
    }
    
    // Sort available processes by priority (lower value = higher priority)
    availableProcesses.sort((a, b) => a.priority - b.priority);
    
    // Select the highest priority process
    currentProcess = availableProcesses[0];
    
    // If we're switching to a different process, add a new Gantt chart entry
    if (lastProcess !== currentProcess.name) {
      ganttChart.push({
        process: currentProcess.name,
        start: currentTime,
        end: currentTime + 1 // We'll update this end time later
      });
    } else {
      // Update the end time of the current Gantt chart entry
      ganttChart[ganttChart.length - 1].end = currentTime + 1;
    }
    
    // Update last process
    lastProcess = currentProcess.name;
    
    // Execute for 1 time unit
    currentProcess.remainingTime--;
    currentTime++;
    
    // Check if the process has completed
    if (currentProcess.remainingTime === 0) {
      // Remove the completed process from the remaining processes
      remainingProcesses = remainingProcesses.filter(p => p !== currentProcess);
      
      // Store completion data
      completed.push({
        process: currentProcess.name,
        arrivalTime: currentProcess.arrival_time,
        burstTime: currentProcess.burst_time,
        finishTime: currentTime,
        turnaroundTime: currentTime - currentProcess.arrival_time,
        waitingTime: currentTime - currentProcess.arrival_time - currentProcess.burst_time
      });
    }
  }
  
  // Merge adjacent Gantt chart entries for the same process
  let mergedGantt = [];
  for (let i = 0; i < ganttChart.length; i++) {
    if (i === 0 || ganttChart[i].process !== ganttChart[i-1].process) {
      mergedGantt.push({...ganttChart[i]});
    } else {
      mergedGantt[mergedGantt.length-1].end = ganttChart[i].end;
    }
  }
  
  return { ganttChart: mergedGantt, results: completed };
}
  
  // Initialize the app by hiding the priority column
  document.querySelectorAll('.priority-column').forEach(el => el.style.display = 'none');
  
  // Show first tab by default
  document.getElementById('gantt-tab').style.display = 'block';
</script>
</body>
</html>