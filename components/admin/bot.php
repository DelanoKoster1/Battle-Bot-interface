<form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
    <div class="col-4">
        <input class="form-control mt-3" placeholder="Robot Naam" name="botName" id="botName" type="text">
        <input class="form-control mt-3" placeholder="Omschrijving" name="botDiscription" id="botDiscription" type="text">
        <input class="form-control mt-3" placeholder="Mac adres" name="macAddress" id="macAddress" type="text">
        <input class="form-control mt-3" placeholder="Board" name="board" id="board" type="text">
        <input class="form-control mt-3" placeholder="Interface" name="interface" id="interface" type="text">
        <label class="mt-3" for="botPic">Foto Bijvoegen</label>
        <input id="botPic" name="botPic" class="form-control mt-3" type="file">
        <input class="btn btn-danger mt-3" type="submit" id="submitBot" name="bot" value="Bot toevoegen">
    </div>
</form>