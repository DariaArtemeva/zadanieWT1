<?php
session_start();
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $name = $_SESSION['name'];
  $surname = $_SESSION['surname'];
  echo '<p><a role="button" class="d-flex align-items-center justify-content-center" href="admin.php">admin</a><br>';
 echo '<a role="button" class="d-flex align-items-center justify-content-center secondary" href="logout.php">Odhlasenie</a></p>';
}
else{
    echo '<h2><a role="button" href="index1.php" class="d-flex align-items-center justify-content-center ">log in pomocou google</a></h1>';
}

require_once('config.php');
try{
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $queryy="SELECT person.name, person.surname, COUNT(*) as first_places
    FROM placement
    JOIN person ON placement.person_id = person.id
    WHERE placement.placing = 1
    GROUP BY person.name,person.surname
    ORDER BY first_places DESC
    LIMIT 10";
    
 $query="SELECT * 
    FROM person AS u
       , games  AS d
       ,placement AS x
    WHERE u.id = d.id AND u.id = x.person_id";
   $stmt1 = $db->query($queryy); 
   $resultss = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $db->query($query); 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch(PDOException $e){
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content ="width-device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
<link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>


<body>
    <div class="container-md">
        <h1>Zadanie 1</h1>
       
        <main>
        <p>Meno: <?php echo $name?> 
        <br>
        Priezvisko: <?php echo $surname?></p>
</main>
        <table class="table" id="oh">
        <thead>
             <tr><td>Meno</td><td>Priezvisko</td><td>Miesto</td><td>Rok</td><td>Typ</td><td>Disciplina</td></tr><!--Mesto Narodenia</td><td>Krajina Narodenia</td><td>Den smrti</td><td>Mesto smrti</td><td>Krajina smrti</td></tr> -->
</thead>
<tbody>
    <?php 

    foreach($results as $result){
echo "<tr><td>" . $result["name"] ."</a></td><td>". $result["surname"] .  "</td><td>". $result["city"] ."</td><td>". $result["year"] ."</td><td>". $result["type"]."</td><td>". $result["discipline"]."</td></tr>";
    }

    

    ?>
    </tbody>
    </table>
    <br><br>
    <h1>10 najuspesnejsich olympionikov</h1>
<table class="table" id="oh2">
    <thead>
    </td><td>Meno</td><td>Priezvisko</td><td>Pocet Prvych miest</td></tr>
    </thead>
    <tbody>
    <?php 
    foreach($resultss as $resultt){
echo "<tr><td>" . $resultt["name"] ."</td><td>". $resultt["surname"] ."</td><td>".$resultt["first_places"]."</td></tr>";
    }
    ?>
</tbody>
</table>


    <script>
    $(document).ready(function () {
    $('#oh').DataTable();
});
    </script>
    <script>
    $(document).ready(function () {
    $('#oh2').DataTable();
});
    </script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>


</body>
</html>

