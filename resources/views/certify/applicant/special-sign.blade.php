<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Scientific Symbols Table</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .wrapper {
      width: 90%;
      max-width: 1200px;
      background: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      width: calc(100% / 15);
      padding: 12px;
      font-size: 24px;
      border: 1px solid #ddd;
      cursor: pointer;
      transition: 0.2s;
      user-select: none;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    td:hover {
      background-color: #e0f7fa;
      font-weight: bold;
    }

    /* Toast styling */
    .toast {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #323232;
      color: #fff;
      padding: 10px 20px;
      border-radius: 6px;
      font-size: 16px;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease, bottom 0.3s ease;
      z-index: 999;
    }

    .toast.show {
      opacity: 1;
      bottom: 50px;
    }
  </style>
</head>
<body>

<div class="wrapper">
  <h1>Scientific & Mathematical Symbols</h1>
  <table>
    <tbody></tbody>
  </table>
</div>

<!-- Toast Element -->
<div id="toast" class="toast">Copied!</div>

<script>
  const symbols = [
    'α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο',
    'π','ρ','σ','τ','υ','φ','χ','ψ','ω',
    'Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ','Ν','Ξ','Ο',
    'Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω',
    '∞','→','←','↑','↓','∑','∏','∫','∂','∇','≠','≈','=','≡','∝',
    '<','>','≤','≥','±','√','∛','∜','⊥','‖','∠','∟','°','′','″',
    '∴','∵','∅','∈','∉','⊂','⊃','⊆','⊇','∪','∩','∧','∨','¬','∃',
    '∀','⇒','⇔','↔','⊕','⊗','ℏ','ħ','∞','∆',
    'm','kg','s','A','K','mol','cd','Ω','V','W','J',
    'N','Pa','Hz','T','lx','°C','°F','°K','L','mL','cm','mm','km','m²','m³','g','mg',
    'µg','atm','bar','eV','dB','rad'
  ];

  const tbody = document.querySelector("tbody");
  const toast = document.getElementById("toast");
  const columns = 15;

  // Function to show toast
  function showToast(message) {
    toast.textContent = message;
    toast.classList.add("show");
    setTimeout(() => {
      toast.classList.remove("show");
    }, 1500);
  }

  for (let i = 0; i < symbols.length; i += columns) {
    const row = document.createElement("tr");
    for (let j = 0; j < columns; j++) {
      const cell = document.createElement("td");
      const index = i + j;
      const symbol = symbols[index] || "";
      cell.textContent = symbol;

      // Click to copy
      cell.addEventListener("click", () => {
        if (!symbol) return;
        navigator.clipboard.writeText(symbol).then(() => {
          showToast(`Copied: ${symbol}`);
        }).catch(() => {
          showToast("Copy failed");
        });
      });

      row.appendChild(cell);
    }
    tbody.appendChild(row);
  }
</script>

</body>
</html>
