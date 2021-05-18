<?php
// Horgásznapló feltöltési oldala: Egy kép feltöltése, vízterület megnevezése, hal fajtája, hal súlya, fogás dátuma.
// A képet a felhasználói egyedi mappán belül a „fogasok” mappába kell másolni.
// A könyv adatait mentsük adatbázisba, és a felhasználó egyedi kulcsát is, mint idegen kulcsot mentsük el a fogasok táblába.
?>

<?php
if (!AUTH) {
    return;
}
$sql = "SELECT * FROM {$db}.fogasok        
        WHERE fogasok.userid = '{$_SESSION['felhasznalo']['id']}'";
$query = $dbcon->query($sql);
print $dbcon->error;
/*
print "<pre>";
while ($galeria = $query->fetch_assoc()) {
    print_r($galeria);
}
print "</pre>";
*/
?>

<h1>Horgásznapló</h1>

<div class="form-group">
    <button type="button" id="new_gallery_modal_btn" class="btn btn-primary">Új naplóbejegyzés</button>
</div>

<?php while ($galeria = $query->fetch_assoc()): ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Fotó</th>
            <th scope="col">Vízterület</th>
            <th scope="col">Halfajta</th>
            <th scope="col">Halsúly</th>
            <th scope="col">Fogásdátum</th>
            <th scope="col">Feltöltés ideje</th>
            <th scope="col">Törlés</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row"><?=$galeria['id']?></th>
            <td><img class="thumbnail" src="<?= 'media/' . $galeria['userid'] . '/fogasok/' . $galeria['img'] ?>"
                     alt="<?= $galeria['vizterulet'] . ', ' . $galeria['halfajta'] . ', ' . $galeria['halsuly'] . ', ' . $galeria['fogasdatum'] ?>"
                     title="<?= $galeria['vizterulet'] . ', ' . $galeria['halfajta'] . ', ' . $galeria['halsuly'] . ', ' . $galeria['fogasdatum'] ?>"></td>
            <td><?= $galeria['vizterulet'] ?></td>
            <td><?= $galeria['halfajta'] ?></td>
            <td><?= $galeria['halsuly'] ?></td>
            <td><?= $galeria['fogasdatum'] ?></td>
            <td><?= $galeria['feltoltesdatum'] ?></td>
            <td><a class="deleteRow" id="<?=$galeria['id']?>">Törlés</a></td>
        </tr>
        </tbody>
    </table>
<?php endwhile; ?>

<div id="new_gallery_form_modal" title="Új galéria létrehozása">
    <form id="new_gallery_form" enctype="multipart/form-data" action="controller/horgasznaplo.php" method="post">
        <div class="form-group">
            <label for="vizterulet">Vízterület neve</label>
            <input type="text" name="vizterulet" id="vizterulet" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="halfajta">Hal fajtája</label>
            <input type="text" name="halfajta" id="halfajta" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="halsuly">Hal súlya</label>
            <input type="number" name="halsuly" id="halsuly" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fogasdatum">Fogás dátuma</label>
            <input type="date" name="fogasdatum" id="fogasdatum" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="img">Fotó</label>
            <input type="file" name="img" id="img" required>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Mentés</button>
        </div>
    </form>
</div>

<div class="position-fixed top-0 start-0 end-0" style="z-index:9999">
    <div class="container">
        <div id="flash-message" class="alert fade d-none">&nbsp;</div>
        <div id="ajax-flash-message" class="alert fade d-none"></div>
    </div>
</div>

<script>
    $(function () {
        $("#new_gallery_form_modal").dialog({
            autoOpen: false,
            modal: true,
            width: 600
        });
        $("#new_gallery_modal_btn").on('click', function () {
            $("#new_gallery_form_modal").dialog('open');
        })

        $("#new_gallery_form").on('submit', function (event) {
            event.preventDefault();
            let form = $('#new_gallery_form')[0];
            let data = new FormData(form);
            $.ajax({
                url: 'controller/horgasznaplo.php',
                method: 'POST',
                data: data,
                dataType: 'JSON',
                processData: false,
                contentType: false
            }).done(function (parameter) {
                $("#new_gallery_form_modal").dialog('close');
                $("#flash-message").text(parameter.uzenet);
                $("#flash-message").removeClass();
                $("#flash-message").addClass(parameter.class);
            }).fail(function (parameter) {
                $("#new_gallery_form_modal").dialog('close');
                $("#flash-message").text(parameter.uzenet);
                $("#flash-message").removeClass();
                $("#flash-message").addClass(parameter.class);
            }).always(function() {
                setTimeout(function() {
                    $("#flash-message").removeClass("show");
                    location.reload();
                }, 500);
            });
        })

        $('.deleteRow').on( "click", function(e) {
            e.preventDefault();
            const id = $(this).attr('id');
            const data = 'id=' + id;
            $.ajax({
                url: 'controller/delete_ajax.php',
                method: 'POST',
                dataType: 'JSON',
                data: data
            }).done(function(parameter){
                let row = '#'+id + ' .hide-on-delete';
                setTimeout(function () {
                        $(row)
                            .animate({ paddingTop: 0, paddingBottom: 0 }, 250)
                            .wrapInner('<div>')
                            .children()
                            .slideUp(500, function() { $(row).remove(); });
                    }, 250
                );

                $("#flash-message").text(parameter.uzenet);
                $("#flash-message").removeClass();
                $("#flash-message").addClass(parameter.class);

                setTimeout(function() {
                    $("#flash-message").removeClass("show");
                    location.reload();
                }, 500);
                setTimeout(function() {
                    $("#flash-message").addClass("d-none");
                }, 3000);
            }).fail(function(){
                alert('Hiba a keres soran');
            });

        })
    });
</script>