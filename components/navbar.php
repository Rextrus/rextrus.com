<?php
echo '
  <nav class="navbar navbar-inverse navbar-expand-lg navbar-dark" role="navigation">
    <div class="container">
        <img src="img/rextrus_avatar.png" width="21px" height="21px" alt="Rextrus" style="margin-right: 10px; margin-top: 2px;"><a class="navbar-brand" href="/"> Rextrus.com - quick links</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarItems" aria-controls="navbarItems" aria-expanded="false" aria-label="Toggle navigation" style="color: white;">
          <span class="navbar-toggler-icon"></span>
        </button>

      <div class="collapse navbar-collapse" id="navbarItems">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item ';
              if(isSet($currentSide) && $currentSide == "servers") {
                echo 'active';
              }
              echo '">
              <a class="nav-link" href="servers">servers</a>
            </li>
            <li class="nav-item ';
              if(isSet($currentSide) && $currentSide == "downloads") {
                echo 'active';
              }
              echo '">
              <a class="nav-link" href="downloads">downloads</a>
            </li>
            <li class="nav-item ';
              if(isSet($currentSide) && $currentSide == "timers") {
                echo 'active';
              }
              echo '">
              <a class="nav-link" href="timers">maps</a>
            </li>
            <li class="nav-item ';
              if(isSet($currentSide) && $currentSide == "login") {
                echo 'active';
              }
              echo '">
              <a class="nav-link" href="#">Login</a>
            </li>
        </ul>
      </div>
    </div>
  </nav>
';
?>

