<?php
require_once __DIR__ . '../../../vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch projects by status
$statuses = ['Upcoming', 'In Progress', 'Done'];
$projects = [];

foreach ($statuses as $status) {
    $stmt = $connection->prepare("SELECT * FROM clients WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $projects[$status] = $result->fetch_all(MYSQLI_ASSOC);
}

ob_start(); // Start output buffering
?>

<style>
    body { font-family: Arial, sans-serif; }
    .header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .header-logo {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-right: 16px;
    }
    h1 { text-align: center; flex: 1; margin: 0; }
    h2 { margin-top: 30px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
</style>

<div class="header">
    <img src="../assets/images/logo.png" class="header-logo" alt="Logo">
    <h1>BUILDTRACT- Project Report</h1>
</div>

<?php foreach ($projects as $status => $items): ?>
    <h2><?= htmlspecialchars($status) ?> Projects</h2>
    <?php if (!empty($items)): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $project): ?>
                    <tr>
                        <td><?= htmlspecialchars($project['name']) ?></td>
                        <td><?= htmlspecialchars($project['duration']) ?></td>
                        <td><?= htmlspecialchars($project['address']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No <?= strtolower($status) ?> projects.</p>
    <?php endif; ?>
<?php endforeach; ?>

<?php
$html = ob_get_clean(); // Get buffered HTML

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output("project_report.pdf", "I"); // 'I' to display in browser
?>
