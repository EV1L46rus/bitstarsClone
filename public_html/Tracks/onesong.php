<?php  

$lasttime = '?'.rand();

for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
					foreach ($data as $count => $ksong) {
						foreach ($ksong as $key => $value){
							if ($key == 'id') $id = $value;
							if ($key == 'rash_img') {
								$number += 1;
								if ($value !== '') {
									$imgAudio = $id.'.'.$value.$lasttime;
								} else {
									$imgAudio = 'defoult.png'.$lasttime;
								}
							}
							if ($key == 'title') $title = $value;
							
							if ($key == 'name') $name = $value;
							
							if ($key =='rash_audio') $rashaudio = $value;
						}
						echo '
						
						<div class="song">
							<div class="song_mrgn">
								<h2>
									<div class="num">',$number,'</div>
									<img src="/img/play.png" alt="" class="play">
								</h2>
								<img src="/img/imgsongs/',$imgAudio,'" alt="">
								<div class="titles_songs">
								<h3>',$title,'</h3>
								<h4>',$name,'</h4>
								</div>
								<div class="genre">
									<div class="btn_genre">
										<h5>Hip-hop</h5>
									</div>
									<div class="btn_genre">
										<h5>Rap</h5>
									</div>
								</div>
							</div>
							<audio 
							src="/audio/',$id,'.',$rashaudio,'"
							controls
							data-id="',$id,'"
							class="audio">
								Аудио не поддерживается
							</audio>								
						</div>';
					}

?>