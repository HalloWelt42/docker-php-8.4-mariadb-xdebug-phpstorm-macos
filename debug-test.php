<?php
/**
 * Xdebug Testdatei
 *
 * 1. Breakpoint auf eine Zeile setzen (Klick auf Zeilennummer)
 * 2. PHPStorm: Telefon-Icon aktivieren
 * 3. http://localhost:8080/debug-test.php aufrufen
 */

// =============================================================================
// Einfache Variablen - Breakpoint hier setzen
// =============================================================================
$name = "Test";
$zahl = 42;
$aktiv = true;

// =============================================================================
// Array - im Debugger aufklappen
// =============================================================================
$benutzer = [
    'id' => 1,
    'name' => 'Max Mustermann',
    'email' => 'max@example.com',
    'rollen' => ['admin', 'editor', 'user'],
    'einstellungen' => [
        'sprache' => 'de',
        'theme' => 'dark',
        'benachrichtigungen' => true
    ]
];

// =============================================================================
// Schleife - Step Over (F8) testen
// =============================================================================
$summe = 0;
for ($i = 1; $i <= 5; $i++) {
    $summe += $i;  // Breakpoint hier: beobachte $i und $summe
}

// =============================================================================
// Funktion - Step Into (F7) testen
// =============================================================================
function berechneRabatt(float $preis, int $prozent): float
{
    $rabatt = $preis * ($prozent / 100);  // Breakpoint hier setzen
    $endpreis = $preis - $rabatt;
    return $endpreis;
}

$originalPreis = 99.99;
$endPreis = berechneRabatt($originalPreis, 20);  // F7 um reinzuspringen

// =============================================================================
// Klasse - Objektinspektion testen
// =============================================================================
class Produkt
{
    public function __construct(
        public int $id,
        public string $name,
        public float $preis,
        private array $tags = []
    ) {}

    public function addTag(string $tag): void
    {
        $this->tags[] = $tag;  // Breakpoint: $this inspizieren
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}

$produkt = new Produkt(1, 'Laptop', 999.99);
$produkt->addTag('elektronik');
$produkt->addTag('computer');

// =============================================================================
// Exception - Exception Breakpoints testen
// =============================================================================
function riskanteOperation(int $wert): int
{
    if ($wert < 0) {
        throw new InvalidArgumentException("Wert darf nicht negativ sein: $wert");
    }
    return $wert * 2;
}

try {
    $ergebnis1 = riskanteOperation(10);
    // $ergebnis2 = riskanteOperation(-5);  // Auskommentieren um Exception zu testen
} catch (InvalidArgumentException $e) {
    $fehler = $e->getMessage();
}

// =============================================================================
// Ausgabe
// =============================================================================
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Xdebug Test</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        h1 { color: #667eea; }
        pre { background: #f3f4f6; padding: 1rem; border-radius: 8px; overflow-x: auto; }
        .success { color: #10b981; font-weight: bold; }
    </style>
</head>
<body>
<h1>🐛 Xdebug Test</h1>

<p class="success">✅ Wenn du das siehst, hat der Debugger nicht gestoppt – hast du einen Breakpoint gesetzt?</p>

<h2>Variablen</h2>
<pre><?php
    echo "Name: $name\n";
    echo "Zahl: $zahl\n";
    echo "Aktiv: " . ($aktiv ? 'ja' : 'nein') . "\n";
    echo "Summe (1-5): $summe\n";
    echo "Endpreis: " . number_format($endPreis, 2) . " €\n";
    ?></pre>

<h2>Benutzer-Array</h2>
<pre><?php print_r($benutzer); ?></pre>

<h2>Produkt-Objekt</h2>
<pre><?php
    echo "ID: {$produkt->id}\n";
    echo "Name: {$produkt->name}\n";
    echo "Preis: {$produkt->preis} €\n";
    echo "Tags: " . implode(', ', $produkt->getTags()) . "\n";
    ?></pre>

<h2>Debug-Tipps</h2>
<ul>
    <li><strong>F7</strong> - Step Into (in Funktion springen)</li>
    <li><strong>F8</strong> - Step Over (nächste Zeile)</li>
    <li><strong>F9</strong> - Resume (bis zum nächsten Breakpoint)</li>
    <li><strong>Alt+F8</strong> - Evaluate Expression (Ausdruck auswerten)</li>
</ul>
</body>
</html>