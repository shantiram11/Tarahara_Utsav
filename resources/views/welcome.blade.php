<?php
// Simple Coming Soon / Utsav Landing Page – Mobile Optimized
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarahara Utsav 2025 – Coming Soon</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background: radial-gradient(circle at top, #1a1a2e, #0f0f1e 90%);
  color: #fff;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
  overflow: hidden;
  padding: 0 20px;
  justify-content: flex-start; /* align content from top */
}

h1 {
  font-size: 4rem;
  margin-top: 20vh; /* 20% of viewport height from top */
  margin-bottom: 250px;
  background: linear-gradient(90deg, #ff6f61, #e52e71, #9b59b6, #3498db);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: glow 2s ease-in-out infinite alternate;
}


@keyframes glow {
  from { text-shadow: 0 0 8px #ff6f61, 0 0 16px #e52e71; }
  to   { text-shadow: 0 0 16px #3498db, 0 0 32px #9b59b6; }
}

.countdown {
  font-size: 1.8rem;
  font-weight: bold;
  background: linear-gradient(90deg, #ff6f61, #f0f, #00f);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

footer.countdownx {
  font-size: 1.5rem;
  margin-top: 20px;
}

.circle {
  position: absolute;
  border-radius: 50%;
  opacity: 0.6;
  animation: floatUp 8s linear infinite;
}

.circle:nth-child(1) { animation-duration: 7s; }
.circle:nth-child(2) { animation-duration: 10s; }
.circle:nth-child(3) { animation-duration: 6s; }
.circle:nth-child(4) { animation-duration: 9s; }

@keyframes floatUp {
  from { transform: translateY(100vh); }
  to   { transform: translateY(-10vh); }
}

/* Mobile adjustments */
@media (max-width: 768px) {
  h1 {
    font-size: 2.8rem;
    margin-bottom: 200px;
  }

  .countdown {
    font-size: 1.4rem;
  }

  footer.countdownx {
    font-size: 1.2rem;
  }
}

@media (max-width: 480px) {
  h1 {
    font-size: 2rem;
    margin-bottom: 150px;
  }

  .countdown {
    font-size: 1.2rem;
  }

  footer.countdownx {
    font-size: 1rem;
  }
}
</style>
</head>
<body>

<h1>🎊 TARAHARA UTSAV 2025 🎊</h1>

<footer class="countdownx" id="countdownx">
  ✨ Event Starts At: <span class="countdown" id="countdown"></span> ✨
</footer>

<!-- Floating festive circles -->
<div class="circle" style="width:80px;height:80px;background:#ff6f61;left:10%;"></div>
<div class="circle" style="width:50px;height:50px;background:#e52e71;left:30%;"></div>
<div class="circle" style="width:70px;height:70px;background:#3498db;left:60%;"></div>
<div class="circle" style="width:40px;height:40px;background:#9b59b6;left:80%;"></div>

<script>
// Set event date (Year, Month-1, Day, Hour, Minute)
const eventDate = new Date("2025-12-27T18:00:00").getTime();
const countdownEl = document.getElementById("countdown");

const timer = setInterval(() => {
  const now = new Date().getTime();
  const distance = eventDate - now;

  if (distance < 0) {
    clearInterval(timer);
    countdownEl.innerHTML = "🎉 The Utsav Has Begun!";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  countdownEl.innerHTML = `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
}, 1000);
</script>

</body>
</html>