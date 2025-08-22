<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        // Redirection vers /dashboard
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    } else {
        $message = "❌ Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/login.css">
  <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>
<body class="relative min-h-screen flex items-center justify-center bg-[var(--color-bg)] overflow-hidden">

  <!-- Fond terminal animé -->
  <div id="terminal-bg" class="absolute inset-0 text-[var(--color-cyan)] font-mono text-xs pointer-events-none"></div>

  <!-- Carte login -->
  <div id="login-root" class="relative z-10 w-full max-w-md"></div>

  <script type="text/babel">
    const logs = [
      "Initializing system...",
      "Loading modules...",
      "Connecting to database...",
      "Authenticating user...",
      "Error: Unknown token",
      "Warning: Session expired",
      "Info: New connection",
      "Debug: Payload received",
      "System check OK",
      "Deploying assets..."
    ];

    function TerminalBackground() {
      const [lines, setLines] = React.useState([]);

      React.useEffect(() => {
        const interval = setInterval(() => {
          setLines(prev => {
            const nextLine = logs[Math.floor(Math.random() * logs.length)];
            const newLines = [...prev, nextLine];
            if (newLines.length > 50) newLines.shift();
            return newLines;
          });
        }, 200);
        return () => clearInterval(interval);
      }, []);

      return (
        <pre className="absolute inset-0 p-4 overflow-hidden pointer-events-none animate-fade-in">
          {lines.map((line, i) => <div key={i} className="animate-typewriter">{line}</div>)}
        </pre>
      );
    }

    function LoginForm() {
      const [showPassword, setShowPassword] = React.useState(false);
      const [loading, setLoading] = React.useState(false);
      const [error, setError] = React.useState("<?php echo addslashes($message); ?>");

      return (
        <div className="bg-[var(--color-white)] shadow-2xl rounded-2xl p-10 animate-pop scale-90">
          <h2 className="text-4xl font-[var(--font-heading)] text-center text-[var(--color-black)] mb-6 glitch">
            🔐 Connexion
          </h2>

          {error && <p className="error-message mb-4 text-center">{error}</p>}

          <form method="post" onSubmit={() => setLoading(true)} className="space-y-4">
            <input 
              type="text" 
              name="username" 
              placeholder="Nom d'utilisateur" 
              required 
              className="input-field"
            />

            <div className="relative">
              <input 
                type={showPassword ? "text" : "password"} 
                name="password" 
                placeholder="Mot de passe" 
                required 
                className="input-field pr-12"
              />
              {/* SVG œil animé */}
              <svg 
                onClick={() => setShowPassword(!showPassword)}
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" viewBox="0 0 24 24" 
                stroke="currentColor" 
                className="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 cursor-pointer text-[var(--color-black)] hover:text-[var(--color-cyan)] transition-all duration-300"
              >
                <circle cx="12" cy="12" r="3" className={showPassword ? "fill-[var(--color-cyan)] transition-all" : ""}/>
                <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
              </svg>
            </div>

            <button 
              type="submit" 
              className="btn-primary w-full flex justify-center items-center gap-2"
              disabled={loading}
            >
              {loading ? (
                <>
                  <span className="loader"></span> Connexion...
                </>
              ) : "Connexion"}
            </button>
          </form>

          <p className="text-sm text-[var(--color-black)] text-center mt-6">
            Pas encore de compte ? 
            <a href="register.php" className="link"> Inscription</a>
          </p>
        </div>
      );
    }

    ReactDOM.createRoot(document.getElementById("login-root")).render(<LoginForm />);
    ReactDOM.createRoot(document.getElementById("terminal-bg")).render(<TerminalBackground />);
  </script>
</body>
</html>
