            <img src="<?php echo site_url("img/voicela.jpg");?>"/>
                <div class="navbar">
                  <div class="navbar-inner">
                    <ul class="nav">
                      <li class="active"><a href="<?php echo site_url();?>">People</a></li>
                      <li class="divider-vertical"></li>
                      <li><a href="<?php echo site_url("films");?>">Films</a></li>
                    </ul>
                  </div>
            </div>
            <div class="page-header">
              <h2>Voici la liste de nos vips!</h2>
            </div>
            <ul class="nav nav-tabs nav-stacked">
                <?php if(!empty($results)){
                    foreach($results as $r) {
                        echo "<li><a href='".site_url("vip/".$r["idVIP"])."'>".utf8_encode($r["prenom"])." ".utf8_encode($r["nom"])."</a></li>";
                    }
                }  else {
                    echo "Aucun vip enregistré.";
                } ?>
            </ul>