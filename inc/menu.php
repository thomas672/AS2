<nav class="sidebar" id="menuSidebar">
  <ul>
    <li>MENU</li>
    <?php
    function setPageActive($page, $pageactive){
      if($page == $pageactive){
        echo 'active';
      }
    }
    ?>
    <li><a href="accueil" class="<?php setPageActive($_GET['p'], 'accueil'); ?> "  alt="Accueil"><i class="fa fa-home"></i> Accueil</a></li>
    <li><a href="mesmodules" class="<?php setPageActive($_GET['p'], 'mesmodules'); ?> <?php setPageActive($_GET['p'], 'ajoutermodules'); ?>"  alt="Page de mes modules"><i class="fa fa-archive"></i> Mes modules</a></li>
    <li><a href="etudiants" class="<?php setPageActive($_GET['p'], 'etudiants'); ?> <?php setPageActive($_GET['p'], 'ajouteretudiant'); ?> <?php setPageActive($_GET['p'], 'ajouteretudiant2'); ?> <?php setPageActive($_GET['p'], 'modifieretudiant'); ?>"  alt="Page des étudiants"><i class="fa fa-graduation-cap"></i> Les étudiants</a></li>
    <li><a href="utilisateurs" class="<?php setPageActive($_GET['p'], 'utilisateurs'); ?> <?php setPageActive($_GET['p'], 'ajouterutilisateur'); ?> <?php setPageActive($_GET['p'], 'modifierutilisateur'); ?>"  alt="Page de gestion des utilisateurs"><i class="fa fa-users"></i> Les utilisateurs</a></li>
    <li><a href="trombi" class="<?php setPageActive($_GET['p'], 'trombi'); ?> "  alt="Trombinoscope des etudiants"><i class="fa fa-file-image-o"></i> Trombinoscope</a></li>
    <li><a href="contact" class="<?php setPageActive($_GET['p'], 'contact'); ?> "  alt="Contact"><i class="fa fa-envelope-o"></i> Contact</a></li>
    <li><a href="monprofil" class="<?php setPageActive($_GET['p'], 'monprofil'); ?> "  alt="Mon profil"><i class="fa fa-cog"></i> Mon profil</a></li>
    <li><a href="deconnexion" class="<?php setPageActive($_GET['p'], 'deconnexion'); ?> "  alt="Deconnexion"><i class="fa fa-power-off"></i> Deconnexion</a></li>
  </ul>
</nav>

