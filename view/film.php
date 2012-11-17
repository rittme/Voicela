            <img src="<?php echo site_url("img/voicela.jpg");?>"/>
                <div class="navbar">
                  <div class="navbar-inner">
                    <ul class="nav">
                      <li><a href="<?php echo site_url("films") ?>"><i class="icon-arrow-left"></i></a></li>
                      <li class="divider-vertical"></li>
                      <li><a href="<?php echo site_url();?>">People</a></li>
                      <li class="divider-vertical"></li>
                      <li class="active"><a href="<?php echo site_url("films");?>">Films</a></li>
                    </ul>
                  </div>
            </div>
            
            <div class="page-header">

            <h2><?php echo utf8_encode($film["titre"]); ?></h2>
            <table class="table .table-striped">
             <tr>
                <th>Réalisateur : </th><td><?php echo $film["realisateur"]; ?></td>
            </tr>
            <tr>
                <th>Genre : </th><td><?php echo $film["genre"]; ?></td>
            </tr>
            <tr>
                <th>Date de Sortie : </th><td><?php echo date("d/m/Y",strtotime($film["date_sortie"])); ?></td>
             </tr>
            </table>
            </div>
