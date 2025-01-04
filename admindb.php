<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}


$servername = "127.0.0.1";
$username = "root";  
$password = "";      
$dbname = "maindb";  


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['create'])) {
    $playerid = $_POST['playerid'];
    $pName = $_POST['pName'];
    $pRole = $_POST['pRole'];
    $ptnumber = $_POST['ptnumber'];
    $contry = $_POST['contry'];
    $date = $_POST['date'];
    $Contract = $_POST['Contract'];
    $image = $_POST['image'];

    
    $sql = "INSERT INTO `playerinfo` (`playerid`, `pName`, `pRole`, `ptnumber`, `contry`, `date`, `Contract`, `image`)
            VALUES ('$playerid', '$pName', '$pRole', '$ptnumber', '$contry', '$date', '$Contract', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>New player created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
    }
}


if (isset($_POST['delete'])) {
    $playerid = $_POST['playerid_delete'];

    
    $check_sql = "SELECT * FROM `playerinfo` WHERE `playerid` = '$playerid'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        
        $sql = "DELETE FROM `playerinfo` WHERE `playerid` = '$playerid'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success text-center'>Player deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center'>Player ID not found!</div>";
    }
}


$sql = "SELECT * FROM `playerinfo`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            
            <a href="userhome.php" class="btn btn-primary">Home</a>
        </div>
    </nav>

    <div class="container mt-4">

        
        <h1 class="text-center">Manage Players</h1>

    
        <div class="card mt-4">
            <div class="card-header">
                <h2>Create a Player</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="admindb.php">
                    <div class="mb-3">
                        <label for="playerid" class="form-label">Player ID:</label>
                        <input type="text" name="playerid" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="pName" class="form-label">Player Name:</label>
                        <input type="text" name="pName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="pRole" class="form-label">Player Role:</label>
                        <input type="text" name="pRole" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="ptnumber" class="form-label">Player Number:</label>
                        <input type="number" name="ptnumber" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="contry" class="form-label">Country:</label>
                        <input type="text" name="contry" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date (YYYY-MM-DD):</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="Contract" class="form-label">Contract:</label>
                        <input type="text" name="Contract" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image Filename:</label>
                        <input type="text" name="image" class="form-control" required>
                    </div>

                    <button type="submit" name="create" class="btn btn-primary">Create Player</button>
                </form>
            </div>
        </div>

        
        <div class="card mt-4">
            <div class="card-header">
                <h2>Delete a Player</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="admindb.php">
                    <div class="mb-3">
                        <label for="playerid_delete" class="form-label">Enter Player ID to Delete:</label>
                        <input type="number" name="playerid_delete" class="form-control" required>
                    </div>

                    <button type="submit" name="delete" class="btn btn-danger">Delete Player</button>
                </form>
            </div>
        </div>

        
        <div class="card mt-4">
            <div class="card-header">
                <h2>Player List</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Player ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Number</th>
                            <th>Country</th>
                            <th>Contract</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr id="player-<?php echo $row['playerid']; ?>">
                                    <td><?php echo $row['playerid']; ?></td>
                                    <td><?php echo $row['pName']; ?></td>
                                    <td><?php echo $row['pRole']; ?></td>
                                    <td><?php echo $row['ptnumber']; ?></td>
                                    <td><?php echo $row['contry']; ?></td>
                                    <td><?php echo $row['Contract']; ?></td>
                                    <td><?php echo $row['image']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No players found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
