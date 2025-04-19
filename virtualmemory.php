<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Memory Management</title>
    <style>
        /* Reset some basic styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            letter-spacing: 1px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .panel {
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .input-section {
            flex: 1;
            min-width: 300px;
        }

        .main-section {
            flex: 2;
            min-width: 650px;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin: 8px 0 15px;
        }

        .input-group input[type="number"] {
            flex-grow: 1;
            margin: 0;
            border-radius: 50px 0 0 50px;
            border-right: none;
        }

        .input-group select {
            width: 80px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 0 50px 50px 0;
            color: black;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            color: white;
            font-size: 16px;
        }

        select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 16px;
            outline: none;
        }

        select:focus, input:focus {
            outline: none;
            border-color: white;
        }

        input[type="number"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            width: 100%;
            margin: 10px 0;
            padding: 12px 25px;
            font-size: 16px;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid white;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: white;
            color: #1e3c72;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }

        .file-section, .memory-section {
            margin-bottom: 25px;
        }

        .category-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .panel-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .file-table, .memory-blocks {
            flex: 1;
            min-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background-color: rgba(255, 255, 255, 0.1);
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn-row {
            display: flex;
            gap: 10px;
        }

        .btn-row .button {
            flex: 1;
        }

        #partitionInputs {
            margin-top: 15px;
        }

        .partition-input {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .partition-input label {
            margin: 0 10px 0 0;
            min-width: 90px;
        }

        .partition-input .input-group {
            flex-grow: 1;
            margin: 0;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .panel-container {
                flex-direction: column;
            }
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

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin-left: 10px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.1);
            transition: .4s;
            border-radius: 34px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: rgba(255, 255, 255, 0.3);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        /* Memory Status Section */
        .memory-status {
            margin-top: 30px;
            width: 100%;
        }

        .status-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .status-row {
            display: flex;
            margin-bottom: 15px;
            gap: 20px;
        }

        .status-card {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .status-label {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 8px;
        }

        .status-value {
            font-size: 24px;
            font-weight: bold;
        }

        .status-unit {
            font-size: 14px;
            margin-left: 5px;
        }

        .progress-container {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            height: 20px;
            margin-top: 15px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #00C9FF, #92FE9D);
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .utilization-label {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 12px;
        }

        .memory-visualization {
            width: 100%;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .memory-block {
            position: absolute;
            height: 100%;
            top: 0;
            transition: all 0.5s ease;
        }

        .memory-block.allocated {
            background: linear-gradient(90deg, #92FE9D, #00C9FF);
        }

        .memory-block.free {
            background: rgba(255, 255, 255, 0.1);
        }

        .memory-block-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
            font-weight: bold;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
        }

        .legend {
            display: flex;
            margin-top: 10px;
            justify-content: center;
            gap: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 12px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 4px;
            margin-right: 5px;
        }

        .legend-color.allocated {
            background: linear-gradient(90deg, #92FE9D, #00C9FF);
        }

        .legend-color.free {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Virtual Memory Management</h1>
    </div>
    <a href="index.php" class="home-link" id="homeBtn">Home</a>
    <div class="container">
        <div class="panel input-section">
            <div class="section-title">Input Section</div>
            
            <div class="file-section">
                <div class="category-title">FILE</div>
                <label>File Size:</label>
                <div class="input-group">
                    <input type="number" id="fileSize" min="1" placeholder="Enter file size">
                    <select id="fileSizeUnit">
                        <option value="KB">KB</option>
                        <option value="MB" selected>MB</option>
                    </select>
                </div>
                
                <button class="button" id="addFileBtn">Add File</button>
            </div>
            
            <div class="memory-section">
                <div class="category-title">MEMORY</div>
                <label>Memory Size:</label>
                <div class="input-group">
                    <input type="number" id="memorySize" value="100" min="1">
                    <select id="memorySizeUnit">
                        <option value="KB">KB</option>
                        <option value="MB" selected>MB</option>
                    </select>
                </div>
                
                <label>Number of Partitions:</label>
                <input type="number" id="partitionCount" value="3" min="1">
                
                <div id="partitionInputs">
                    <!-- Partition size inputs will be generated here -->
                </div>
                
                <div class="btn-row">
                    <button class="button" id="allocateBtn">Allocate Files</button>
                    <button class="button" id="createPartitionsBtn">Create Partitions</button>
                </div>
            </div>
            
            
        </div>
        
        <div class="panel main-section">
            <div class="panel-container">
                <div class="file-table">
                    <div class="section-title">File Table</div>
                    <table id="fileTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>File Size</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>64</td>
                                <td>MB</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>20</td>
                                <td>MB</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>30</td>
                                <td>MB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="memory-blocks">
                    <div class="section-title">Memory Blocks</div>
                    <table id="memoryTable">
                        <thead>
                            <tr>
                                <th>Partition</th>
                                <th>Size</th>
                                <th>Unit</th>
                                <th>File ID</th>
                                <th>File Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>34</td>
                                <td>MB</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>33</td>
                                <td>MB</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>33</td>
                                <td>MB</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="memory-status">
                <div class="status-title">Memory Status</div>
                
                <div class="status-row">
                    <div class="status-card">
                        <div class="status-label">Total Memory</div>
                        <div class="status-value" id="totalMemory">100<span class="status-unit">MB</span></div>
                    </div>
                    
                    <div class="status-card">
                        <div class="status-label">Allocated Memory</div>
                        <div class="status-value" id="allocatedMemory">0<span class="status-unit">MB</span></div>
                    </div>
                    
                    <div class="status-card">
                        <div class="status-label">Free Memory</div>
                        <div class="status-value" id="freeMemory">100<span class="status-unit">MB</span></div>
                    </div>
                    
                    <div class="status-card">
                        <div class="status-label">Utilization</div>
                        <div class="status-value" id="utilizationPercent">0<span class="status-unit">%</span></div>
                    </div>
                </div>
                
                <div class="progress-container">
                    <div class="progress-bar" id="memoryUtilizationBar" style="width:0%;"></div>
                </div>
                <div class="utilization-label">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
                
                <div class="memory-visualization" id="memoryVisualization">
                    <!-- Memory blocks will be generated here -->
                </div>
                
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color allocated"></div>
                        <span>Allocated</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color free"></div>
                        <span>Free</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let fileCounter = 4; // Start at 4 since we already have 3 files
            const files = [
                { id: 1, size: 64, unit: "MB" },
                { id: 2, size: 20, unit: "MB" },
                { id: 3, size: 30, unit: "MB" }
            ];
            let partitions = [
                { id: 1, size: 34, unit: "MB", fileId: null, fileSize: null, fileUnit: null },
                { id: 2, size: 33, unit: "MB", fileId: null, fileSize: null, fileUnit: null },
                { id: 3, size: 33, unit: "MB", fileId: null, fileSize: null, fileUnit: null }
            ];
            let memorySize = 100;
            let memorySizeUnit = "MB";
            let partitionCount = 3;

            // Generate partition size input fields
            function generatePartitionInputs() {
                const partitionInputs = document.getElementById('partitionInputs');
                partitionInputs.innerHTML = '';
                
                const count = parseInt(document.getElementById('partitionCount').value) || 3;
                
                for (let i = 0; i < count; i++) {
                    const div = document.createElement('div');
                    div.className = 'partition-input';
                    
                    const label = document.createElement('label');
                    label.textContent = `Partition ${i + 1}:`;
                    
                    const inputGroup = document.createElement('div');
                    inputGroup.className = 'input-group';
                    
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.id = `partition-size-${i + 1}`;
                    input.min = '1';
                    input.placeholder = 'Size';
                    if (partitions[i]) {
                        input.value = partitions[i].size;
                    }
                    
                    const select = document.createElement('select');
                    select.id = `partition-unit-${i + 1}`;
                    
                    const kbOption = document.createElement('option');
                    kbOption.value = 'KB';
                    kbOption.textContent = 'KB';
                    
                    const mbOption = document.createElement('option');
                    mbOption.value = 'MB';
                    mbOption.textContent = 'MB';
                    mbOption.selected = true;
                    
                    if (partitions[i] && partitions[i].unit === 'KB') {
                        kbOption.selected = true;
                        mbOption.selected = false;
                    }
                    
                    select.appendChild(kbOption);
                    select.appendChild(mbOption);
                    
                    inputGroup.appendChild(input);
                    inputGroup.appendChild(select);
                    
                    div.appendChild(label);
                    div.appendChild(inputGroup);
                    partitionInputs.appendChild(div);
                }
            }

            // Convert size to KB for calculations
            function convertToKB(size, unit) {
                if (unit === "MB") {
                    return size * 1024;
                }
                return size;
            }

            // Convert size from KB to specified unit for display
            function convertFromKB(sizeInKB, toUnit) {
                if (toUnit === "MB") {
                    return sizeInKB / 1024;
                }
                return sizeInKB;
            }

            // Format number to 2 decimal places if needed
            function formatNumber(num) {
                return Math.round(num * 100) / 100;
            }

            // Initialize partitions with user input
            function createPartitions() {
                partitions = [];
                memorySize = parseInt(document.getElementById('memorySize').value) || 100;
                memorySizeUnit = document.getElementById('memorySizeUnit').value;
                partitionCount = parseInt(document.getElementById('partitionCount').value) || 3;
                
                let totalSizeKB = 0;
                const partitionParams = [];
                
                // Collect all partition sizes from inputs
                for (let i = 0; i < partitionCount; i++) {
                    const sizeInput = document.getElementById(`partition-size-${i + 1}`);
                    const unitSelect = document.getElementById(`partition-unit-${i + 1}`);
                    const size = parseInt(sizeInput?.value) || 0;
                    const unit = unitSelect?.value || "MB";
                    
                    const sizeKB = convertToKB(size, unit);
                    partitionParams.push({ size, unit });
                    totalSizeKB += sizeKB;
                }
                
                // Validate total size against memory size
                const memorySizeKB = convertToKB(memorySize, memorySizeUnit);
                if (totalSizeKB > memorySizeKB) {
                    alert(`Total partition size exceeds memory size. Please adjust partition sizes.`);
                    return;
                }
                
                // Create partitions with user-specified sizes
                for (let i = 0; i < partitionCount; i++) {
                    partitions.push({
                        id: i + 1,
                        size: partitionParams[i].size,
                        unit: partitionParams[i].unit,
                        fileId: null,
                        fileSize: null,
                        fileUnit: null
                    });
                }
                
                renderMemoryTable();
                updateMemoryStatus();
                renderMemoryVisualization();
                alert(`Created ${partitionCount} partitions successfully.`);
            }

            // Add a new file
            function addFile() {
                const fileSize = parseInt(document.getElementById('fileSize').value);
                const fileSizeUnit = document.getElementById('fileSizeUnit').value;
                
                if (!fileSize || fileSize <= 0) {
                    alert('Please enter a valid file size');
                    return;
                }
                
                files.push({
                    id: fileCounter++,
                    size: fileSize,
                    unit: fileSizeUnit
                });
                
                renderFileTable();
                document.getElementById('fileSize').value = '';
                alert(`Added file with ID ${fileCounter-1} and size ${fileSize}${fileSizeUnit}`);
            }

            // Allocate files to partitions using best fit algorithm
            function allocateFiles() {
                // Reset allocations
                partitions.forEach(p => {
                    p.fileId = null;
                    p.fileSize = null;
                    p.fileUnit = null;
                });
                
                // Convert partition sizes to KB for comparison
                const partitionSizesKB = partitions.map(p => ({
                    id: p.id,
                    sizeKB: convertToKB(p.size, p.unit),
                    originalSize: p.size,
                    originalUnit: p.unit
                }));
                
                // Sort files by ID (first-fit allocation order)
                const sortedFiles = [...files].sort((a, b) => a.id - b.id);
                
                // Try to allocate each file
                for (const file of sortedFiles) {
                    const fileSizeKB = convertToKB(file.size, file.unit);
                    
                    // Find best fit partition (smallest sufficient partition)
                    let bestFitIndex = -1;
                    let bestFitSize = Infinity;
                    
                    for (let i = 0; i < partitions.length; i++) {
                        const partition = partitions[i];
                        const partitionSizeKB = convertToKB(partition.size, partition.unit);
                        
                        if (partition.fileId === null && partitionSizeKB >= fileSizeKB && partitionSizeKB < bestFitSize) {
                            bestFitIndex = i;
                            bestFitSize = partitionSizeKB;
                        }
                    }
                    
                    // Allocate file if a suitable partition was found
                    if (bestFitIndex !== -1) {
                        partitions[bestFitIndex].fileId = file.id;
                        partitions[bestFitIndex].fileSize = file.size;
                        partitions[bestFitIndex].fileUnit = file.unit;
                    }
                }
                
                renderMemoryTable();
                updateMemoryStatus();
                renderMemoryVisualization();
                alert('Files allocated using best fit algorithm');
            }

            // Render the file table
            function renderFileTable() {
                const tbody = document.querySelector('#fileTable tbody');
                tbody.innerHTML = '';
                
                files.forEach(file => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${file.id}</td>
                        <td>${file.size}</td>
                        <td>${file.unit}</td>
                    `;
                    tbody.appendChild(row);
                });
            }

            // Render the memory table
            function renderMemoryTable() {
                const tbody = document.querySelector('#memoryTable tbody');
                tbody.innerHTML = '';
                
                partitions.forEach(partition => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${partition.id}</td>
                        <td>${partition.size}</td>
                        <td>${partition.unit}</td>
                        <td>${partition.fileId !== null ? partition.fileId : '-'}</td>
                        <td>${partition.fileId !== null ? partition.fileSize + partition.fileUnit : '-'}</td>
                    `;
                    tbody.appendChild(row);
                });
            }

            // Update memory status display
            function updateMemoryStatus() {
                const totalMemoryKB = convertToKB(memorySize, memorySizeUnit);
                
                // Calculate memory usage
                let allocatedMemoryKB = 0;
                let allocatedPartitions = 0;
                
                partitions.forEach(partition => {
                    if (partition.fileId !== null) {
                        allocatedMemoryKB += convertToKB(partition.size, partition.unit);
                        allocatedPartitions++;
                    }
                });
                
                const freeMemoryKB = totalMemoryKB - allocatedMemoryKB;
                const utilizationPercent = (allocatedMemoryKB / totalMemoryKB) * 100;
                
                // Update display based on preferred unit
                let allocatedMemoryDisplay, freeMemoryDisplay, totalMemoryDisplay;
                
                if (memorySizeUnit === "MB") {
                    totalMemoryDisplay = `${formatNumber(totalMemoryKB / 1024)}<span class="status-unit">MB</span>`;
                    allocatedMemoryDisplay = `${formatNumber(allocatedMemoryKB / 1024)}<span class="status-unit">MB</span>`;
                    freeMemoryDisplay = `${formatNumber(freeMemoryKB / 1024)}<span class="status-unit">MB</span>`;
                } else {
                    totalMemoryDisplay = `${formatNumber(totalMemoryKB)}<span class="status-unit">KB</span>`;
                    allocatedMemoryDisplay = `${formatNumber(allocatedMemoryKB)}<span class="status-unit">KB</span>`;
                    freeMemoryDisplay = `${formatNumber(freeMemoryKB)}<span class="status-unit">KB</span>`;
                }
                
                // Update the DOM
                document.getElementById('totalMemory').innerHTML = totalMemoryDisplay;
                document.getElementById('allocatedMemory').innerHTML = allocatedMemoryDisplay;
                document.getElementById('freeMemory').innerHTML = freeMemoryDisplay;
                document.getElementById('utilizationPercent').innerHTML = `${formatNumber(utilizationPercent)}<span class="status-unit">%</span>`;
                
                // Update utilization progress bar
                document.getElementById('memoryUtilizationBar').style.width = `${utilizationPercent}%`;
            }

            // Render memory blocks visualization
            function renderMemoryVisualization() {
                const container = document.getElementById('memoryVisualization');
                container.innerHTML = '';
                
                const totalMemoryKB = convertToKB(memorySize, memorySizeUnit);
                let currentPosition = 0;
                
                partitions.forEach(partition => {
                    const partitionSizeKB = convertToKB(partition.size, partition.unit);
                    const partitionWidth = (partitionSizeKB / totalMemoryKB) * 100;
                    
                    const block = document.createElement('div');
                    block.className = `memory-block ${partition.fileId !== null ? 'allocated' : 'free'}`;
                    block.style.left = `${currentPosition}%`;
                    block.style.width = `${partitionWidth}%`;
                    
                    const label = document.createElement('div');
                    label.className = 'memory-block-label';
                    
                    if (partition.fileId !== null) {
                        label.textContent = `F${partition.fileId}`;
                    } else {
                        label.textContent = `P${partition.id}`;
                    }
                    
                    block.appendChild(label);
                    container.appendChild(block);
                    
                    currentPosition += partitionWidth;
                });
            }

            // Event listeners
            document.getElementById('addFileBtn').addEventListener('click', addFile);
            document.getElementById('createPartitionsBtn').addEventListener('click', createPartitions);
            document.getElementById('allocateBtn').addEventListener('click', allocateFiles);
            document.getElementById('partitionCount').addEventListener('change', generatePartitionInputs);
            document.getElementById('homeBtn').addEventListener('click', function(e) {
                e.preventDefault();
                 window.location.href = 'index.php';
            });

            // Initialize the application
            generatePartitionInputs();
            renderFileTable();
            renderMemoryTable();
            updateMemoryStatus();
            renderMemoryVisualization();
        });
    </script>
</body>
</html>