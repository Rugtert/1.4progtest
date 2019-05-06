<?php include "./templates/header.php"; ?>
<?php 
    require "./functies/common.php";
    $Heeftnogleningen = sqlquery("SELECT Lid_nr,lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
                                JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
                                JOIN Boek on exemplaar.ISBN = Boek.isbn
                                WHERE lid_nr = $_GET[Lid_nr]");
    if (isset($Heeftnogleningen)){?>
        <div class="container">
        <div class="table-responsive">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-12">
                        <h2><b>Het lid heeft onderstaande boeken nog geleend! Weet je zeker dat je dit lid wilt verwijderen?</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Lidnummer</th>
                        <th>Boek nummer</th>
                        <th>Titel</th>
                        <th>ISBN</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // output data of each row
                    foreach ($Heeftnogleningen as $row) :
                ?>
                <tr>
                    <td><?php echo $row["Lid_nr"];?></td>
                    <td><?php echo $row["Boek_nr"]?></td>
                    <td><?php echo $row["Titel"]?></td>
                    <td><?php echo $row["ISBN"]?></td>
                </tr>
                <?php 
                    endforeach;
                ?>
                </tbody>
            </table>
            <form method="post">
            <a href="leden.php?>" class = "btn btn-primary mb-2">Annuleren</a>
            <input name="verwijderen" type="submit" value="verwijderen" class = "btn btn-danger">
            <?php if(isset($_POST['verwijderen'])){
                    $result = sqlquery("DELETE FROM lid WHERE lid_nr = $_GET[Lid_nr]");
                    die("<p class=\"text-center\">Lid verwijderd! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
            }?>
        </div>
    </div>
<?php
    }
    Else  {
        $result = sqlquery("DELETE FROM lid WHERE lid_nr = $_GET[Lid_nr]");
        die("<p class=\"text-center\">Lid verwijderd! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
    }
    
?>

<?php include "./templates/footer.php"; ?>