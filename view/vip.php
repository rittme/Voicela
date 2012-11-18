            <img src="<?php echo site_url("img/voicela.jpg");?>"/>
                <div class="navbar">
                  <div class="navbar-inner">
                    <ul class="nav">
                      <li><a href="<?php echo site_url("") ?>"><i class="icon-arrow-left"></i></a></li>
                      <li class="divider-vertical"></li>
                      <li class="active"><a href="<?php echo site_url();?>">People</a></li>
                      <li class="divider-vertical"></li>
                      <li><a href="<?php echo site_url("films");?>">Films</a></li>
                    </ul>
                  </div>
            </div>
            
            <div class="page-header">
            <h2>
              <?php 
                    if(strtolower($vip["sexe"]) == "f") {
                      echo '<img src="'.site_url("img/femme.png").'" />';
                    } else {
                      echo '<img src="'.site_url("img/homme.png").'" />';
                    }

              ?>
              <?php echo utf8_encode($vip["prenom"]." ".$vip["nom"]); ?>
            </h2>
            </div>
            <h4><?php echo $vip["metier"]; ?></h4>
            <?php if(!empty($photo) && count($photo) > 0) : ?>
            
            <div id="myCarousel" class="carousel slide">
              <!-- Carousel items -->
              <div class="carousel-inner">
                <?php 
                $first = true;
                foreach($photo as $p){
                  echo '<div class="item ';
                  if($first){
                    echo "active";
                    $first = false;
                  }
                  echo '">
                    <img src="'.site_url("photo/".$p['idphoto']).'"/>
                      <div class="carousel-caption">
                        <h4>'.utf8_encode($p["lieu"]).' '.date("d/m/Y",strtotime($p["date_prise"])).'</h4>
                        <p>'.utf8_encode($p["description"]).'</p>
                      </div>
                  </div>';
                }
                ?>
              </div>
              <!-- Carousel nav -->
              <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
              <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
            <?php endif; ?> 
            <table class="table .table-striped">
              <?php if(!empty($vip["nom_jf"])):?>
               <tr>
                  <th>Nom de Jeune Fille : </th><td><?php echo $vip["nom_jf"]; ?></td>
              </tr>
              <?php endif; ?>
              <tr>
                  <th>Date de Naissance : </th><td><?php echo date("d/m/Y",strtotime($vip["date_naiss"])); ?></td>
              </tr>
              <?php if(!empty($vip["date_deces"])):?>
               <tr>
                  <th>Date du Décès : </th><td><?php echo date("d/m/Y",strtotime($vip["date_deces"])); ?></td>
              </tr>
              <?php endif; ?>
              <tr>
                  <th>Lieu de Naissance : </th><td><?php echo utf8_encode($vip["lieu_naiss"]); ?></td>
              </tr>
              <tr>
                  <th>Nationalité : </th><td><?php echo utf8_encode($vip["nationalite"]); ?></td>
              </tr>
              <?php 
              if(!empty($mariage) && count($mariage) > 0) {
                echo "<tr><th>";
                if(strtolower($vip["sexe"]) == "f") {
                  echo "Mari : ";
                } else {
                  echo "epouse : ";
                }
                echo "</th><td><a href='".site_url("vip/".$conjoint["idVIP"])."'>".utf8_encode($conjoint["prenom"]." ".$conjoint["nom"])." (".date("d/m/Y",strtotime($mariage[0]["date"])).")</a></td></tr>";
              }
            ?>
            </table>

            <?php 
              if(!empty($divorces) && count($divorces) > 0) {
                echo "<h4>Divorces</h4><ul class='divorce'>";
                for($i = 0; $i < count($divorces); $i++){
                  echo "<li class='btn btn-info'>";
                  if(strtolower($vip["sexe"]) == "f") {
                  echo "Ex-mari : ";
                  } else {
                    echo "Ex-épouse : ";
                  }
                  echo "<a href='".site_url("vip/".$conjoints_divorces[$i][0]["idVIP"])."'>".utf8_encode($conjoints_divorces[$i][0]["prenom"]." ".$conjoints_divorces[$i][0]["nom"])." (".date("d/m/Y",strtotime($divorces[$i]["date"]))." - ".date("d/m/Y",strtotime($divorces[$i]["date_fin"])).")</a>";
                  echo "</li>";
                }
                echo "</ul>";
              }
            ?>

            <?php 
              if(!empty($realisateur) && count($realisateur) > 0) {
                echo '<h3>Realisateur</h3><ul class="nav nav-tabs nav-stacked">';
                foreach($acteur as $r){
                        echo "<li><a href='".site_url("film/".$r["idfilm"])."'>".utf8_encode($r["titre"])." (".date("d/m/Y",strtotime($r["date_sortie"])).")</a></li>";
                }
                echo "</ul>";
              }

              if(!empty($acteur) && count($acteur) > 0) {
                
                echo '<h3>Acteur</h3><ul class="nav nav-tabs nav-stacked">';
                foreach($acteur as $r){
                        echo "<li><a href='".site_url("film/".$r["idfilm"])."'>".utf8_encode($r["titre"])." (".date("d/m/Y",strtotime($r["date_sortie"])).")</a></li>";
                }
                echo "</ul>";
              }
              ?>