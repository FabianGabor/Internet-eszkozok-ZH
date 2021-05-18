<?php
// Főoldal regisztrálási lehetőség. A látogató a nevét, email címét és jelszavát (ismétléssel) adja meg, minden bemenő mezőt ki kell tölteni.
?>

<form action="controller/register.php" method="post" id="formRegister">
    <h1>Regisztráció</h1>
    <p>A kötelező mezők <abbr title="Kötelező">*</abbr> szimbólummal vannak jelölve.</p>

    <div class="form-group row">
        <label for="Vezetéknév" class="col-sm-2 col-form-label">Vezetéknév <abbr title="Kötelező" aria-label="Kötelező">*</abbr></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="vezeteknev" placeholder="Vezetéknév" name="vezeteknev" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="keresztnev" class="col-sm-2 col-form-label">Keresztnév <abbr title="Kötelező" aria-label="Kötelező">*</abbr></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="keresztnev" placeholder="Keresztnév" name="keresztnev" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">E-mail cím <abbr title="Kötelező"
                                                                            aria-label="Kötelező">*</abbr></label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="E-mail cím" name="email" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="jelszo" class="col-sm-2 col-form-label">Jelszó <abbr title="Kötelező" aria-label="Kötelező">*</abbr></label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="jelszo" placeholder="Jelszó" name="jelszo">
        </div>
    </div>

    <div class="form-group row">
        <label for="jelszo_ujra" class="col-sm-2 col-form-label">Jelszó újra <abbr title="Kötelező"
                                                                                   aria-label="Kötelező">*</abbr></label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="jelszo_ujra" placeholder="Jelszó újra" name="jelszo_ujra">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            <input required type="checkbox" name="gdpr" placeholder="GDPR nyilatkozatot elolvastam, elfogadom">
            <label for="gdpr">
                GDPR nyilatkozatot elolvastam, elfogadom <abbr title="Kötelező" aria-label="Kötelező">*</abbr>
            </label>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-success">Elküld</button>
        </div>
    </div>
</form>


<script>
    $(function () {
        $('#formRegister').submit(function (e) {
            console.log("Kuldes");
            $.ajax({
                url: 'controller/register_ajax.php',
                method: 'POST',
                dataType: 'JSON',
                data: $('#formRegister').serialize()
            }).done(function (parameter) {
                $("#flash-message").text(parameter.uzenet);
                $("#flash-message").removeClass();
                $("#flash-message").addClass(parameter.class);

                setTimeout(function () {
                    $("#flash-message").removeClass("show");
                }, 2000);
                setTimeout(function () {
                    $("#flash-message").addClass("d-none");
                }, 3000);
            }).fail(function () {
                alert('Hiba a keres soran');
            }).always(function () {
            });
            e.preventDefault();
        })
    });
</script>