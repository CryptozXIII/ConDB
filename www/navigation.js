console.log("✅ navigation.js wurde geladen:", window.location.pathname);

document.addEventListener("DOMContentLoaded", function () {
  console.log("✅ navigation.js aktiv auf:", window.location.pathname);

  // doppelt einfügen verhindern
  if (document.getElementById("globalNav")) return;

  const nav = document.createElement("nav");
  nav.id = "globalNav";
  nav.style.cssText = `
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #eee;
    border-top: 1px solid #ccc;
    display: flex;
    justify-content: space-around;
    padding: 10px 0;
    z-index: 999;
  `;

  nav.innerHTML = `
    <button onclick="location.href='ConDB_Shop.html'">🛒 Shop</button>
    <button onclick="location.href='ConDB_Historie.html'">📋 Historie</button>
    <button onclick="location.href='ConDB_Inventar.html'">📦 Inventar</button>
  `;

  document.body.appendChild(nav);
});
