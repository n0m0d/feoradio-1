<?php
	$file = $data['file'];
?>
<link href="/js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="/js/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>
<script type="text/javascript" src="/js/plupload/i18n/ru.js"></script>
<script type="text/javascript">
var xhr = null;
// Initialize the widget when the DOM is ready
$(function() {
    $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : "/admin/ajax/",
		multipart_params:{
			'ajax_action' : 'action_upload'
		},
        // Maximum file size
        max_file_size : '100mb',
        chunk_size: '1mb',
        // Specify what files to browse for
        filters : [],
        // Rename files by clicking on their titles
        rename: true,
		//unique_names: true,
        sortable: true,  // Sort files
        dragdrop: true, // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        // Views to activate
        views: {list: true,thumbs: true,active: 'thumbs'},
        flash_swf_url : '/js/plupload/Moxie.swf', // Flash settings
        silverlight_xap_url : '/js/plupload/Moxie.xap', // Silverlight settings
		uploaded: function(event, up){
			console.log(up.file); 
			var file = up.file;
			console.log(up.result.response); 
			var response = JSON.parse(up.result.response);
			console.log(response); 
			if(response.OK == 1){
				$('#uploaded-files table tbody').append('<tr><td><b>' + response.name + '</b><div>Полный путь: <a href="' + response.url + '" target="_blank">' + response.url + '</a></div></td><td><b>' + file.size + '</b></td><td><b>' + file.type + '</b></td></tr>');
			}
			else{
				$('#uploaded-files table tbody').append('<tr><td><b>' + response.name + '</b><div>ОШИБКА: <span>' + response.info + '</span></div></td><td><b>NaN</b></td><td><b>NaN</b></td></tr>');
			}
		},
		
		complete: function(uploader, files){
			//console.log(arguments); 
		}
    });
	
		$('#save').click(function(event){
		<?php 
		echo apply_filters('the_save_js_the_post_name', 'var post_name = $("#post-name").val();');
		?>
		
		<?php 
		echo apply_filters('the_save_js_the_content', 'if (tinymce.editors.length > 0) {var content = tinyMCE.get("editor-text").getContent();}');
		?>
		
		if($("#link").text() == '') {
			$("#link").text(toURL($("#post-name, #post-name-en").val()));
		}
		
		var send = {};
		send.post_id = $("#post_id").val();
		send.post_name_ru = post_name;
		send.post_status = ($('#post_status').prop("checked"))?1:0;
		if(content){send.post_content = content;}

		console.log(JSON.stringify(send));
		
		xhr = $.ajax({
			url : "/admin/ajax",
			type : "post",
			dataType: 'json',
			data : { "ajax_action" : "update_mediafile", "send" : send},
			beforeSend: function( jqXHR, settings ){ if(xhr != null){ xhr.abort();console.log('ajax is aborting');	} },
			complete: function(){ xhr = null; },
			success: function(data){
				console.log(data);
				
				history.replaceState({foo: 'bar'}, '', '/admin/files/?id='+data['post_id']);
				$('#post_id').val(data['post_id']);
				$('#post_date').text(data['post']['post_date']);
				$('#last-modified').text(data['post']['post_modified']);
				$('#post_status-text').text( (data['post']['post_status'] == 1)? 'Опубликовано': 'Неактивно' );
			}
		});
		
	});

});
</script><script>
<?php do_action('admin_script'); ?>
</script>

<?php if($file == 'new'): ?>
<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>Загрузка медиафайлов</h2>
<div id="wrap-main">
	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</div>
	<style>
		#uploaded-files {
			padding-top:20px;
		}
		#uploaded-files table{
			width:100%;
		}
	</style>
	<div id="uploaded-files">
		<table class="main-table">
				<thead>
			<tr>
				<td>Название файла</td>
				<td style="width:200px;">Размер</td>
				<td style="width:200px;">Тип</td>
			</tr>
		</thead>
		<tbody></tbody>
		</table>
	</div>
</div>
<?php else: 
$file_settings = json_decode($file['post_content'], true);

