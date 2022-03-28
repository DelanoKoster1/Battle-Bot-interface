<?php
    $robots = getAllRobots();

?>
<div class="container">
    <h4 style="text-align: center; margin: 10px; padding: 10px;">Start game</h4>

    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-group">
                <div id="bot">
                    <span>Selecteer een bot</span>
                    <select id="selectBot" class="form-select" name="selectBot">
                        <option value="" disabled selected>Kies een bot</option>
                        <option value="all">All bots</option>
                        <?php
                        foreach ($robots as $bot) {
                            echo '<option value="'. $bot['macAddress'] .'">' . $bot['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <i>Bij het selecteren van een keuze wordt er een nieuw menu getoond.</i>
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
                
                <!-- <input class="btn btn-danger mt-3" type="submit" name="robotEventAnnuleren" value="Annuleren"> -->

            
        </div>
    </form>

    <h4 style="text-align: center; margin: 10px; padding: 10px;">Huidige games</h4>

    <div class="games">
    </div>
    
</div>

<script src="../assets/js/functions.js"></script>
<script src="../assets/js/game.js"></script>