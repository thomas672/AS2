    <div class="content text-center">
        <div class="vertical-align">
            <div class="box-v-align">
                <img src="etc/logo.svg" width="180">
                <?php
                require 'actions/connexion.php';
                ?>
                <form action="index" method="post">
                    <div class="input">
                        <label for="email">Identifiants</label>
                        <input class="input-text" type="email" id="email" name="email" placeholder="exemple@univ-lorraine.fr" required>
                    </div>
                    <div class="input">
                        <label for="password">Mot de passe</label>
                        <input class="input-text" type="password" id="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required>
                    </div>
                    <div class="input">
                        <input type="submit" value="Se connecter" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
