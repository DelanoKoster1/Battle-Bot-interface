<?php
    $robots = getAllRobots();

?>
<div class="container">
    <h4 style="text-align: center; margin: 10px; padding: 10px;">Start game</h4>

    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-group">
                <div id="bot">
                    <span class="d-block">Selecteer een bot</span>
                    <i>Bij het selecteren van een keuze wordt er een nieuw menu getoond.</i>
                    <select id="selectBot" class="form-select mb-3" size="8" multiple name="selectBot[]">
                        <option value="" disabled>Kies een bot</option>
                        <option value="all">All bots</option>
                        <?php
                        foreach ($robots as $bot) {
                            echo '<option value="'. $bot['macAddress'] .'">' . $bot['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <button id="selectBotBtn" type="button" name="submitotBtn" class="btn btn-primary">submit</button>
                    <button id="deleteGames" type="button" name="delete_games" class="btn btn-danger">Verwijder spellen</button>
                    <button id="sos" type="button" name="sos" class="btn btn-danger">Emergency stop</button>
                    
                </div>

                <div class="d-none" id="game">
                    <span>Selecteer een game</span>
                    <select id="selectGame" class="form-select" name="selectGame">
                        <option value="" disabled selected>Kies een game</option>
                       <option value="maze">Maze</option>
                       <option value="race">Race</option>
                       <option value="butler">Butler</option>
                    </select>
                </div>            
        </div>
    </form>

    <h4 style="text-align: center; margin: 10px; padding: 10px;">Huidige games</h4>

    <div id="gameContainer" class="games">
    </div>
    
</div>

<script src="../assets/js/functions.js"></script>
<script src="../assets/js/game.js"></script>