<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB Hotel</title>
</head>
<body>

<?php
// Connessione al server
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "db_hotel";

// Connect
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn && $conn->connect_error) {
echo "Connection failed: " . $conn->connect_error;
} 

//Istanzio il mio Query Param
    if ($_GET['id']) {

// prepare and bind
        $stmt = $conn->prepare("SELECT * FROM `stanze` WHERE `id` = ?");
        $stmt->bind_param("i", $_GET['id']);

// set parameters and exec
        $stmt->execute();
        $result = $stmt->get_result();

// Ciclo con il While
        while($row = $result->fetch_assoc()) { ?>
            <div>
                <strong> ID: </strong><?= $row['id'] ?>
            </div>
            <div>
                <strong> Numero della Stanza: </strong><?= $row['room_number'] ?>
            </div>
            <div>
                <strong> Piano: </strong><?= $row['floor'] ?>
            </div>
            <div>
                <strong> Letti: </strong><?= $row['beds'] ?>
            </div>
        <?php
        }

//... Otherwise:
    } else {
?>
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>room_number</th>
        </tr>
    </thead>
    <tbody>
<?php
    $sql = "SELECT * FROM stanze";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
// output data of each row
        while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><a href="/DB/db-hotel/?id=<?= $row['id'] ?>"><?= $row['room_number'] ?></a></td>
            </tr>
        <?php }
    } elseif ($result) { ?>
        <tr>
            <td colspan="6">Nessun Risultato</td>
        </tr>
    <?php } else { ?>
        <tr>
            <td colspan="6">Errore nell selezione</td>
        </tr>
    <?php }
?>
</tbody>
</table>

<?php }
    $conn->close();
?>
</body>
</html>