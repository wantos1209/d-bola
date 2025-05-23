<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel API Tester</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body {
      font-family: Arial, sans-serif;
      position: relative;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid black;
    }

    th, td {
      padding: 8px;
      text-align: left;
    }

    .checked {
      color: green;
      font-weight: bold;
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7); /* Black with transparency */
      color: white;
      display: none; /* Hidden by default */
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    /* Circular Loading Spinner */
    .loader {
      border: 8px solid #f3f3f3; /* Light grey */
      border-top: 8px solid #3498db; /* Blue */
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1.5s linear infinite;
    }

    .testForm {
      margin-top: 20px;
    }

    input {
      width: 350px
    }

    .label-endpoint {
     font-weight: 500;
     font-size: 15px
    }

    .needToFix {
      color: red;
    }

    .passed {
      color: green;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <h1>API Seamless Tester</h1>
  <a href="/docs" class="documentation-link">[Go back to Documentation]</a>
  <form id="testForm" class="testForm" action="/run-tests" method="POST">
    @csrf
    <label for="apiUrl">Your Domain:</label>
    <input type="url" id="apiUrl" name="apiUrl" placeholder="https://your-api-url.com/api" required>
    <span class="label-endpoint">/GetBalance etc.</span>
    <br><br>
    <label for="company_key">Your Company Key:</label>
    <input type="text" id="company_key" name="company_key" placeholder="42KLOS63DECA400C90569097B8056B5B" required>
    <br><br>
    <label for="username">Test Username:</label>
    <input type="text" id="username" name="username" placeholder="Player01" required>
    <br><br>

    <button type="submit">Submit</button>
  </form>

  <!-- Loading overlay with circular spinner -->
  <div id="loadingOverlay" class="loading-overlay">
    <div class="loader"></div> <!-- Circular spinner -->
  </div>

  <h3 class="needToFix">Need To Fix : 0</h3>

  <h3>REPORT : </h3>
  <table id="resultsTable">
    <thead>
      <tr>
        <th>Checked</th>
        <th>NO</th>
        <th>Method</th>
        <th>Test Description</th>
        <th>Request Body</th>
        <th>Your Response</th>
        <th>Correct Response</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <script>
    const form = document.getElementById("testForm");
    const resultsTable = document.getElementById("resultsTable").querySelector("tbody");
    const loadingOverlay = document.getElementById("loadingOverlay"); // Loading overlay element
    const countFailedDiv = document.querySelector('.needToFix'); // Elemen untuk menampilkan countFailed
  
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      resultsTable.innerHTML = ""; // Clear previous results
      loadingOverlay.style.display = "flex"; // Show loading overlay
  
      const formData = new FormData(form);
      const data = {
        username: formData.get("username"),
        company_key: formData.get("company_key"),
        apiUrl: formData.get("apiUrl"),
      };
  
      try {
        const response = await fetch("/run-tests", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
          body: JSON.stringify(data),
        });
  
        if (!response.ok) {
          throw new Error(`HTTP Error ${response.status}`);
        }
  
        const { results, webException, countFailed } = await response.json();
  
        // Hide loading overlay after response is received
        loadingOverlay.style.display = "none";
  
        // Display Web Exception if exists
        if (webException) {
          const exceptionRow = document.createElement("tr");
          exceptionRow.innerHTML = ` 
            <td colspan="7" style="color: red; font-weight: bold; text-align: center;">
              ${webException}
            </td>
          `;
          resultsTable.appendChild(exceptionRow);
        }
  
        // Display test results
        results.forEach((result) => {
          const row = document.createElement("tr");
          
          row.innerHTML = ` 
            <td class="${result.checked === "Passed" ? "passed" : "needToFix"}">
              ${result.checked}
            </td>
            <td>${result.no}</td>
            <td>${result.method}</td>
            <td>${result.testDescription}</td>
            <td>${result.requestBody}</td>
            <td>${result.yourResponse}</td>
            <td>${result.correctResponse}</td>
          `;
          resultsTable.appendChild(row);
        });
  
        // Update the countFailed in the .needToFix element
        if (countFailedDiv) {
          countFailedDiv.innerHTML = `Need To Fix : ${countFailed}`; // Update countFailed in HTML
        }
  
      } catch (error) {
        alert("Error running tests: " + error.message);
        loadingOverlay.style.display = "none"; // Hide loading if error occurs
      }
    });
  </script>
  
</body>
</html>
