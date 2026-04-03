<?php
// Handle confirmed logout
if (isset($_POST['confirm_logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle cancel
if (isset($_POST['cancel_logout'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <link rel="icon" type="image/png" href="pics/svt logo.png">
    <style>

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --bg: #0f0f11; --card: #18181c; --border: #2a2a30; --text: #e8e8ed; --muted: #7a7a8a; --red: #e8524a; --red-dim: #3a1a18; --red-hover: #F7CAC9; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        body::before { content: ''; position: fixed; inset: 0; background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px); background-size: 40px 40px; opacity: 0.3; pointer-events: none; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 2.5rem 2.5rem 2rem; width: 100%; max-width: 400px; position: relative; animation: slideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) both; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px) scale(0.97); } to   { opacity: 1; transform: translateY(0) scale(1); }}
        .card::before { content: ''; position: absolute; top: -1px; left: 20%; right: 20%; height: 2px; background: var(--red); border-radius: 0 0 4px 4px; }
        .icon-wrap { width: 56px; height: 56px; border-radius: 14px; background: var(--red-dim); border: 1px solid #5a2520; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; }
        .icon-wrap svg { width: 26px; height: 26px; color: var(--red); }
        h1 { font-family: 'DM Serif Display', serif; font-size: 1.55rem; font-weight: 400; letter-spacing: -0.01em; margin-bottom: 0.5rem; font-style: bold; }
        p { color: var(--muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 2rem; }
        .actions { display: flex; gap: 0.75rem; }
        button { flex: 1; padding: 0.7rem 1rem; border-radius: 10px; font-family: 'DM Sans', sans-serif; font-size: 0.88rem; font-weight: 500; cursor: pointer; transition: all 0.18s ease; border: 1px solid transparent; }
        .btn-cancel { background: transparent; border-color: var(--border); color: var(--muted); }
        .btn-cancel:hover { background: #222228; color: var(--text); border-color: #3a3a44; }
        .btn-logout { background: var(--red); color: #fff; }
        .btn-logout:hover { background: var(--red-hover); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(232, 82, 74, 0.35); }
        .btn-logout:active { transform: translateY(0); }
    </style>
</head>
<body>

<div class="card">
    <div class="icon-wrap">
        <!-- Logout icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 15l3-3m0 0l-3-3m3 3H9" />
        </svg>
    </div>

    <h1>Log out?</h1>
    <p>Are you sure you want to end your session? You will need to sign in again to continue.</p>

    <form method="POST" class="actions">
        <button type="submit" name="cancel_logout" class="btn-cancel">Cancel</button>
        <button type="submit" name="confirm_logout" class="btn-logout">Yes, log out</button>
    </form>
</div>

</body>
</html>