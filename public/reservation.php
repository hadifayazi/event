
<?php
require_once('./../src/db.php');
include('header.php');
session_start();

if (isset($_GET['idEvent'])) {
    $sql = "SELECT * FROM events WHERE idevent = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' =>$_GET['idEvent']]);
    $event = $stmt->fetch();
} else {
    header('location:index.php');
}




?>

<div class="">
    <div class="">
        <img src="https://placehold.jp/200x300.png">
    </div>
        <h1><?php echo $event['title']; ?></h1>
        <p><?php echo"Director: ". $event['director']; ?></p>
        <p><?php echo"Duration: ".$event['duration']."mins"; ?></p>
        <p><?php echo $event['desc']; ?></p><br>
</div>

<?php


$idEvent= $_GET['idEvent'];
$regiter_date = new DateTime();
$regiter_date = $regiter_date->format('Y-m-d H:i:s');

$query = "SELECT * FROM screening LEFT JOIN events ON screening.event_id = events.idevent WHERE events.idevent = :idEvent";
$st = $pdo->prepare($query);
$st->execute([':idEvent' => $idEvent]);
$screening = $st->fetchAll();

?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Auditorium</th>
      <th scope="col">Screening</th>
      <th scope="col">Price</th>
      <th scope="col">Number of seats</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <?php foreach ($screening as $screen) {?>
      <th scope="row"><?php echo $event['title'];?></th>
      <td><?php echo $screen['audit_id'];?></td>
      <td><?php echo $screen['screening_start'];?></td>
      <td><?php echo $screen['price'];?></td><br>
      <td>
        <form action="cart.php" method="post">
            <select name="ticket" id="">
            <?php
                $avilability = $screen['availibility'];
        for ($nb = 1; $nb <= $avilability && $nb <9; $nb++) { ?>
                <option value=<?php echo $nb ?>><?php echo $nb ?></option>
                                <?php } ?>
            </select>
            <input type="hidden" name="idScrenning" value="<?php echo $screen['idscreening']; ?>" />
            <button type="submit" class="btn btn-primary" name="add">Add to cart</button>
        </form>
      </td>
    
      <td></td>
    </tr>
   <?php } ?> 
  </tbody>
</table>