?>
<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>Редактировать медиафайл</h2>
<div id="wrap-main">
	<table class="page-table" width="100%">
	<tr>
		<td class="page-view" style="width:auto; padding-right:20px;">
		<input type="hidden" value="<?php echo (!is_array($file) and $file=='new')? 'new' :$file['post_id']; ?>" id="post_id" />
			<div class="postarea">
				<label><h3>Заголовок</h3></label>
				
				<?php 
				echo apply_filters('the_admin-name-ru', ((!is_array($file) and $file=='new')? '' : $file['post_name_ru']));
				?>			
				<div id="permalink"><strong>Постоянная ссылка:</strong> <?= $file_settings['url']; ?></div>
			</div>
			<div class="margintop30" id="editor">
			
			<?php 
			$m = explode('/', $file_settings['mime_type']);
			switch ($m[0]):
				case 'image' : {
					echo '<div><img src="'.$file_settings['url'].'" /></div>';
					break;
				}
				case 'audio' : {
					?>
					<link href="/css/audioplayer.css" rel="stylesheet" type="text/css" media="all" />
					<script src="/js/audioplayer.js"></script>
						<div>
							<audio src="<?= $file_settings['url']; ?>" preload="auto" controls></audio>
							<script>
								$( function()
								{
									$( 'audio' ).audioPlayer();
								});
							</script>
						</div>
					<?php 
					break;
				}
				
				case 'video' : {
					?>
					<link href="http://vjs.zencdn.net/5.9.2/video-js.css" rel="stylesheet">

					<!-- If you'd like to support IE8 -->
					<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
						<div>
							<video id="my-video" class="video-js" controls preload="auto" width="800px"
							data-setup="{}">
								<source src="<?= $file_settings['url']; ?>" type='video/mp4'>
								<p class="vjs-no-js">
								  To view this video please enable JavaScript, and consider upgrading to a web browser that
								  <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
								</p>
							  </video>

							  <script src="http://vjs.zencdn.net/5.9.2/video.js"></script>
						</div>
					<?php 
					break;
				}
				
				default : {
					if($file_settings['mime_type']=="application/pdf"){
						echo '<iframe src="'.$file_settings['url'].'" style="width:100%; height:600px;"></iframe>';
					} else {
					
					?>
			<div class="tabs">
				<?php 
				echo apply_filters('the_editor_tabs', '');
				?>
			</div>
			
			<div class="tabs-body">
				<?php 
				echo apply_filters('the_editor_content', ((!is_array($file) and $file=='new')? '' : $file['post_content']));
				?>
			</div>
					<?php
					}
				}
			
			endswitch;
			
			?>
			</div>
			<span class="log"></span>
		</td>
		<td style="width:260px;">
			<div class="right-block" id="page-controls">
				<div class="controls-header">Основные действия:</div>
				<div class="controls-body">
					<div class="controls-body-row">Статус: <strong id="post_status-text"><?= (($file['post_status'] == 1)? "Опубликовано " : "Неактивно"); ?></strong><div class="switch demo3"><input id="post_status" type="checkbox" <?= (($file['post_status'] == 1)? "checked='checked'" : ""); ?>><label><i></i></label></div> </div>
					<div class="controls-body-row">Дата создания: <strong id="post_date"><?= $file['post_date']; ?></strong></div>
					<div class="controls-body-row">Дата изменения: <strong id="last-modified"><?= $file['post_modified']; ?></strong></div>
					<div class="controls-body-row"><form><button id="save" name = "submitbtn" type="button" class="button-controls save">Обновить</button></form></div>
				</div>
			</div>
			
			<div class="right-block" id="page-template">
				<div class="controls-header">stat():</div>
				<div class="controls-body">
					<div class="controls-body-row">Номер устройства: <strong id="state_date"><?= $file_settings['dev']; ?></strong></div>
					<div class="controls-body-row">Номер inode: <strong id="state_date"><?= $file_settings['ino']; ?></strong></div>
					<div class="controls-body-row">режим защиты inode: <strong id="state_date"><?= $file_settings['mode']; ?></strong></div>
					<div class="controls-body-row">количество ссылок: <strong id="state_date"><?= $file_settings['nlink']; ?></strong></div>
					<div class="controls-body-row">userid владельца: <strong id="state_date"><?= $file_settings['uid']; ?></strong></div>
					<div class="controls-body-row">groupid владельца: <strong id="state_date"><?= $file_settings['gid']; ?></strong></div>
					<div class="controls-body-row">тип устройства, если устройство inode: <strong id="state_date"><?= $file_settings['rdev']; ?></strong></div>
					<div class="controls-body-row">типразмер в байтах: <strong id="state_date"><?= $file_settings['size']; ?></strong></div>
					<div class="controls-body-row">время последнего доступа (временная метка Unix): <strong id="state_date"><?= $file_settings['atime']; ?></strong></div>
					<div class="controls-body-row">время последней модификации (временная метка Unix): <strong id="state_date"><?= $file_settings['mtime']; ?></strong></div>
					<div class="controls-body-row">размер блока ввода-вывода файловой системы: <strong id="state_date"><?= $file_settings['blksize']; ?></strong></div>
					<div class="controls-body-row">количество используемых 512-байтных блоков: <strong id="state_date"><?= $file_settings['blocks']; ?></strong></div>
				</div>
			</div>
			
		</td>
	</tr>
	</table>
</div>
<?php endif; ?>