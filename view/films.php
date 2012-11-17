
            <img src="<?php echo site_url("img/voicela.jpg");?>"/>
                <div class="navbar">
                  <div class="navbar-inner">
                    <ul class="nav">
                      <li><a href="<?php echo site_url();?>">People</a></li>
                      <li class="divider-vertical"></li>
                      <li class="active"><a href="<?php echo site_url("films");?>">Films</a></li>
                    </ul>
                  </div>
            </div>
            <div class="page-header">
              <h2>Nos films</h2>
            </div>
            <ul class="nav nav-tabs nav-stacked">
                <?php if(!empty($results)){
                    foreach($results as $r) {
                        echo "<li><a href='".site_url("film/".$r["idfilm"])."'>".utf8_encode($r["titre"])." (".date("d/m/Y",strtotime($r["date_sortie"])).")</a></li>";
                    }
                }  else {
                    echo "Aucun film enregistré.";
                } ?>
            </ul>
        