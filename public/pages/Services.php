<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM services ORDER BY id ASC");
    $services = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lines = array_unique(array_filter([
            $row['line1'],
            $row['line2'],
            $row['line3'],
            $row['line4'],
            $row['line5']
        ]));
        $services[] = [
            'name' => $row['name'],
            'lines' => array_values($lines)
        ];
    }
} catch (PDOException $e) {
    echo "Erreur DB : " . $e->getMessage();
    $services = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Services | &lt;Alex²/&gt;</title>
    <link rel="icon" href="<?= BASE_URL ?>/Alex2logo.png" type="image/x-icon">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/variables.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='<?= BASE_URL ?>/asset/css/index.css'>
    
    <!-- React + Babel CDN -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <style>
      body {
        background-color: var(--color-white);
        color: var(--color-black);
      }
    </style>
</head>
<body>
<?php include __DIR__ . '/../../includes/header.php'; ?>

<section id="content" class="py-10">
  <script>
    window.SERVICES = <?= json_encode($services, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>;
  </script>

  <div id="services-root"></div>

  <script type="text/babel">
    const { useState, useEffect } = React;

    function TypingService({ name, lines }) {
      const [shownLines, setShownLines] = useState([]);
      const [lineIndex, setLineIndex] = useState(0);
      const [charIndex, setCharIndex] = useState(0);
      const [currentLine, setCurrentLine] = useState('');

      const uniqueLines = [...new Set(lines)];

      useEffect(() => {
        if (lineIndex >= uniqueLines.length) return;

        const current = uniqueLines[lineIndex];

        if (charIndex < current.length) {
          const timeout = setTimeout(() => {
            setCurrentLine(prev => prev + current.charAt(charIndex));
            setCharIndex(prev => prev + 1);
          }, 40);
          return () => clearTimeout(timeout);
        } else {
          const timeout = setTimeout(() => {
            setShownLines(prev => [...prev, currentLine]);
            setCurrentLine('');
            setCharIndex(0);
            setLineIndex(prev => prev + 1);
          }, 300);
          return () => clearTimeout(timeout);
        }
      }, [charIndex, lineIndex, currentLine]);

      return (
        <div className="bg-black text-green-400 font-mono rounded-lg shadow-xl min-h-[10rem]">
          <div className="flex items-center px-3 py-1.5 rounded-t-lg" style={{ backgroundColor: 'var(--color-hover-1)' }}>
            <div className="flex space-x-1.5 mr-3">
              <span className="w-3 h-3 bg-red-500 rounded-full"></span>
              <span className="w-3 h-3 bg-yellow-400 rounded-full"></span>
              <span className="w-3 h-3 bg-green-500 rounded-full"></span>
            </div>
            <span className="text-sm" style={{ color: 'var(--color-hover-4)' }}>{name} - Service</span>
          </div>
          <div className="p-4 text-sm space-y-1 min-h-[7rem]">
          {shownLines.map((line, i) => {
            const isFirst = i === 0;
            const isLast = i === shownLines.length - 1 && currentLine === '';
            const lineColor = (isFirst || isLast)
              ? 'var(--color-cyan)'
              : (line.trim() === 'DISPONIBLE' ? 'var(--color-hover-3)' : 'var(--color-green)');
            return (
              <div key={i} style={{ color: lineColor }}>
                {line}
              </div>
            );
          })}
          {currentLine && (
            <div style={{ color: (lineIndex === 0 || lineIndex === shownLines.length + 1) ? 'var(--color-cyan)' : 'var(--color-green)' }}>
              {currentLine}
            </div>
          )}

          </div>
        </div>
      );
    }

    function ServicesList() {
      const [services, setServices] = useState(window.SERVICES || []);

      return (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto p-4">
          {services.map((service, idx) => (
            <TypingService key={idx} name={service.name} lines={service.lines} />
          ))}
        </div>
      );
    }

    const root = ReactDOM.createRoot(document.getElementById('services-root'));
    root.render(<ServicesList />);
  </script>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
