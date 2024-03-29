<h2><?php echo UPLOAD_MEDIA ?></h2>
<?php if(file_exists('../Plugins/fileupload/') && in_array('fileupload', $plugins)) { 
$url_website = $system_config->full_url();
?>
<div class="media">
	<!-- The file upload form used as target for the file upload widget -->
	<form id="fileupload" action="../Plugins/fileupload/files/server/php/index.php" method="POST" enctype="multipart/form-data">
		<!-- Redirect browsers with JavaScript disabled to the origin page -->
		<noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<div class="row fileupload-buttonbar">
			<div class="col-lg-7">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>
					<span>Add files...</span>
					<input type="file" name="files[]" multiple />
				</span>
				<button type="submit" class="btn btn-primary start">
					<i class="glyphicon glyphicon-upload"></i>
					<span>Start upload</span>
				</button>
				<button type="reset" class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel upload</span>
				</button>
				<button type="button" class="btn btn-danger delete">
					<i class="glyphicon glyphicon-trash"></i>
					<span>Delete selected</span>
				</button>
				<input type="checkbox" class="toggle" />
				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
			</div>
			<!-- The global progress state -->
			<div class="col-lg-5 fileupload-progress fade">
				<!-- The global progress bar -->
				<div
				class="progress progress-striped active"
				role="progressbar"
				aria-valuemin="0"
				aria-valuemax="100"
				>
					<div
					class="progress-bar progress-bar-success"
					style="width: 0%;"
					></div>
				</div>
				<!-- The extended global progress state -->
				<div class="progress-extended">&nbsp;</div>
			</div>
		</div>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped">
			<tbody class="files"></tbody>
		</table>
	</form>
</div>

<!-- The blueimp Gallery widget -->
<div
  id="blueimp-gallery"
  class="blueimp-gallery blueimp-gallery-controls"
  aria-label="image gallery"
  aria-modal="true"
  role="dialog"
  data-filter=":even"
>
  <div class="slides" aria-live="polite"></div>
  <h3 class="title"></h3>
  <a
	class="prev"
	aria-controls="blueimp-gallery"
	aria-label="previous slide"
	aria-keyshortcuts="ArrowLeft"
  ></a>
  <a
	class="next"
	aria-controls="blueimp-gallery"
	aria-label="next slide"
	aria-keyshortcuts="ArrowRight"
  ></a>
  <a
	class="close"
	aria-controls="blueimp-gallery"
	aria-label="close"
	aria-keyshortcuts="Escape"
  ></a>
  <a
	class="play-pause"
	aria-controls="blueimp-gallery"
	aria-label="play slideshow"
	aria-keyshortcuts="Space"
	aria-pressed="false"
	role="button"
  ></a>
  <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
  {% for (var i=0, file; file=o.files[i]; i++) { %}
	  <tr class="template-upload fade{%=o.options.loadImageFileTypes.test(file.type)?' image':''%}">
		  <td>
			  <span class="preview"></span>
		  </td>
		  <td>
			  <p class="name">{%=file.name%}</p>
			  <strong class="error text-danger"></strong>
		  </td>
		  <td>
			  <p class="size">Processing...</p>
			  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		  </td>
		  <td>
			  {% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
				<button class="btn btn-success edit" data-index="{%=i%}" disabled>
					<i class="glyphicon glyphicon-edit"></i>
					<span>Edit</span>
				</button>
			  {% } %}
			  {% if (!i && !o.options.autoUpload) { %}
				  <button class="btn btn-primary start" disabled>
					  <i class="glyphicon glyphicon-upload"></i>
					  <span>Start</span>
				  </button>
			  {% } %}
			  {% if (!i) { %}
				  <button class="btn btn-warning cancel">
					  <i class="glyphicon glyphicon-ban-circle"></i>
					  <span>Cancel</span>
				  </button>
			  {% } %}
		  </td>
	  </tr>
  {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
  {% for (var i=0, file; file=o.files[i]; i++) { %}
	  <tr class="template-download fade{%=file.thumbnailUrl?' image':''%}">
		  <td>
			  <span class="preview">
				  {% if (file.thumbnailUrl) { %}
					  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
				  {% } %}
			  </span>
		  </td>
		  <td>
			  <p class="name">
				  {% if (file.url) { %}
					  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
				  {% } else { %}
					  <span>{%=file.name%}</span>
				  {% } %}
			  </p>
			  {% if (file.error) { %}
				  <div><span class="label label-danger">Error</span> {%=file.error%}</div>
			  {% } %}
		  </td>
		  <td>
			  <span class="size">{%=o.formatFileSize(file.size)%}</span>
		  </td>
		  <td>
			  {% if (file.deleteUrl) { %}
				  <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
					  <i class="glyphicon glyphicon-trash"></i>
					  <span>Delete</span>
				  </button>
				  <input type="checkbox" name="delete" value="1" class="toggle">
			  {% } else { %}
				  <button class="btn btn-warning cancel">
					  <i class="glyphicon glyphicon-ban-circle"></i>
					  <span>Cancel</span>
				  </button>
			  {% } %}
		  </td>
	  </tr>
  {% } %}
</script>
<?php } ?>
<h2><?php echo SHOW_MEDIAS ?></h2>
<?php echo $error; ?>
<div class="row">
    <div class="col-md-12">
		<button onclick="window.location.reload();" class="btn btn-success"><?php echo MEDIA_REFRESH ?></button>
	</div>
</div>
<form action="index.php?page=Media&action=process_media" method="post" class="media_manager">
    <div class="row">
        <div class="col-md-2">
        	<div class="well">
                <table class="table-info table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <?php echo MEDIA_LIST ?>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><?php echo MEDIA_LIST ?></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
						$folders = scandir($folder);
						foreach ($folders as $al_key => $al_value) {
							if($al_value != '.'){
								if ($al_value == '..') {
									$folder_parent = $folder;
									$folder_parent = explode('/', $folder_parent);
									$new_path = array_pop($folder_parent);
									$folder_parent = implode('/', $folder_parent);
									if($folder_parent != '..'){
									?>	
									<tr>
										<td>
                                            <a href="index.php?page=Media&action=media_browse&folder=<?php echo $folder_parent; ?>&CKEditor=editor&CKEditorFuncNum=1&langCode=en" style="color: #ffffff; padding: 0px;" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-arrow-left"></span>
                                            </a>
										</td>
									</tr>
							<?php 
									}
								} else {
							?>
                            	<?php if (is_dir($folder.'/'.$al_value)){ ?>
									<tr>
										<td>
											<label class="label label-warning">
                                                <a href="index.php?page=Media&action=media_browse&folder=<?php echo $folder; ?>/<?php echo $al_value; ?>&CKEditor=editor&CKEditorFuncNum=1&langCode=en" style="color: #ffffff;">
                                                    <?php 
                                                        echo $al_value;
                                                    ?>
                                                </a>
                                            </label>
										</td>
									</tr>	
									<?php }
								}
							}
                        }
                        ?>
                	</tbody>
                </table>
        	</div>
        </div>
        <div class="col-md-10">
        	<div class="text-success" style="display:inline-block;">
            	<p><?php echo $folder; ?></p>
            </div>
            <table class="table-info table-striped list">
                <thead>
                    <tr>
                        <th><?php echo SHOW_MEDIAS_PICTURE ?></th>
                        <th><?php echo SHOW_MEDIAS_FILE_NAME ?></th>
                        <th><?php echo SHOW_MEDIAS_FILE_SIZE ?> | <?php echo SHOW_MEDIAS_MIME_TYPE ?></th>
                        <th><?php echo SHOW_MEDIAS_MOVE_FOLDER ?></th>
                        <th><?php echo SHOW_MEDIAS_COPY_FILE ?></th>
                        <th><?php echo SHOW_MEDIAS_DELETE ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><?php echo SHOW_MEDIAS_PICTURE ?></th>
                        <th><?php echo SHOW_MEDIAS_FILE_NAME ?></th>
                        <th><?php echo SHOW_MEDIAS_FILE_SIZE ?> | <?php echo SHOW_MEDIAS_MIME_TYPE ?></th>
                        <th><?php echo SHOW_MEDIAS_MOVE_FOLDER ?></th>
                        <th><?php echo SHOW_MEDIAS_COPY_FILE ?></th>
                        <th><?php echo SHOW_MEDIAS_DELETE ?></th>
                    </tr>
                </tfoot>
                <tbody>
                <?php
                foreach ($folders as $al_key => $al_value) {
                    if (($al_value != '..') && ($al_value != '.') && (!is_dir($folder .'/'. $al_value))) {
                        ?>
                        <tr>
                            <td><a href="<?php echo $folder ?>/<?php echo $al_value; ?>" target="_blank"><img src="<?php echo $folder ?>/<?php echo $al_value; ?>" width="50" height="50" /></a></td>
                            <td><a onclick="returnFileUrl('<?php echo $folder .'/'. $al_value; ?>')" style="cursor:pointer;"><?php echo $al_value; ?></a></td>
                            <td><?php echo filesize($folder .'/'. $al_value); ?> <?php echo SHOW_MEDIAS_BYTES ?> | <?php echo mime_content_type($folder .'/'. $al_value); ?></td>
                            <td>
                            	<input type="hidden" value="<?php echo $folder ?>/<?php echo $al_value; ?>" name="old_path[]" />
                                <select name="new_folder[]">
                                <option value="">
                                    <?php echo SHOW_MEDIAS_MOVE_FOLDER ?>
                                </option>
                                <?php
                                    $folder_parent = $folder;
                                    $folder_parent = explode('/', $folder_parent);
                                    $new_path = array_pop($folder_parent);
                                    $folder_parent = implode('/', $folder_parent);
									if($folder_parent != '..'){
                                ?>
                                <option value="<?php echo $folder_parent ?>/<?php echo $al_value; ?>">
                                    <?php echo $folder_parent ?>/<?php echo $al_value; ?>
                                </option>
                                <?php 
									}
                                    foreach ($folders as $al_key => $al_value2) {
										if(($al_value2 != '..') && ($al_value2 != '.') && (is_dir($folder .'/'. $al_value2))){
                                        ?>
                                            <option value="<?php echo $folder ?>/<?php echo $al_value2; ?>/<?php echo $al_value; ?>">
                                                <?php echo $folder ?>/<?php echo $al_value2; ?>/<?php echo $al_value; ?>
                                            </option>
                                        <?php
										}
                                    }
                                ?>
                                </select>
                            </td>
                            <td><input type="checkbox" name="copy[]" value="1"> <?php echo SHOW_MEDIAS_COPY_FILE ?></td>
                            <td><input type="checkbox" name="images[]" value="<?php echo $folder ?>/<?php echo $al_value; ?>"> <?php echo SHOW_MEDIAS_DELETE ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <input type="submit" class="btn btn-primary" value="<?php echo BUTTON_UPDATE ?>" />
        </div>
    </div>
</form>