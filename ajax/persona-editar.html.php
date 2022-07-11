<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar.html.php') . 's' . '.php'; ?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle"><?php
        if ($o_Persona->getId() == null)
            echo _("Agregar Persona");
        else
            echo _("Editar Persona");
        ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">


    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/' . $Item_Name . 's.html.php' ?>?tipo=<?php
          if ($o_Persona->getId() == null)
              echo "add";
          else
              echo "edit&id=" . $o_Persona->getId();
          ?>">
        <?php if ($o_Persona->getId() != null) echo '<input type="hidden" id="ItemID" name="ItemID" value="' . $o_Persona->getId() . '">'; ?>
        <div class="row">
            <section class="col col-6">
                <fieldset>
                    <legend>Datos Personales</legend>
                    <div class="row">
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                <input type="text" name="nombre" placeholder="Nombre"
                                       value="<?php echo htmlentities($o_Persona->getNombre(), ENT_COMPAT, 'utf-8'); ?>">
                            </label>
                        </section>
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                <input type="text" name="apellido" placeholder="Apellido"
                                       value="<?php echo htmlentities($o_Persona->getApellido(), ENT_COMPAT, 'utf-8'); ?>">
                            </label>
                        </section>
                    </div>

                    <div class="row">
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-info"></i>
                                <input type="text" name="dni" placeholder="DNI"
                                       value="<?php echo htmlentities($o_Persona->getDni(), ENT_COMPAT, 'utf-8'); ?>">
                            </label>
                        </section>
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                                <input type="email" name="email" placeholder="E-mail"
                                       value="<?php echo htmlentities($o_Persona->getEmail(), ENT_COMPAT, 'utf-8'); ?>">
                            </label>
                        </section>
                    </div>


                    <div class="row">
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                <input type="tel" name="telefono" placeholder="Teléfono Movil"
                                       data-mask="+549 (999) 999-9999"
                                       value="<?php echo htmlentities($o_Persona->getTeCelular(), ENT_COMPAT, 'utf-8'); ?>">
                            </label>
                        </section>
                        <section class="col col-6">
                            <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                <input type="tel" name="te_personal" placeholder="Teléfono Fijo"
                                       data-mask="(999) 999-9999"
                                       value="<?php echo htmlentities($o_Persona->getTeFijo(), ENT_COMPAT, 'utf-8'); ?>">
                            </label>
                        </section>
                    </div>

                </fieldset>
            </section>
            <section class="col col-6">
                <fieldset>
                    <legend>Datos de Sincronización</legend>
                    <div class="row">
                        <section class="col col-10" style="width:100%;">
                            <i class="icon-prepend icon-prepend-chosen fa fa-hdd-o"></i>
                            <div class="div-chosen-select">
                                <select name="equipo[]" id="selEquipo" multiple class="chosen-select"
                                        style="width:100%;padding-left: 32px;">
                                    <?php
                                    $a_o_Equipo = Equipo_L::obtenerTodos();
                                    $array_equipos = explode(':', $o_Persona->getEquipos());
                                    if ($a_o_Equipo != null) {
                                        foreach ($a_o_Equipo as $o_Equipo) {
                                            $checked = '';
                                            if (in_array($o_Equipo->getId(), $array_equipos))
                                                $checked = 'selected="selected"';

                                            echo '<option value="' . $o_Equipo->getId() . '" ' . $checked . ' >';
                                            echo $o_Equipo->getDetalle();
                                            echo "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </section>
                    </div>
                </fieldset>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <fieldset>
                    <legend>Datos de Control</legend>

                    <?php if (Config_L::p('usar_legajo')) { ?>
                        <div class="row">
                            <section class="col col-6">
                                <label class="input"> <i class="icon-prepend fa fa-info"></i>
                                    <input type="text" name="legajo" placeholder="Legajo"
                                           value="<?php echo htmlentities($o_Persona->getLegajo(), ENT_COMPAT, 'utf-8'); ?>">
                                </label>
                            </section>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <section class="col col-xs-12">
                            <i class="icon-prepend icon-prepend-chosen fa fa-users"></i>
                            <div class="div-chosen-select">
                                <select name="grupo[]" id="selGrupo" multiple class="chosen-select"
                                        style="width:100%;padding-left: 32px;">
                                    <?php
                                    $a_Grupos_Personas = Grupos_Personas_L::obtenerARRAYPorPersona($o_Persona->getId());
                                    if(!is_null($a_Grupos_Personas)) {
                                        $a_o_Grupos = Grupo_L::obtenerTodos();
                                        //ceho '<pre>';echo print_r($a_Grupos_Personas);echo '</pre>';
                                        if ($a_o_Grupos != null) {
                                            foreach ($a_o_Grupos as $o_Grupo) {
                                                $checked = '';
                                                if (in_array($o_Grupo->getId(), $a_Grupos_Personas))
                                                    $checked = 'selected="selected"';

                                                echo '<option value="' . $o_Grupo->getId() . '" ' . $checked . ' >';
                                                echo $o_Grupo->getDetalle();
                                                echo "</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </section>
                    </div>
                    <?php /* if (Config_L::p('usar_rfid')) { ?>
                        <div class="row">
                            <section class="col col-6">
                                <label class="input"> <i class="icon-prepend fa fa-tag"></i>
                                    <input type="text" name="tag" placeholder="TAG"
                                           value="<?php echo htmlentities($o_Persona->getTag(), ENT_COMPAT, 'utf-8'); ?>">
                                </label>
                            </section>
                        </div>
                    <?php }  */ ?>
                    <div class="row">
                        <section class="col col-6">
                            <label class="select"> <span class="icon-prepend fa fa-clock-o"></span>
                                <select name="horario_tipo" id="selTipo" style="padding-left: 32px;">
                                    <?php echo HtmlHelper::array2htmloptions($a_Tipos_De_Horario, $o_Persona->getHorTipo(), true, false, '', _('Seleccione un Tipo de Horario')); ?>
                                </select> <i></i> </label>
                        </section>
                        <section class="col col-6" id="sel-horarioNormal">
                            <label class="select"> <span class="icon-prepend fa fa-clock-o"></span>
                                <select name="horarioNormId" id="horarioNormId" style="padding-left: 32px;">
                                    <?php echo HtmlHelper::array2htmloptions(Hora_Trabajo_L::obtenerTodos(), $o_Persona->getHorId(), true, true, '', 'Seleccione un Horario'); ?>
                                </select> <i></i> </label>
                        </section>
                        <section class="col col-6" id="sel-horarioFlexible">
                            <label class="select"> <span class="icon-prepend fa fa-clock-o"></span>
                                <select name="horarioFlexId" id="horarioFlexId" style="padding-left: 32px;">
                                    <?php echo HtmlHelper::array2htmloptions(Horario_Flexible_L::obtenerTodos(), $o_Persona->getHorId(), true, true, '', 'Seleccione un Horario'); ?>
                                </select> <i></i> </label>
                        </section>
                        <section class="col col-6" id="sel-horarioRotativo">
                            <label class="select"> <span class="icon-prepend fa fa-clock-o"></span>
                                <select name="horarioRotId" id="horarioRotId" style="padding-left: 32px;">
                                    <?php echo HtmlHelper::array2htmloptions(Horario_Rotativo_L::obtenerTodos(), $o_Persona->getHorId(), true, true, '', 'Seleccione un Horario'); ?>
                                </select> <i></i> </label>
                        </section>
                        <section class="col col-6" id="sel-horarioMultiple">
                            <label class="select"> <span class="icon-prepend fa fa-clock-o"></span>
                                <select name="horarioMultId" id="horarioMultId" style="padding-left: 32px;">
                                    <?php echo HtmlHelper::array2htmloptions(Horario_Multiple_L::obtenerTodos(), $o_Persona->getHorId(), true, true, '', 'Seleccione un Horario'); ?>
                                </select> <i></i> </label>
                        </section>
                    </div>

                </fieldset>
                <fieldset>
                    <legend>Datos de Acceso</legend>
                    <!-- <div class="row">
                        <section class="col col-4">
                            <label class="toggle">
                                <input type="checkbox" id="bloqueado"
                                       name="bloqueado" <?php if ($o_Persona->getEliminadoEl() != null) echo "checked=\"yes\""; ?> >
                                <i data-swchon-text="SI" data-swchoff-text="NO"></i>Bloqueado
                            </label>
                        </section>
                    </div> -->
                    <div class="row">
                        <section class="col col-4">
                            <label class="toggle">
                                <input type="checkbox" id="excluido"
                                       name="excluido" <?php if ($o_Persona->getExcluir() != null) echo "checked=\"yes\""; ?> >
                                <i data-swchon-text="SI" data-swchoff-text="NO"></i>Excluir
                            </label>
                        </section>
                    </div>
                </fieldset>
            </section>

            <section class="col col-6">
                <fieldset>
                    <legend>Imagen de Perfil</legend>
                    <div class="row" id="ImageUpload">
                        <section class="col col-6">
                            <div class="thumbPersonaEditar">
                                <?php
                                if ($o_Persona->getImagen() == '') {
                                    echo '<img src="img/avatars/male-big.png" id="finalImg" alt="me" >';
                                } else {
                                    echo '<img src="imagen.php?per_id=' . $o_Persona->getId() . '" id="finalImg" alt="me" />';
                                }
                                ?>
                                <div id="camara" style="display: none;width: 250px;height: 250px;"></div>
                            </div>
                            <?php if ($o_Persona->getImagen() != '') echo '<span id="btnEliminarImagen"><a href="#" onclick="setEliminarImagen();return false;" >Eliminar Imagen</a></span>'; ?>
                        </section>
                        <section class="col col-6">
                            <div id="dropbox">Arrastra una imagen aquí</div>
                            <div class="upload-progress"></div>
                            <input type="file" id="fileElem" multiple="true" accept="image/*" onchange="handleFiles(this.files)">
                            <button type="button" id="botonCamara"  title="Usar Webcam" class="btn btn-default btn-sm fa fa-camera fa-lg" style="line-height: .75em;padding-right: 5px;padding-left: 9px; float:right;">&nbsp;</button>
                            <button type="button" id="botonSnapshot" class="btn btn-default btn-sm" style="line-height: .75em;padding: 12px;display:none;">Tomar Foto</button>
                            <div id="snapUploadProgress" class="fa fa-cog fa-lg fa-spin" style="line-height: .75em;padding: 12px;display:none;"></div>
                        </section>
                        <input type="hidden" id="inputBorrarImagen" name="inputBorrarImagen"/>
                        <input type="hidden" id="inputImageExtension" name="inputImageExtension"/>
                        <input type="hidden" id="inputIMGx" name="inputIMGx"/>
                        <input type="hidden" id="inputIMGy" name="inputIMGy"/>
                        <input type="hidden" id="inputIMGw" name="inputIMGw"/>
                        <input type="hidden" id="inputIMGh" name="inputIMGh"/>
                        <input type="hidden" id="inputIMGsrc" name="inputIMGsrc" value=""/>
                    </div>


                </fieldset>
            </section>

        </div>

    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-editar">
        <?php
        if ($o_Persona->getId() == null)
            echo _("Agregar");
        else
            echo _("Guardar");
        ?>
    </button>
</div>
<style>
    @media (min-width: 768px) {
        .modal-dialog {
            width: 80% !important;
        }
    }

</style>

</div>
<script type="text/javascript">

    $("#pepe").on($.support.transition.end, function(e){
        e.stopPropagation()
    });




    loadScript("js/plugin/chosen/chosen.jquery.min.js", function () {

        $("#selEquipo").chosen({
            placeholder_text_multiple: 'Seleccione los Equipos',
            width: '100%'
        });

        $("#selGrupo").chosen({
            placeholder_text_multiple: 'Seleccione los Grupos',
            width: '100%'
        });

        loadScript("js/plugin/jcrop/jquery.Jcrop.min.js", function () {
            loadScript("js/plugin/jcrop/jquery.color.min.js", function (){
                loadScript("js/plugin/jpeg-camera/jpeg_camera_with_dependencies.min.js",pagefunction)
            });
        });
    });
    function pagefunction() {


        var dropbox;
        var api;

        dropbox = document.getElementById("dropbox");
        dropbox.addEventListener("dragenter", dragenter, false);
        dropbox.addEventListener("dragleave", dragleave, false);
        dropbox.addEventListener("dragover", dragover, false);
        dropbox.addEventListener("drop", drop, false);

        function defaults(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function dragenter(e) {
            $(this).addClass("active");
            defaults(e);
        }

        function dragover(e) {
            defaults(e);
        }

        function dragleave(e) {
            $(this).removeClass("active");
            defaults(e);
        }

        function drop(e) {
            $(this).removeClass("active");
            defaults(e);

            // dataTransfer -> which holds information about the user interaction, including what files (if any) the user dropped on the element to which the event is bound.
            //console.log(e);
            var dt = e.dataTransfer;
            var files = dt.files;

            handleFiles(files, e);
        }

        handleFiles = function (files, e) {
            // alert(files);
            // Traverse throught all files and check if uploaded file type is image	
            var imageType = /image.*/;
            var file = files[0];
            // check file type
            if (!file.type.match(imageType)) {
                alert("El archivo \"" + file.name + "\" no es una imagen válida.");
                return false;
            }
            // check file size
            if (parseInt(file.size / 1024) > 2050) {
                alert("La imagen \"" + file.name + "\" es muy grande");
                return false;
            }

            $('#inputImageExtension').val(file.type);

            var info = '<div class="preview active-win"><div class="preview-image"><img ></div><div class="progress-holder"><span id="progress"></span></div><span class="percents"></span><div style="float:left;">Uploaded <span class="up-done"></span> KB of ' + parseInt(file.size / 1024) + ' KB</div>';

            $("#dropbox").hide();
            $("#fileElem").hide();

            $(".upload-progress").show(function () {
                $(".upload-progress").html(info);
                uploadFile(file);
            });

        };

        uploadFile = function (file) {
            // check if browser supports file reader object 
            if (typeof FileReader !== "undefined") {
                //alert("uploading "+file.name);  
                reader = new FileReader();
                reader.onload = function (e) {
                    //alert(e.target.result);
                    $('.preview img').attr('src', e.target.result).css("width", "70px").css("height", "70px");
                }
                reader.readAsDataURL(file);

                xhr = new XMLHttpRequest();
                xhr.open("post", "image_upload.php", true);

                xhr.upload.addEventListener("progress", function (event) {
                    //console.log(event);
                    if (event.lengthComputable) {
                        $("#progress").css("width", (event.loaded / event.total) * 100 + "%");
                        $(".percents").html(" " + ((event.loaded / event.total) * 100).toFixed() + "%");
                        $(".up-done").html((parseInt(event.loaded / 1024)).toFixed(0));
                    }
                    else {
                        alert("Failed to compute file upload length");
                    }
                }, false);

                xhr.onreadystatechange = function (oEvent) {
                    //console.log(oEvent);
                    //console.log(xhr);
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            $("#progress").css("width", "100%");
                            $(".percents").html("100%");
                            $(".up-done").html((parseInt(file.size / 1024)).toFixed(0));
                            //if reach here means the image uploaded ok

                            $(".upload-progress").hide();
                            $(".upload-progress").after("<div id=\"imgCropDiv\" style=\"overflow:hidden;\"><img id=\"imgCrop\" src=\"imagen.php?temp_img=" + xhr.responseText + "\" /></div>");
                            //<button type=\"button\" class=\"btn btn-default\" id=\"CancelCrop\" style=\"padding: 6px 12px;margin-top: 10px;\">Cancelar</button>
                            $("#finalImg").attr("src", "imagen.php?temp_img=" + xhr.responseText);
                            $("#inputIMGsrc").attr("value", xhr.responseText);
                            api = $('#imgCrop').Jcrop({
                                onChange: showPreview,
                                onSelect: showPreview,
                                boxWidth: 250,
                                boxHeight: 250,
                                aspectRatio: 1,
                                setSelect: [($('#imgCrop').width() / 2) - 250,
                                    ($('#imgCrop').height() / 2) - 250,
                                    ($('#imgCrop').width() / 2) + 250,
                                    ($('#imgCrop').height() / 2) + 250
                                ]
                            });
                            //$('#CancelCrop').click(function(){
                            //		debugger;
                            //	api.disable();
                            //});

                        } else {
                            alert("Error" + xhr.statusText);
                        }
                    }
                };

                // Set headers
                xhr.setRequestHeader("Content-Type", "multipart/form-data");
                xhr.setRequestHeader("X-File-Name", file.fileName);
                xhr.setRequestHeader("X-File-Size", file.fileSize);
                xhr.setRequestHeader("X-File-Type", file.type);

                // Send the file (doh)
                xhr.send(file);

            } else {
                alert("Your browser doesnt support FileReader object");
            }
        };


        function showPreview(coords) {
            var maxX = 250;
            var maxY = 250;

            var rx = maxX / coords.w;
            var ry = maxY / coords.h;

            rx = (rx == 0) ? 1 : rx;
            ry = (ry == 0) ? 1 : ry;

            photoX = $("#imgCrop").width();
            photoY = $("#imgCrop").height();

            $("#finalImg").css({
                width: Math.round(rx * photoX) + 'px',
                height: Math.round(ry * photoY) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });

            $('#inputIMGx').val(coords.x);
            $('#inputIMGy').val(coords.y);
            $('#inputIMGw').val(coords.w);
            $('#inputIMGh').val(coords.h);
        }

        var options = {
            shutter_ogg_url: "js/plugin/jpeg-camera/shutter.ogg",
            shutter_mp3_url: "js/plugin/jpeg-camera/shutter.mp3",
            swf_url: "js/plugin/jpeg-camera/jpeg_camera.swf",
            mirror: true
        };

        var camera;

        $('#botonCamara').click(function () {
            $('#camara').show();
            $('#finalImg').hide();
            $('#botonSnapshot').show();
            $('#botonCamara').hide();
            $('#dropbox').hide();
            $('#fileElem').hide();

            camera = new JpegCamera("#camara", options);

            camera.message.innerHTML = "Por favor, permita el acceso a la camara cuando el navegador lo pida. <br><br>Busca el icono de la camara en la barra de direcciones."

        });

        $('#botonSnapshot').click(function () {
            var snapshot = camera.capture();

            snapshot.show();
            camera.activeTrack.stop();
            camera.audio_context.close();

            $('#botonSnapshot').hide();
            $('#snapUploadProgress').show();
            $('#submit-editar').prop('disabled', true);
            $('#submit-editar').prop('title', 'Espere a que se termine de procesar la imagen');


            snapshot.upload({api_url: "image_upload.php"}).done(function(response) {

                $('#camara').html("<img id=\"finalImgCamera\" src=\"imagen.php?temp_img=" + response + "\" />");
                $("#finalImgCamera").load(function() {
                    //esto es para asignar los datos de la imagen, una vez que esta se subio al servidor y es descargadaal navegador
                    var img = document.getElementById('finalImgCamera');
                    $('#inputIMGw').val(img.naturalWidth);
                    $('#inputIMGh').val(img.naturalWidth);  //los dos en width para que sea cuadrada
                    $('#inputIMGx').val(0);
                    $('#inputIMGy').val(0);
                    $('#submit-editar').prop('disabled', false);
                    $('#submit-editar').prop('title', '');
                });
                $("#inputIMGsrc").attr("value", response);
                $('#inputImageExtension').val("image/jpg");
                $('#botonCamara').show();
                $('#snapUploadProgress').hide();
                this.discard(); // discard snapshot and show video stream again
            }).fail(function(status_code, error_message, response) {
                alert("Upload failed with status " + status_code);
            });

        });

    }


    $(function () {
        // Validation


        $("#editar-form").validate({
            // Rules for form validation
            rules: {
                nombre: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                apellido: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                email: {
                    required: false,
                    email: true
                },
                dni: {
                    required: true,
                    minlength: 8,
                    maxlength: 8,
                    remote: {
                        url: "<?php echo 'ajax/' . $Item_Name . 's.html.php' ?>",
                        type: "post",
                        data: {'tipo': 'check', 'tipo_check': 'c_dni', 'id': $("#ItemID").val()},
                        dataFilter: function (data) {
                            if (data.responseText !== "true") {
                                return "\"" + data + "\"";
                            } else {
                                return success;
                            }
                        }
                    }
                },
                <?php if(Config_L::p('usar_legajo')){ ?>
                legajo: {
                    required: true,
                    minlength: 2,
                    maxlength: 20,
                    remote: {
                        url: "<?php echo 'ajax/' . $Item_Name . 's.html.php' ?>",
                        type: "post",
                        data: {'tipo': 'check', 'tipo_check': 'c_legajo', 'id': $("#ItemID").val()},
                        dataFilter: function (data) {
                            if (data.responseText !== "true") {
                                return "\"" + data + "\"";
                            } else {
                                return success;
                            }
                        }
                    }
                },
                <?php } ?>
                horarioNormId: {
                    required: "#horarioNormId:visible"
                },
                horarioFlexId: {
                    required: "#horarioFlexId:visible"
                },
                horarioRotId: {
                    required: "#horarioRotId:visible"
                },
                horarioMultId: {
                    required: "#horarioMultId:visible"
                } /*,
                'grupo[]': {
                    minlength: 1,
                    required: true
                },
                'equipo[]': {
                    minlength: 1,
                    required: true
                }  */
            },
            // Messages for form validation
            messages: {
                nombre: {
                    required: '<?php echo _('Por favor ingrese el nombre') ?>',
                    minlength: '<?php echo _('El nombre ingresado es muy corto.') ?>',
                    maxlength: '<?php echo _('El nombre ingresado es muy largo.') ?>'
                },
                apellido: {
                    required: '<?php echo _('Por favor ingrese el apellido ') ?>',
                    minlength: '<?php echo _('El apellido ingresado es muy corto.') ?>',
                    maxlength: '<?php echo _('El apellido ingresado es muy largo.') ?>'
                },
                email: {
                    required: '<?php echo _('Por favor ingrese un email') ?>',
                    email: '<?php echo _('Por favor ingrese un email válido') ?>'
                },
                dni: {
                    required: '<?php echo _('Por favor ingrese el DNI') ?>',
                    minlength: '<?php echo _('El DNI es muy corto. Debe ser de 8 caracteres, por ej.: 12346578') ?>',
                    maxlength: '<?php echo _('El DNI es muy largo. Debe ser de 10 caracteres, por ej.: 12345678') ?>'
                },
                tag: {
                    required: '<?php echo _('Por favor ingrese el TAG') ?>',
                    minlength: '<?php echo _('El TAG es muy corto. Debe ser de 10 caracteres, por ej.: 0000ABCDEF') ?>',
                    maxlength: '<?php echo _('El TAG es muy largo. Debe ser de 10 caracteres, por ej.: 0000ABCDEF') ?>'
                },
                horario_tipo: {
                    required: '<?php echo _('Por favor seleccione un tipo de horario de trabajo') ?>'
                },
                horarioNormId: {
                    required: "Seleccione un Horario"
                },
                horarioFlexId: {
                    required: "Seleccione un Horario"
                },
                horarioRotId: {
                    required: "Seleccione un Horario"
                },
                horarioMultId: {
                    required: "Seleccione un Horario"
                },
                'grupo[]': {
                    required: '<?php echo _('Por favor seleccione al menos un grupo') ?>'
                },
                'equipo[]': {
                    required: '<?php echo _('Por favor seleccione al menos un equipo') ?>'
                },
                legajo: {
                    required: '<?php echo _('Por favor ingrese un legajo') ?>',
                    minlength: '<?php echo _('El legajo es muy corto.') ?>',
                    maxlength: '<?php echo _('El legajo es muy largo.') ?>'
                }
            },
            ignore: ':hidden:not("#selGrupo"):not("#selEquipo")',
            // Do not change code below
            errorPlacement: function (error, element) {
                if (element.parent('.div-chosen-select').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });


    function setEliminarImagen(e) {
        $("#finalImg").attr("src", "img/avatars/male-big.png");
        $('#inputBorrarImagen').val('true');
        $('#btnEliminarImagen').remove();
    }


    $(document).ready(function () {


        $('#selTipo').change(function () {

            if ($(this).find('option:selected').attr('value') ==<?php echo HORARIO_NORMAL; ?>) {
                $('#sel-horarioNormal').show();
                $('#sel-horarioFlexible').hide();
                $('#sel-horarioRotativo').hide();
                $('#sel-horarioMultiple').hide();
            } else if ($(this).find('option:selected').attr('value') ==<?php echo HORARIO_FLEXIBLE; ?>) {
                $('#sel-horarioNormal').hide();
                $('#sel-horarioFlexible').show();
                $('#sel-horarioRotativo').hide();
                $('#sel-horarioMultiple').hide();
            } else if ($(this).find('option:selected').attr('value') ==<?php echo HORARIO_ROTATIVO; ?>) {
                $('#sel-horarioNormal').hide();
                $('#sel-horarioFlexible').hide();
                $('#sel-horarioRotativo').show();
                $('#sel-horarioMultiple').hide();
            }else if ($(this).find('option:selected').attr('value') ==<?php echo HORARIO_MULTIPLE; ?>) {
                $('#sel-horarioNormal').hide();
                $('#sel-horarioFlexible').hide();
                $('#sel-horarioRotativo').hide();
                $('#sel-horarioMultiple').show();
            } else {
                $('#sel-horarioNormal').hide();
                $('#sel-horarioFlexible').hide();
                $('#sel-horarioRotativo').hide();
                $('#sel-horarioMultiple').hide();
            }
        });
        $('#selTipo').trigger("change");


        $('#submit-editar').click(function () {
            var $form = $('#editar-form');

            if (!$('#editar-form').valid()) {
                return false;
            } else {
                $('#editar').modal('hide');
                function showProcesando() {
                    $('#content').css({opacity: '0.0'}).html("<div style=\"padding:15px;height:75px;\"><h1 class=\"ajax-loading-animation\"><i class=\"fa fa-cog fa-spin\"></i> Procesando...</h1></div>").delay(50).animate({opacity: '1.0'}, 300);
                }
                setTimeout(showProcesando, 300);

                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    async: true,
                    success: function (data, status) {
                        $('#editar').modal('hide');
                        function refreshpage() {
                            $('#content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);
                            //$('body').removeData('.modal-content');
                        }
                        setTimeout(refreshpage, 200);
                    }
                });

            }

        });


    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });


</script>
